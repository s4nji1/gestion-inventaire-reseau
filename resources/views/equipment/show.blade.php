@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Equipment Details</h1>
            <p class="mt-1 text-gray-600">Viewing details for {{ $equipment->name }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-2">
            <a href="{{ route('equipment.edit', $equipment) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Equipment
            </a>
            <a href="{{ route('movement.create', ['equipment_id' => $equipment->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                </svg>
                Record Movement
            </a>
            <a href="{{ route('maintenance.create', ['equipment_id' => $equipment->id]) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Add Maintenance
            </a>
        </div>
    </div>

    <!-- Equipment Information Card -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Equipment Information</h4>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Status</h5>
                                <div class="flex items-center">
                                    <span class="px-2 py-1 text-sm rounded-full" style="background-color: {{ $equipment->status->color }}25; color: {{ $equipment->status->color }}">
                                        {{ $equipment->status->name }}
                                    </span>
                                </div>
                            </div>
                            <br>
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Name</h5>
                                <p class="text-gray-900">{{ $equipment->name }}</p>
                            </div>
                            <br>
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Category</h5>
                                <p class="text-gray-900">{{ $equipment->category->name }}</p>
                            </div>
                            <br>
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Created At</h5>
                                <p class="text-gray-900">{{ $equipment->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Brand</h5>
                                <p class="text-gray-900">{{ $equipment->brand }}</p>
                            </div>
                            <br>
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Model</h5>
                                <p class="text-gray-900">{{ $equipment->model }}</p>
                            </div>
                            <br>
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Serial Number</h5>
                                <p class="text-gray-900">{{ $equipment->serial_number }}</p>
                            </div>
                            <br>    
                            @if($equipment->mac_address)
                            <div>
                                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">MAC Address</h5>
                                <p class="text-gray-900 font-mono">{{ $equipment->mac_address }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if($equipment->notes)
            <div class="mt-6">
                <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Notes</h5>
                <div class="bg-gray-50 p-4 rounded-md">
                    <p class="text-gray-900 whitespace-pre-line">{{ $equipment->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Movement History -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h4 class="font-semibold text-gray-800">Movement History</h4>
            <a href="{{ route('movement.history', $equipment) }}" class="text-sm text-blue-600 hover:underline">View All</a>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Change</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($equipment->movements()->latest()->take(5)->get() as $movement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $movement->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $movement->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($movement->type)
                                        @case('entry')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Entry
                                            </span>
                                            @break
                                        @case('exit')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Exit
                                            </span>
                                            @break
                                        @case('maintenance')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Maintenance
                                            </span>
                                            @break
                                        @default
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($movement->type) }}
                                            </span>
                                    @endswitch
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
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->notes ?? 'No notes' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No movement history found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Maintenance Records -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h4 class="font-semibold text-gray-800">Maintenance Records</h4>
            <a href="{{ route('maintenance.index', ['equipment_id' => $equipment->id]) }}" class="text-sm text-blue-600 hover:underline">View All</a>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($equipment->maintenanceRecords()->latest()->take(5)->get() as $record)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Start: {{ $record->start_date->format('M d, Y') }}</div>
                                    @if($record->end_date)
                                        <div class="text-sm text-gray-900">End: {{ $record->end_date->format('M d, Y') }}</div>
                                    @else
                                        <div class="text-xs text-gray-500">End: Not completed</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $record->maintenance_type }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($record->status)
                                        @case('pending')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                            @break
                                        @case('in_progress')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                In Progress
                                            </span>
                                            @break
                                        @case('completed')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                            @break
                                        @case('cancelled')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Cancelled
                                            </span>
                                            @break
                                        @default
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($record->status) }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 truncate max-w-xs">
                                        {{ Str::limit($record->issue_description, 100) }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No maintenance records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection