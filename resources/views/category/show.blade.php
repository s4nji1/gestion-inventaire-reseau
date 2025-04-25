@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Category Details</h1>
            <p class="mt-1 text-gray-600">Viewing details for {{ $category->name }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-2">
            <a href="{{ route('category.edit', $category) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Category
            </a>
            <a href="{{ route('category.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <!-- Category Information Card -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Category Information</h4>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-md">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Name</h5>
                            <p class="text-gray-900">{{ $category->name }}</p>
                        </div>
                        <br>
                        <div>
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Slug</h5>
                            <p class="text-gray-900 font-mono">{{ $category->slug }}</p>
                        </div>
                        <br>
                        <div>
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Created At</h5>
                            <p class="text-gray-900">{{ $category->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <br>
                        <div>
                            <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Last Updated</h5>
                            <p class="text-gray-900">{{ $category->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                        <br>
                    </div>
                </div>
                <div>
                    @if($category->description)
                    <div class="bg-gray-50 p-4 rounded-md h-full">
                        <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Description</h5>
                        <p class="text-gray-900 whitespace-pre-line">{{ $category->description }}</p>
                    </div>
                    @else
                    <div class="bg-gray-50 p-4 rounded-md h-full flex items-center justify-center">
                        <p class="text-gray-500 italic">No description provided</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment List -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h4 class="font-semibold text-gray-800">Equipment in this Category</h4>
            <div class="flex items-center">
                <span class="text-sm text-gray-600 mr-4">{{ $equipment->total() }} items</span>
                <a href="{{ route('equipment.create', ['category_id' => $category->id]) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add
                </a>
            </div>
        </div>
        <br>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand/Model</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($equipment as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->brand }}</div>
                                <div class="text-sm text-gray-500">{{ $item->model }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->serial_number }}</div>
                                @if($item->mac_address)
                                    <div class="text-xs text-gray-500">MAC: {{ $item->mac_address }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="background-color: {{ $item->status->color }}25; color: {{ $item->status->color }}">
                                    {{ $item->status->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('equipment.show', $item) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('equipment.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('movement.history', $item) }}" class="text-green-600 hover:text-green-900" title="View Movement History">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>No equipment found in this category</span>
                                    <a href="{{ route('equipment.create', ['category_id' => $category->id]) }}" class="mt-2 text-blue-600 hover:text-blue-800">Add your first equipment in this category</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $equipment->links() }}
        </div>
    </div>
</div>
@endsection