@extends('layouts.app')
@section('title', 'Create Movement')
@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Add Movement</h1>
            <p class="mt-1 text-gray-600">Record a new equipment movement or status change.</p>
        </div>
    </div>

    <!-- Create Movement Form -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Movement Information</h4>
        </div>
        
        <form action="{{ route('movement.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Equipment Selection -->
            <div class="mb-6">
                <label for="equipment_id" class="block text-sm font-medium text-gray-700 mb-1">Equipment <span class="text-red-500">*</span></label>
                <select id="equipment_id" name="equipment_id" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('equipment_id') border-red-500 @enderror" required>
                    <option value="">Select equipment</option>
                    @foreach($equipment as $item)
                        <option value="{{ $item->id }}" {{ old('equipment_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} ({{ $item->serial_number }}) - {{ $item->status->name }}
                        </option>
                    @endforeach
                </select>
                @error('equipment_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Movement Type -->
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Movement Type <span class="text-red-500">*</span></label>
                <select id="type" name="type" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('type') border-red-500 @enderror" required>
                    <option value="">Select a movement type</option>
                    <option value="entry" {{ old('type') === 'entry' ? 'selected' : '' }}>Entry</option>
                    <option value="exit" {{ old('type') === 'exit' ? 'selected' : '' }}>Exit</option>
                    <option value="maintenance" {{ old('type') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
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
                            <option value="{{ $status->id }}" {{ old('from_status_id') == $status->id ? 'selected' : '' }} style="color: {{ $status->color }}">
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('from_status_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Leave empty for initial equipment entry.</p>
                </div><br>
                
                <!-- To Status -->
                <div>
                    <label for="to_status_id" class="block text-sm font-medium text-gray-700 mb-1">To Status <span class="text-red-500">*</span></label>
                    <select id="to_status_id" name="to_status_id" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('to_status_id') border-red-500 @enderror" required>
                        <option value="">Select a status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('to_status_id') == $status->id ? 'selected' : '' }} style="color: {{ $status->color }}">
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
                <textarea id="notes" name="notes" rows="4" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('movement.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Cancel
                </a>
                
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Movement
                </button>
            </div>
        </form>
    </div>
    
    <!-- Quick Help/Guide -->
    <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Quick Guide</h4>
        </div>
        <div class="p-6">
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><strong>Entry:</strong> Use for new equipment being added to inventory or returning from elsewhere.</span>
                </li>
                <br>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><strong>Exit:</strong> Use when equipment leaves inventory or is assigned elsewhere.</span>
                </li>
                <br>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><strong>Maintenance:</strong> Use when equipment is sent for repair or maintenance.</span>
                </li>
                <br>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><strong>From Status:</strong> The current status of the equipment before this movement. Leave empty only for brand new equipment being entered into the system for the first time.</span>
                </li>
                <br>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><strong>To Status:</strong> The new status of the equipment after this movement is completed.</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-fill "From Status" based on selected equipment's current status
        const equipmentSelect = document.getElementById('equipment_id');
        const fromStatusSelect = document.getElementById('from_status_id');
        
        equipmentSelect.addEventListener('change', function() {
            if (this.value) {
                // Get the selected option text which contains the status
                const selectedText = this.options[this.selectedIndex].text;
                // Extract status name from the text (format: "Name (Serial) - Status")
                const statusName = selectedText.split(' - ')[1];
                
                // Find the matching status option
                for (let i = 0; i < fromStatusSelect.options.length; i++) {
                    if (fromStatusSelect.options[i].text === statusName) {
                        fromStatusSelect.value = fromStatusSelect.options[i].value;
                        break;
                    }
                }
            }
        });
        
        // Set movement type suggestion based on from/to status
        const typeSelect = document.getElementById('type');
        const toStatusSelect = document.getElementById('to_status_id');
        
        function suggestMovementType() {
            const fromStatus = fromStatusSelect.options[fromStatusSelect.selectedIndex]?.text || '';
            const toStatus = toStatusSelect.options[toStatusSelect.selectedIndex]?.text || '';
            
            // Simple rules to suggest movement type
            if (fromStatus === 'No Previous Status (Initial Entry)' || !fromStatus) {
                typeSelect.value = 'entry';
            } else if (toStatus.includes('Maintenance')) {
                typeSelect.value = 'maintenance';
            } else if (toStatus.includes('Available') && fromStatus.includes('Maintenance')) {
                typeSelect.value = 'entry';
            } else if (toStatus.includes('Deployed') || toStatus.includes('Assigned')) {
                typeSelect.value = 'exit';
            }
        }
        
        fromStatusSelect.addEventListener('change', suggestMovementType);
        toStatusSelect.addEventListener('change', suggestMovementType);
    });
</script>
@endsection

@endsection