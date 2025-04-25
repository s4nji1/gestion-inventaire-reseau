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
                        <a href="{{ route('movement.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Movements</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Movement Details</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Movement Details</h1>
            <p class="mt-1 text-gray-600">View movement information for equipment.</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
            <a href="{{ route('movement.edit', $movement) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Movement
            </a>
            <a href="{{ route('equipment.show', $movement->equipment) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                </svg>
                View Equipment
            </a>
            <form action="{{ route('movement.destroy', $movement) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this movement record?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Movement
                </button>
            </form>
        </div>
    </div>

    <!-- Movement Details Card -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Movement Information</h4>
        </div>
        
        <div class="p-6">
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Movement Date & Time -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h5 class="text-sm font-medium text-gray-700">Date & Time</h5>
                    </div>
                    <div class="ml-7">
                        <p class="text-lg font-semibold text-gray-900">{{ $movement->created_at->format('d F, Y') }}</p>
                        <p class="text-sm text-gray-600">{{ $movement->created_at->format('h:i A') }}</p>
                    </div>
                </div>

                <!-- Movement Type -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                        </svg>
                        <h5 class="text-sm font-medium text-gray-700">Movement Type</h5>
                    </div>
                    <div class="ml-7">
                        @switch($movement->type)
                            @case('entry')
                                <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">Entry</span>
                                @break
                            @case('exit')
                                <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">Exit</span>
                                @break
                            @case('maintenance')
                                <span class="px-2 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">Maintenance</span>
                                @break
                            @default
                                <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-800">{{ ucfirst($movement->type) }}</span>
                        @endswitch
                    </div>
                </div>
            </div>

            <!-- Status Change -->
            <div class="mb-6 p-5 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h5 class="text-sm font-medium text-gray-700">Status Change</h5>
                </div>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-center sm:justify-start gap-4 mt-2">
                    <!-- From Status -->
                    <div class="flex flex-col items-center">
                        @if($movement->from_status_id)
                            <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background-color: {{ $movement->fromStatus->color }}15">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: {{ $movement->fromStatus->color }};">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <h6 class="text-sm font-medium" style="color: {{ $movement->fromStatus->color }};">{{ $movement->fromStatus->name }}</h6>
                                <p class="text-xs text-gray-600">Previous Status</p>
                            </div>
                        @else
                            <div class="w-16 h-16 rounded-full flex items-center justify-center bg-gray-200">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <h6 class="text-sm font-medium text-gray-700">Initial Entry</h6>
                                <p class="text-xs text-gray-600">No previous status</p>
                            </div>
                        @endif
                    </div>

                    <!-- Arrow -->
                    <div class="flex items-center mx-2 rotate-90 sm:rotate-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>

                    <!-- To Status -->
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center" style="background-color: {{ $movement->toStatus->color }}15">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: {{ $movement->toStatus->color }};">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2 text-center">
                            <h6 class="text-sm font-medium" style="color: {{ $movement->toStatus->color }};">{{ $movement->toStatus->name }}</h6>
                            <p class="text-xs text-gray-600">Current Status</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment Information -->
            <div class="mb-6 p-5 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                    <h5 class="text-sm font-medium text-gray-700">Equipment Information</h5>
                </div>
                
                <div class="ml-7 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="text-base font-medium text-gray-900">{{ $movement->equipment->name }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Serial Number</p>
                        <p class="text-base font-medium text-gray-900">{{ $movement->equipment->serial_number }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Brand/Model</p>
                        <p class="text-base font-medium text-gray-900">{{ $movement->equipment->brand }} {{ $movement->equipment->model }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="text-base font-medium text-gray-900">{{ $movement->equipment->category->name }}</p>
                    </div>

                    @if($movement->equipment->mac_address)
                    <div>
                        <p class="text-sm text-gray-500">MAC Address</p>
                        <p class="text-base font-medium text-gray-900">{{ $movement->equipment->mac_address }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Notes -->
            @if($movement->notes)
            <div class="p-5 bg-gray-50 rounded-lg">
                <div class="flex items-start mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div>
                        <h5 class="text-sm font-medium text-gray-700">Notes</h5>
                        <div class="mt-2 text-base text-gray-700 prose max-w-none">
                            {{ $movement->notes }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Back Button -->
    <div class="mt-4 mb-6">
        <a href="{{ route('movement.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Movements
        </a>
    </div>
</div>
@endsection