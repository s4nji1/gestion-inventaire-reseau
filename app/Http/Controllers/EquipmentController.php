<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Category;
use App\Models\Status;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the equipment.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $equipment = Equipment::with(['category', 'status'])
            ->orderBy('name')
            ->paginate(15);

        $categories = Category::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();

        return view('equipment.index', compact('equipment', 'categories', 'statuses'));
    }

    /**
     * Show the form for creating a new equipment.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();

        return view('equipment.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created equipment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:equipment,serial_number',
            'mac_address' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $equipment = Equipment::create($validated);

            // Create a movement for the new equipment
            Movement::create([
                'equipment_id' => $equipment->id,
                'type' => 'entry',
                'from_status_id' => null,
                'to_status_id' => $request->status_id,
                'notes' => 'Initial entry of equipment',
            ]);

            DB::commit();
            return redirect()->route('equipment.index')
                ->with('success', 'Equipment added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to add equipment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified equipment.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\View\View
     */
    public function show(Equipment $equipment): View
    {
        $equipment->load([
            'category',
            'status',
            'movements' => function ($query) {
                $query->with(['fromStatus', 'toStatus'])->orderBy('created_at', 'desc');
            }
        ]);

        // Check if the relationship method is MaintenanceRecords (capital) or maintenanceRecords (lowercase)
        if (method_exists($equipment, 'maintenanceRecords')) {
            $equipment->load([
                'maintenanceRecords' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ]);
        } else {
            $equipment->load([
                'MaintenanceRecords' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ]);
        }

        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified equipment.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\View\View
     */
    public function edit(Equipment $equipment): View
    {
        $categories = Category::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();

        return view('equipment.edit', compact('equipment', 'categories', 'statuses'));
    }

    /**
     * Update the specified equipment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Equipment $equipment): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'serial_number' => [
                'required',
                'string',
                Rule::unique('equipment')->ignore($equipment->id),
            ],
            'mac_address' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'notes' => 'nullable|string',
            'movement_notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Check if status has changed
            $oldStatusId = $equipment->status_id;
            $newStatusId = $request->status_id;

            $equipment->update($validated);

            // Create a movement entry if status changed
            if ($oldStatusId != $newStatusId) {
                // Get maintenance status - safely
                $maintenanceStatus = Status::where('slug', 'maintenance')->first();
                $movementType = 'exit'; // Default movement type

                if ($maintenanceStatus && $newStatusId == $maintenanceStatus->id) {
                    $movementType = 'maintenance';
                }

                Movement::create([
                    'equipment_id' => $equipment->id,
                    'type' => $movementType,
                    'from_status_id' => $oldStatusId,
                    'to_status_id' => $newStatusId,
                    'notes' => $request->movement_notes ?? 'Status changed during equipment update',
                ]);
            }

            DB::commit();
            return redirect()->route('equipment.show', $equipment)
                ->with('success', 'Equipment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update equipment: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified equipment from storage.
     *
     * @param  \App\Models\Equipment  $equipment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Equipment $equipment): RedirectResponse
    {
        try {
            $equipment->delete();
            return redirect()->route('equipment.index')
                ->with('success', 'Equipment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('equipment.index')
                ->with('error', 'Failed to delete equipment: ' . $e->getMessage());
        }
    }

    /**
     * Search for equipment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View
    {
        $query = $request->input('query');

        $equipment = Equipment::with(['category', 'status'])
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('serial_number', 'like', "%{$query}%")
                    ->orWhere('mac_address', 'like', "%{$query}%")
                    ->orWhere('brand', 'like', "%{$query}%")
                    ->orWhere('model', 'like', "%{$query}%");
            })
            ->paginate(15)
            ->appends(['query' => $query]);

        $categories = Category::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();

        return view('equipment.index', compact('equipment', 'categories', 'statuses', 'query'));
    }

    /**
     * Filter equipment by category and status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function filter(Request $request): View
    {
        $categoryId = $request->input('category_id');
        $statusId = $request->input('status_id');

        $query = Equipment::with(['category', 'status']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($statusId) {
            $query->where('status_id', $statusId);
        }

        $equipment = $query->orderBy('name')->paginate(15)
            ->appends(['category_id' => $categoryId, 'status_id' => $statusId]);

        $categories = Category::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();

        return view('equipment.index', compact('equipment', 'categories', 'statuses', 'categoryId', 'statusId'));
    }

    public function exportCSV()
    {
        $equipment = Equipment::with(['category', 'status'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="equipment_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($equipment) {
            $file = fopen('php://output', 'w');

            // Write headers
            fputcsv($file, [
                'ID',
                'Name',
                'Brand',
                'Model',
                'Serial Number',
                'MAC Address',
                'Category',
                'Status',
                'Notes',
                'Created At',
                'Updated At'
            ]);

            // Write data
            foreach ($equipment as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name,
                    $item->brand,
                    $item->model,
                    $item->serial_number,
                    $item->mac_address,
                    $item->category->name,
                    $item->status->name,
                    $item->notes,
                    $item->created_at->format('Y-m-d H:i:s'),
                    $item->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportFilteredCSV(Request $request)
    {
        $query = Equipment::query()->with(['category', 'status']);

        // Apply filters if provided
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->input('status_id'));
        }

        $equipment = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="equipment_filtered_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($equipment) {
            $file = fopen('php://output', 'w');

            // Write headers
            fputcsv($file, [
                'ID',
                'Name',
                'Brand',
                'Model',
                'Serial Number',
                'MAC Address',
                'Category',
                'Status',
                'Notes',
                'Created At',
                'Updated At'
            ]);

            // Write data
            foreach ($equipment as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->name,
                    $item->brand,
                    $item->model,
                    $item->serial_number,
                    $item->mac_address,
                    $item->category->name,
                    $item->status->name,
                    $item->notes,
                    $item->created_at->format('Y-m-d H:i:s'),
                    $item->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function dynamicCSVExport(Request $request)
    {
        // Allow user to select columns
        $selectedColumns = $request->input('columns', [
            'id',
            'name',
            'serial_number',
            'category',
            'status'
        ]);

        $equipment = Equipment::with(['category', 'status'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="equipment_custom_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($equipment, $selectedColumns) {
            $file = fopen('php://output', 'w');

            // Dynamic headers based on selected columns
            $headerRow = [];
            $columnMapping = [
                'id' => 'ID',
                'name' => 'Name',
                'brand' => 'Brand',
                'model' => 'Model',
                'serial_number' => 'Serial Number',
                'mac_address' => 'MAC Address',
                'category' => 'Category',
                'status' => 'Status',
                'notes' => 'Notes',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At'
            ];

            $headerRow = array_map(function ($column) use ($columnMapping) {
                return $columnMapping[$column] ?? $column;
            }, $selectedColumns);

            fputcsv($file, $headerRow);

            // Write data
            foreach ($equipment as $item) {
                $row = [];
                foreach ($selectedColumns as $column) {
                    switch ($column) {
                        case 'category':
                            $row[] = $item->category->name;
                            break;
                        case 'status':
                            $row[] = $item->status->name;
                            break;
                        case 'created_at':
                        case 'updated_at':
                            $row[] = $item->{$column}->format('Y-m-d H:i:s');
                            break;
                        default:
                            $row[] = $item->{$column};
                    }
                }
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}