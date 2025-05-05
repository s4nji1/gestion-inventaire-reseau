@extends('layouts.app')
@section('title', 'Edit Movement')
@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Movement</h1>
            <p class="mt-1 text-gray-600">Update movement information for equipment.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('movement.show', $movement) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                View Details
            </a>
        </div>
    </div>

    <!-- Edit Movement Form -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Movement Information</h4>
        </div>
        
        <form action="{{ route('movement.update', $movement) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Equipment Selection -->
            <div class="mb-6">
                <label for="equipment_id" class="block text-sm font-medium text-gray-700 mb-1">Equipment</label>
                <div class="flex items-center">
                    <input type="text" value="{{ $movement->equipment->name }} ({{ $movement->equipment->serial_number }})" class="shadow-sm bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" disabled>
                    <input type="hidden" name="equipment_id" value="{{ $movement->equipment_id }}">
                </div>
                <p class="mt-1 text-sm text-gray-500">Equipment cannot be changed for an existing movement.</p>
            </div>
            
            <!-- Movement Type -->
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Movement Type</label>
                <select id="type" name="type" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('type') border-red-500 @enderror" required>
                    <option value="">Select a movement type</option>
                    <option value="entry" {{ $movement->type === 'entry' ? 'selected' : '' }}>Entry</option>
                    <option value="exit" {{ $movement->type === 'exit' ? 'selected' : '' }}>Exit</option>
                    <option value="maintenance" {{ $movement->type === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Status Change -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- From Status -->
                <div>
                    <label for="from_status_id" class="block text-sm font-medium text-gray-700 mb-1">From Status</label>
                    <select id="from_status_id" name="from_status_id" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('from_status_id') border-red-500 @enderror">
                        <option value="">No Previous Status (Initial Entry)</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ (old('from_status_id', $movement->from_status_id) == $status->id) ? 'selected' : '' }} style="color: {{ $status->color }}">
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('from_status_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <br>
                
                <!-- To Status -->
                <div>
                    <label for="to_status_id" class="block text-sm font-medium text-gray-700 mb-1">To Status <span class="text-red-500">*</span></label>
                    <select id="to_status_id" name="to_status_id" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('to_status_id') border-red-500 @enderror" required>
                        <option value="">Select a status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ (old('to_status_id', $movement->to_status_id) == $status->id) ? 'selected' : '' }} style="color: {{ $status->color }}">
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('to_status_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea id="notes" name="notes" rows="4" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('notes') border-red-500 @enderror">{{ old('notes', $movement->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('movement.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Cancel
                </a>
                
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Movement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection