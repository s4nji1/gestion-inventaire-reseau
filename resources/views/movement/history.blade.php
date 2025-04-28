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
                        <a href="{{ route('equipment.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Equipment</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('equipment.show', $equipment) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">{{ $equipment->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Movement History</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Movement History</h1>
            <p class="mt-1 text-gray-600">Tracking all movements for {{ $equipment->name }} (S/N: {{ $equipment->serial_number }})</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
            <a href="{{ route('equipment.show', $equipment) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
                View Equipment Details
            </a>
            <a href="{{ route('movement.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Movement
            </a>
        </div>
    </div>

    <!-- Equipment Summary Card -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Equipment Information</h4>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-500">Name</span>
                    <span class="text-lg font-medium text-gray-900">{{ $equipment->name }}</span>
                </div>
                <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-500">Category</span>
                    <span class="text-lg font-medium text-gray-900">{{ $equipment->category->name }}</span>
                </div>
                <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-500">Current Status</span>
                    <span class="text-lg font-medium" style="color: {{ $equipment->status->color }}">{{ $equipment->status->name }}</span>
                </div>
                <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-500">Brand / Model</span>
                    <span class="text-lg font-medium text-gray-900">{{ $equipment->brand }} {{ $equipment->model }}</span>
                </div>
                <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-500">Serial Number</span>
                    <span class="text-lg font-medium text-gray-900">{{ $equipment->serial_number }}</span>
                </div>
                <div class="flex flex-col p-4 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-500">MAC Address</span>
                    <span class="text-lg font-medium text-gray-900">{{ $equipment->mac_address ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline View -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h4 class="font-semibold text-gray-800">Movement Timeline</h4>
            <span class="text-sm text-gray-600">{{ $movements->total() }} movements</span>
        </div>
        
        <div class="p-4">
            @if($movements->isEmpty())
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">No movements found</h3>
                    <p class="text-gray-500 mt-2">This equipment doesn't have any recorded movements yet.</p>
                    <div class="mt-6">
                        <a href="{{ route('movement.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Record First Movement
                        </a>
                    </div>
                </div>
            @else
                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                    
                    <div class="space-y-8">
                        @foreach($movements as $movement)
                            <div class="relative pl-12">
                                <!-- Timeline dot -->
                                @switch($movement->type)
                                    @case('entry')
                                        <div class="absolute left-3 top-5 -translate-x-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-green-500 border-4 border-white shadow"></div>
                                        @break
                                    @case('exit')
                                        <div class="absolute left-3 top-5 -translate-x-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-red-500 border-4 border-white shadow"></div>
                                        @break
                                    @case('maintenance')
                                        <div class="absolute left-3 top-5 -translate-x-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-yellow-500 border-4 border-white shadow"></div>
                                        @break
                                    @default
                                        <div class="absolute left-3 top-5 -translate-x-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-blue-500 border-4 border-white shadow"></div>
                                @endswitch
                                
                                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                @switch($movement->type)
                                                    @case('entry')
                                                        <span class="text-green-600">Entry</span>
                                                        @break
                                                    @case('exit')
                                                        <span class="text-red-600">Exit</span>
                                                        @break
                                                    @case('maintenance')
                                                        <span class="text-yellow-600">Maintenance</span>
                                                        @break
                                                    @default
                                                        <span class="text-blue-600">{{ ucfirst($movement->type) }}</span>
                                                @endswitch
                                            </h3>
                                            <time datetime="{{ $movement->created_at->format('Y-m-d H:i') }}" class="block text-sm text-gray-500 mb-2">
                                                {{ $movement->created_at->format('F d, Y') }} at {{ $movement->created_at->format('h:i A') }}
                                            </time>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('movement.show', $movement) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('movement.edit', $movement) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 flex items-center">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                @if($movement->from_status_id)
                                                    <span class="inline-block px-2 py-1 text-sm rounded-md text-white font-medium" style="background-color: {{ $movement->fromStatus->color }}">
                                                        {{ $movement->fromStatus->name }}
                                                    </span>
                                                @else
                                                    <span class="inline-block px-2 py-1 text-sm rounded-md text-white font-medium bg-gray-500">
                                                        Initial Entry
                                                    </span>
                                                @endif
                                                
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                </svg>
                                                
                                                <span class="inline-block px-2 py-1 text-sm rounded-md text-white font-medium" style="background-color: {{ $movement->toStatus->color }}">
                                                    {{ $movement->toStatus->name }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($movement->notes)
                                        <div class="mt-4 border-t border-gray-100 pt-4">
                                            <p class="text-gray-700 text-sm">{{ $movement->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                                <br>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="mt-6">
                    {{ $movements->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <!-- Back Button -->
    <div class="mt-4 mb-6">
        <a href="{{ route('equipment.show', $equipment) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Equipment Details
        </a>
    </div>
</div>
@endsection