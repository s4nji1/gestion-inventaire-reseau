@extends('layouts.app')

@section('content')
<div class="w-full">
    <!-- Breadcrumbs -->
    <div class="mb-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('status.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Statuses</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $status->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Status Details</h1>
            <p class="mt-1 text-gray-600">View and manage status information.</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
            <a href="{{ route('status.edit', $status) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Status
            </a>
            @if($status->equipment_count == 0 && $status->fromMovements()->count() == 0 && $status->toMovements()->count() == 0)
                <form action="{{ route('status.destroy', $status) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this status?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Status
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Status Information Card -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center">
            <div class="w-6 h-6 rounded-full mr-2" style="background-color: {{ $status->color }}"></div>
            <h4 class="font-semibold text-gray-800">Status Information</h4>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Status Name -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h5 class="text-sm font-medium text-gray-500 mb-1">Name</h5>
                    <p class="text-lg font-semibold" style="color: {{ $status->color }}">{{ $status->name }}</p>
                </div>
                
                <!-- Status Slug -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h5 class="text-sm font-medium text-gray-500 mb-1">Slug</h5>
                    <p class="text-lg font-semibold text-gray-800">{{ $status->slug }}</p>
                </div>
                
                <!-- Color -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h5 class="text-sm font-medium text-gray-500 mb-1">Color</h5>
                    <div class="flex items-center mt-1">
                        <div class="w-6 h-6 rounded mr-2" style="background-color: {{ $status->color }}"></div>
                        <span class="text-lg font-semibold text-gray-800">{{ $status->color }}</span>
                    </div>
                </div>
                
                <!-- Equipment Count -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h5 class="text-sm font-medium text-gray-500 mb-1">Equipment Count</h5>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                        <span class="text-lg font-semibold text-gray-800">{{ $status->equipment_count }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            @if($status->description)
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h5 class="text-sm font-medium text-gray-500 mb-1">Description</h5>
                <p class="text-gray-800">{{ $status->description }}</p>
            </div>
            @endif
            
            <!-- Usage Statistics -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h5 class="text-sm font-medium text-gray-500 mb-3">Usage Statistics</h5><br>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Equipment Using This Status -->
                    <div class="p-3 bg-white rounded border border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Current Equipment</span>
                            <span class="text-lg font-semibold text-blue-600">{{ $status->equipment_count }}</span>
                        </div>
                    </div>
                    <br>
                    <!-- As Source in Movements -->
                    <div class="p-3 bg-white rounded border border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">As Source Status</span>
                            <span class="text-lg font-semibold text-blue-600">{{ $status->fromMovements()->count() }}</span>
                        </div>
                    </div>
                    <br>
                    <!-- As Destination in Movements -->
                    <div class="p-3 bg-white rounded border border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">As Destination Status</span>
                            <span class="text-lg font-semibold text-blue-600">{{ $status->toMovements()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Equipment with this Status -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h4 class="font-semibold text-gray-800">Equipment with this Status</h4>
            <span class="text-sm text-gray-600">{{ $equipment->total() }} items</span>
        </div>
        
        <div class="p-4">
            @if($equipment->isEmpty())
                <div class="flex flex-col items-center py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500">No equipment is currently using this status.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Serial Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($equipment as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->brand }} {{ $item->model }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->serial_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->category->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('equipment.show', $item) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('movement.create') }}?equipment_id={{ $item->id }}" class="text-green-600 hover:text-green-900" title="Add Movement">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200">
                    {{ $equipment->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <!-- Recent Movements -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h4 class="font-semibold text-gray-800">Recent Movements</h4>
            <div>
                <a href="{{ route('movement.index') }}?status_id={{ $status->id }}" class="text-sm text-blue-600 hover:underline">View All</a>
            </div>
        </div>
        
        <div class="p-4">
            @php
                // Fetch 5 most recent movements where this status was involved
                $recentMovements = \App\Models\Movement::where('from_status_id', $status->id)
                    ->orWhere('to_status_id', $status->id)
                    ->with(['equipment', 'fromStatus', 'toStatus'])
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            
            @if($recentMovements->isEmpty())
                <div class="flex flex-col items-center py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-500">No recent movements involving this status.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Change</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentMovements as $movement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $movement->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $movement->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $movement->equipment->name }}</div>
                                        <div class="text-xs text-gray-500">S/N: {{ $movement->equipment->serial_number }}</div>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('movement.show', $movement) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Back Button -->
    <div class="mt-4 mb-6">
        <a href="{{ route('status.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Statuses
        </a>
    </div>
</div>
@endsection