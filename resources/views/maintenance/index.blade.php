@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Maintenance Records</h1>
            <p class="mt-1 text-gray-600">Track maintenance history for your equipment.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('maintenance.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Maintenance Record
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Search & Filter</h4>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Form -->
                <div class="md:col-span-2">
                    <form action="{{ route('maintenance.search') }}" method="GET" class="flex">
                        <input type="text" name="query" value="{{ $query ?? '' }}" placeholder="Search equipment, maintenance type, issue description..." class="flex-1 shadow-sm border-gray-300 rounded-l-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <br>
                <!-- Filter Form -->
                <div class="md:col-span-1">
                    <form action="{{ route('maintenance.filter') }}" method="GET" class="flex">
                        <select name="status" class="flex-1 shadow-sm border-gray-300 rounded-l-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ (isset($status) && $status == 'pending') ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ (isset($status) && $status == 'in_progress') ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ (isset($status) && $status == 'completed') ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ (isset($status) && $status == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </button>
                        @if(isset($query) || isset($status))
                            <a href="{{ route('maintenance.index') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Records List -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h4 class="font-semibold text-gray-800">Maintenance Records</h4>
            <span class="text-sm text-gray-600">{{ $maintenanceRecords->total() }} records</span>
        </div><br>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maintenance Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($maintenanceRecords as $record)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $record->equipment->name }}</div>
                                <div class="text-xs text-gray-500">S/N: {{ $record->equipment->serial_number }}</div>
                            </td>
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
                                            {{ $record->status }}
                                        </span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 truncate max-w-xs">
                                    {{ Str::limit($record->issue_description, 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('maintenance.show', $record) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('maintenance.edit', $record) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('equipment.show', $record->equipment_id) }}" class="text-green-600 hover:text-green-900" title="View Equipment">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('maintenance.destroy', $record) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete" onclick="return confirm('Are you sure you want to delete this maintenance record?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>No maintenance records found</span>
                                    @if(isset($query) || isset($status))
                                        <a href="{{ route('maintenance.index') }}" class="mt-2 text-blue-600 hover:text-blue-800">Clear filters and try again</a>
                                    @else
                                        <a href="{{ route('maintenance.create') }}" class="mt-2 text-blue-600 hover:text-blue-800">Add your first maintenance record</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $maintenanceRecords->links() }}
        </div>
    </div>
</div>
@endsection