<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $categories = Category::withCount('equipment')
            ->orderBy('name')
            ->paginate(15);

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('category.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        // Generate slug from the name
        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category): View
    {
        $equipment = $category->equipment()
            ->with('status')
            ->orderBy('name')
            ->paginate(15);

        return view('category.show', compact('category', 'equipment'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category): View
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id),
            ],
            'description' => 'nullable|string',
        ]);

        // Generate slug from the name if the name has changed
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()->route('category.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if category has equipment
        $equipmentCount = $category->equipment()->count();

        if ($equipmentCount > 0) {
            return redirect()->route('category.index')
                ->with('error', "Cannot delete category. It has {$equipmentCount} equipment items associated with it.");
        }

        try {
            $category->delete();
            return redirect()->route('category.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('category.index')
                ->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    /**
     * Search for categories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View
    {
        $query = $request->input('query');

        $categories = Category::withCount('equipment')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orderBy('name')
            ->paginate(15)
            ->appends(['query' => $query]);

        return view('category.index', compact('categories', 'query'));
    }

    // In CategoryController
    public function exportCSV()
    {
        $categories = Category::withCount('equipment')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="categories_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($categories) {
            $file = fopen('php://output', 'w');

            // Write headers
            fputcsv($file, [
                'ID',
                'Name',
                'Slug',
                'Description',
                'Equipment Count',
                'Created At',
                'Updated At'
            ]);

            // Write data
            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->id,
                    $category->name,
                    $category->slug,
                    $category->description ?? '',
                    $category->equipment_count,
                    $category->created_at->format('Y-m-d H:i:s'),
                    $category->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}