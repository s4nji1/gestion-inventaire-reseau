@extends('layouts.app')
@section('title', 'Maintenance Record Details')
@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Maintenance Record Details</h1>
            <p class="mt-1 text-gray-600">View detailed information about this maintenance record.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-2">
            <a href="{{ route('maintenance.edit', $maintenanceRecord) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('maintenance.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Maintenance Record #{{ $maintenanceRecord->id }}</h3>
                <div>
                    @switch($maintenanceRecord->status)
                        @case('pending')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                            @break
                        @case('in_progress')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                In Progress
                            </span>
                            @break
                        @case('completed')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Completed
                            </span>
                            @break
                        @case('cancelled')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Cancelled
                            </span>
                            @break
                    @endswitch
                </div>
            </div>
        </div>

        <!-- Equipment Info -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Equipment Information</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs text-gray-500">Name</label>
                            <div class="text-sm font-medium text-gray-900">{{ $maintenanceRecord->equipment->name }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Brand & Model</label>
                            <div class="text-sm font-medium text-gray-900">{{ $maintenanceRecord->equipment->brand }} {{ $maintenanceRecord->equipment->model }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Serial Number</label>
                            <div class="text-sm font-medium text-gray-900">{{ $maintenanceRecord->equipment->serial_number }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Category</label>
                            <div class="text-sm font-medium text-gray-900">{{ $maintenanceRecord->equipment->category->name }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Current Status</label>
                            <div class="text-sm font-medium" style="color: {{ $maintenanceRecord->equipment->status->color }}">
                                {{ $maintenanceRecord->equipment->status->name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 mt-4 md:mt-0">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Maintenance Details</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs text-gray-500">Start Date</label>
                            <div class="text-sm font-medium text-gray-900">{{ $maintenanceRecord->start_date->format('F d, Y') }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">End Date</label>
                            <div class="text-sm font-medium text-gray-900">
                                {{ $maintenanceRecord->end_date ? $maintenanceRecord->end_date->format('F d, Y') : 'Not completed' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Maintenance Type</label>
                            <div class="text-sm font-medium text-gray-900">{{ $maintenanceRecord->maintenance_type }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Created At</label>
                            <div class="text-sm font-medium text-gray-900">{{ $maintenanceRecord->created_at->format('F d, Y H:i') }}</div>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500">Last Updated</label>
                            <div class="text-sm font-medium text-gray-900">{{ $maintenanceRecord->updated_at->format('F d, Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Issue Description</h4>
            <div class="bg-gray-50 p-4 rounded-md text-gray-800">
                {{ $maintenanceRecord->issue_description }}
            </div>
        </div>

        <!-- Resolution Section (if available) -->
        <div class="px-6 py-4">
            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Resolution Description</h4>
            <div class="bg-gray-50 p-4 rounded-md text-gray-800">
                {{ $maintenanceRecord->resolution_description ?? 'No resolution description provided yet.' }}
            </div>
        </div>
    </div>

    <!-- Associated Movement Records -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Related Movement Records</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Change</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($maintenanceRecord->equipment->movements->where('type', 'maintenance')->sortByDesc('created_at') as $movement)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $movement->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $movement->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Maintenance
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($movement->from_status_id)
                                        <span class="text-sm" style="color: {{ $movement->fromStatus->color }}">
                                            {{ $movement->fromStatus->name }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-500">—</span>
                                    @endif
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                    <span class="text-sm" style="color: {{ $movement->toStatus->color }}">
                                        {{ $movement->toStatus->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 truncate max-w-xs">
                                    {{ $movement->notes ?? 'No notes' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('movement.show', $movement) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                No movement records found for this maintenance.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-between">
        <div class="flex space-x-2">
            <a href="{{ route('equipment.show', $maintenanceRecord->equipment) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
                View Equipment
            </a>
            <a href="{{ route('movement.create', ['equipment_id' => $maintenanceRecord->equipment_id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                </svg>
                Record Movement
            </a>
        </div>
        <div>
            <form action="{{ route('maintenance.destroy', $maintenanceRecord) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this maintenance record?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Record
                </button>
            </form>
        </div>
    </div>
</div>
@endsection