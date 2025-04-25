<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StatusController extends Controller
{
    /**
     * Display a listing of the statuses.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $statuses = Status::withCount('equipment')
            ->orderBy('name')
            ->paginate(15);
            
        return view('status.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new status.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('status.create');
    }

    /**
     * Store a newly created status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:statuses',
            'color' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        // Generate slug from the name
        $validated['slug'] = Str::slug($validated['name']);
        
        Status::create($validated);
        
        return redirect()->route('status.index')
            ->with('success', 'Status created successfully.');
    }

    /**
     * Display the specified status.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\View\View
     */
    public function show(Status $status): View
    {
        $equipment = $status->equipment()
            ->with('category')
            ->orderBy('name')
            ->paginate(15);
            
        return view('status.show', compact('status', 'equipment'));
    }

    /**
     * Show the form for editing the specified status.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\View\View
     */
    public function edit(Status $status): View
    {
        return view('status.edit', compact('status'));
    }

    /**
     * Update the specified status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Status $status): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('statuses')->ignore($status->id),
            ],
            'color' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        // Generate slug from the name if the name has changed
        if ($status->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $status->update($validated);
        
        return redirect()->route('status.index')
            ->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified status from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Status $status): RedirectResponse
    {
        // Check if status has equipment
        $equipmentCount = $status->equipment()->count();
        
        if ($equipmentCount > 0) {
            return redirect()->route('status.index')
                ->with('error', "Cannot delete status. It has {$equipmentCount} equipment items associated with it.");
        }
        
        // Check if status is used in movements
        $fromMovementsCount = $status->fromMovements()->count();
        $toMovementsCount = $status->toMovements()->count();
        
        if ($fromMovementsCount > 0 || $toMovementsCount > 0) {
            return redirect()->route('status.index')
                ->with('error', 'Cannot delete status. It is used in equipment movement history.');
        }
        
        try {
            $status->delete();
            return redirect()->route('status.index')
                ->with('success', 'Status deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('status.index')
                ->with('error', 'Failed to delete status: ' . $e->getMessage());
        }
    }

    /**
     * Search for statuses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View
    {
        $query = $request->input('query');
        
        $statuses = Status::withCount('equipment')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orderBy('name')
            ->paginate(15)
            ->appends(['query' => $query]);
            
        return view('status.index', compact('statuses', 'query'));
    }
}