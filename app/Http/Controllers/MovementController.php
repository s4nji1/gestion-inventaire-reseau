<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Equipment;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class MovementController extends Controller
{
    /**
     * Display a listing of the movements.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $movements = Movement::with(['equipment', 'fromStatus', 'toStatus'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('movement.index', compact('movements'));
    }

    /**
     * Show the form for creating a new movement.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $equipment = Equipment::with('status')->orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();

        return view('movement.create', compact('equipment', 'statuses'));
    }

    /**
     * Store a newly created movement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'type' => 'required|in:entry,exit,maintenance',
            'to_status_id' => 'required|exists:statuses,id',
            'notes' => 'nullable|string',
        ]);

        // Get the current status of the equipment
        $equipment = Equipment::findOrFail($validated['equipment_id']);
        $validated['from_status_id'] = $equipment->status_id;

        DB::beginTransaction();
        try {
            // Create the movement record
            $movement = Movement::create($validated);

            // Update the equipment status
            $equipment->status_id = $validated['to_status_id'];
            $equipment->save();

            DB::commit();
            return redirect()->route('movement.index')
                ->with('success', 'Movement record created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create movement record: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified movement.
     *
     * @param  \App\Models\Movement  $movement
     * @return \Illuminate\View\View
     */
    public function show(Movement $movement): View
    {
        $movement->load(['equipment.category', 'fromStatus', 'toStatus']);

        return view('movement.show', compact('movement'));
    }

    /**
     * Show the form for editing the specified movement.
     *
     * @param  \App\Models\Movement  $movement
     * @return \Illuminate\View\View
     */
    public function edit(Movement $movement): View
    {
        $equipment = Equipment::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();

        return view('movement.edit', compact('movement', 'equipment', 'statuses'));
    }

    /**
     * Update the specified movement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movement  $movement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Movement $movement): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:entry,exit,maintenance',
            'notes' => 'nullable|string',
        ]);

        // Only allow updating type and notes, not the equipment or statuses
        // This prevents inconsistencies in the movement history

        $movement->update($validated);

        return redirect()->route('movement.show', $movement)
            ->with('success', 'Movement record updated successfully.');
    }

    /**
     * Remove the specified movement from storage.
     *
     * @param  \App\Models\Movement  $movement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Movement $movement): RedirectResponse
    {
        // Check if this is the latest movement for the equipment
        $latestMovement = Movement::where('equipment_id', $movement->equipment_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($latestMovement->id == $movement->id) {
            return redirect()->route('movement.index')
                ->with('error', 'Cannot delete the latest movement record for an equipment. This would create inconsistency in status history.');
        }

        try {
            $movement->delete();
            return redirect()->route('movement.index')
                ->with('success', 'Movement record deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('movement.index')
                ->with('error', 'Failed to delete movement record: ' . $e->getMessage());
        }
    }

    /**
     * Search for movements.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View
    {
        $query = $request->input('query');

        $movements = Movement::with(['equipment', 'fromStatus', 'toStatus'])
            ->whereHas('equipment', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('serial_number', 'like', "%{$query}%");
            })
            ->orWhere('notes', 'like', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(['query' => $query]);

        return view('movement.index', compact('movements', 'query'));
    }

    /**
     * Filter movements by type or status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function filter(Request $request): View
    {
        $type = $request->input('type');
        $statusId = $request->input('status_id');

        $query = Movement::with(['equipment', 'fromStatus', 'toStatus']);

        if ($type) {
            $query->where('type', $type);
        }

        if ($statusId) {
            $query->where(function ($q) use ($statusId) {
                $q->where('from_status_id', $statusId)
                    ->orWhere('to_status_id', $statusId);
            });
        }

        $movements = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends([
                'type' => $type,
                'status_id' => $statusId
            ]);

        $statuses = Status::orderBy('name')->get();

        return view('movement.index', compact('movements', 'type', 'statusId', 'statuses'));
    }

    /**
     * Get equipment history (all movements for a specific equipment).
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\View\View
     */
    public function history(Equipment $equipment): View
    {
        $movements = Movement::with(['fromStatus', 'toStatus'])
            ->where('equipment_id', $equipment->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('movement.history', compact('equipment', 'movements'));
    }

    // In MovementController
    public function exportCSV()
    {
        $movements = Movement::with(['equipment', 'fromStatus', 'toStatus'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="movements_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($movements) {
            $file = fopen('php://output', 'w');

            // Write headers
            fputcsv($file, [
                'ID',
                'Equipment Name',
                'Equipment Serial Number',
                'Movement Type',
                'From Status',
                'To Status',
                'Notes',
                'Date'
            ]);

            // Write data
            foreach ($movements as $movement) {
                fputcsv($file, [
                    $movement->id,
                    $movement->equipment->name,
                    $movement->equipment->serial_number,
                    $movement->type,
                    $movement->fromStatus ? $movement->fromStatus->name : 'Initial Entry',
                    $movement->toStatus->name,
                    $movement->notes ?? '',
                    $movement->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}