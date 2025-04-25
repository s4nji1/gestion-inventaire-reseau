<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\MaintenanceRecords;
use App\Models\Status;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class MaintenanceRecordsController extends Controller
{
    /**
     * Display a listing of the maintenance records.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $maintenanceRecords = MaintenanceRecords::with('equipment')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('maintenance.index', compact('maintenanceRecords'));
    }

    /**
     * Show the form for creating a new maintenance record.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $equipment = Equipment::orderBy('name')->get();
        
        return view('maintenance.create', compact('equipment'));
    }

    /**
     * Store a newly created maintenance record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'maintenance_type' => 'required|string|max:255',
            'issue_description' => 'required|string',
            'resolution_description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);
        
        DB::beginTransaction();
        try {
            // Create the maintenance record
            $maintenanceRecord = MaintenanceRecords::create($validated);
            
            // If in progress or completed, update the equipment status to maintenance
            if (in_array($validated['status'], ['in_progress']) && $request->has('update_equipment_status')) {
                $equipment = Equipment::findOrFail($validated['equipment_id']);
                $oldStatusId = $equipment->status_id;
                
                // Find the maintenance status
                $maintenanceStatus = Status::where('slug', 'maintenance')->first();
                
                if ($maintenanceStatus) {
                    // Update equipment status
                    $equipment->status_id = $maintenanceStatus->id;
                    $equipment->save();
                    
                    // Create a movement record
                    Movement::create([
                        'equipment_id' => $equipment->id,
                        'type' => 'maintenance',
                        'from_status_id' => $oldStatusId,
                        'to_status_id' => $maintenanceStatus->id,
                        'notes' => 'Status changed due to maintenance record creation: ' . $validated['maintenance_type'],
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('maintenance.index')
                ->with('success', 'Maintenance record created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create maintenance record: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified maintenance record.
     *
     * @param  \App\Models\MaintenanceRecords  $maintenanceRecord
     * @return \Illuminate\View\View
     */
    public function show(MaintenanceRecords $maintenanceRecord): View
    {
        $maintenanceRecord->load('equipment.category');
        
        return view('maintenance.show', compact('maintenanceRecord'));
    }

    /**
     * Show the form for editing the specified maintenance record.
     *
     * @param  \App\Models\MaintenanceRecords  $maintenanceRecord
     * @return \Illuminate\View\View
     */
    public function edit(MaintenanceRecords $maintenanceRecord): View
    {
        $equipment = Equipment::orderBy('name')->get();
        
        return view('maintenance.edit', compact('maintenanceRecord', 'equipment'));
    }

    /**
     * Update the specified maintenance record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaintenanceRecords  $maintenanceRecord
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, MaintenanceRecords $maintenanceRecord): RedirectResponse
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'maintenance_type' => 'required|string|max:255',
            'issue_description' => 'required|string',
            'resolution_description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);
        
        DB::beginTransaction();
        try {
            // Update the maintenance record
            $oldStatus = $maintenanceRecord->status;
            $maintenanceRecord->update($validated);
            
            // If status changed to completed and the checkbox is checked
            if ($oldStatus != 'completed' && $validated['status'] == 'completed' && $request->has('update_equipment_status')) {
                $equipment = Equipment::findOrFail($validated['equipment_id']);
                $oldStatusId = $equipment->status_id;
                
                // Find the available/operational status
                $availableStatus = Status::where('slug', 'available')->first() 
                    ?? Status::where('slug', 'operational')->first();
                
                if ($availableStatus) {
                    // Update equipment status
                    $equipment->status_id = $availableStatus->id;
                    $equipment->save();
                    
                    // Create a movement record
                    Movement::create([
                        'equipment_id' => $equipment->id,
                        'type' => 'entry',
                        'from_status_id' => $oldStatusId,
                        'to_status_id' => $availableStatus->id,
                        'notes' => 'Status changed due to maintenance completion: ' . $validated['maintenance_type'],
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('maintenance.show', $maintenanceRecord)
                ->with('success', 'Maintenance record updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update maintenance record: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified maintenance record from storage.
     *
     * @param  \App\Models\MaintenanceRecords  $maintenanceRecord
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MaintenanceRecords $maintenanceRecord): RedirectResponse
    {
        try {
            $maintenanceRecord->delete();
            return redirect()->route('maintenance.index')
                ->with('success', 'Maintenance record deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('maintenance.index')
                ->with('error', 'Failed to delete maintenance record: ' . $e->getMessage());
        }
    }
    
    /**
     * Search for maintenance records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View
    {
        $query = $request->input('query');
        
        $maintenanceRecords = MaintenanceRecords::with('equipment')
            ->whereHas('equipment', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('serial_number', 'like', "%{$query}%");
            })
            ->orWhere('maintenance_type', 'like', "%{$query}%")
            ->orWhere('issue_description', 'like', "%{$query}%")
            ->orWhere('resolution_description', 'like', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(['query' => $query]);
            
        return view('maintenance.index', compact('maintenanceRecords', 'query'));
    }
    
    /**
     * Filter maintenance records by status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function filter(Request $request): View
    {
        $status = $request->input('status');
        
        $query = MaintenanceRecords::with('equipment');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $maintenanceRecords = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(['status' => $status]);
            
        return view('maintenance.index', compact('maintenanceRecords', 'status'));
    }
}