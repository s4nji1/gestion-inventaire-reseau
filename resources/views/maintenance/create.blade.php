@extends('layouts.app')

@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">{{ isset($maintenanceRecord) ? 'Edit' : 'Create' }} Maintenance Record</h1>
            <p class="mt-1 text-gray-600">{{ isset($maintenanceRecord) ? 'Update' : 'Add a new' }} maintenance record for your equipment.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('maintenance.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Maintenance Record Details</h4>
        </div>
        <div class="p-6">
            <form action="{{ isset($maintenanceRecord) ? route('maintenance.update', $maintenanceRecord) : route('maintenance.store') }}" method="POST">
                @csrf
                @if(isset($maintenanceRecord))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Equipment Selection -->
                    <div class="col-span-1">
                        <label for="equipment_id" class="block text-sm font-medium text-gray-700 mb-1">Equipment <span class="text-red-500">*</span></label>
                        <select id="equipment_id" name="equipment_id" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('equipment_id') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" {{ isset($maintenanceRecord) ? 'disabled' : '' }} required>
                            <option value="">-- Select Equipment --</option>
                            @foreach($equipment as $item)
                                <option value="{{ $item->id }}" {{ (old('equipment_id', isset($maintenanceRecord) ? $maintenanceRecord->equipment_id : '')) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} ({{ $item->serial_number }})
                                </option>
                            @endforeach
                        </select>
                        @if(isset($maintenanceRecord))
                            <input type="hidden" name="equipment_id" value="{{ $maintenanceRecord->equipment_id }}">
                        @endif
                        @error('equipment_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Maintenance Type -->
                    <div class="col-span-1">
                        <label for="maintenance_type" class="block text-sm font-medium text-gray-700 mb-1">Maintenance Type <span class="text-red-500">*</span></label>
                        <select id="maintenance_type" name="maintenance_type" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('maintenance_type') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>
                            <option value="">-- Select Type --</option>
                            <option value="Préventive" {{ old('maintenance_type', isset($maintenanceRecord) ? $maintenanceRecord->maintenance_type : '') == 'Préventive' ? 'selected' : '' }}>Préventive</option>
                            <option value="Corrective" {{ old('maintenance_type', isset($maintenanceRecord) ? $maintenanceRecord->maintenance_type : '') == 'Corrective' ? 'selected' : '' }}>Corrective</option>
                            <option value="Upgrade" {{ old('maintenance_type', isset($maintenanceRecord) ? $maintenanceRecord->maintenance_type : '') == 'Upgrade' ? 'selected' : '' }}>Upgrade</option>
                            <option value="Hardware Repair" {{ old('maintenance_type', isset($maintenanceRecord) ? $maintenanceRecord->maintenance_type : '') == 'Hardware Repair' ? 'selected' : '' }}>Hardware Repair</option>
                            <option value="Software Update" {{ old('maintenance_type', isset($maintenanceRecord) ? $maintenanceRecord->maintenance_type : '') == 'Software Update' ? 'selected' : '' }}>Software Update</option>
                            <option value="Configuration" {{ old('maintenance_type', isset($maintenanceRecord) ? $maintenanceRecord->maintenance_type : '') == 'Configuration' ? 'selected' : '' }}>Configuration</option>
                            <option value="Inspection" {{ old('maintenance_type', isset($maintenanceRecord) ? $maintenanceRecord->maintenance_type : '') == 'Inspection' ? 'selected' : '' }}>Inspection</option>
                        </select>
                        @error('maintenance_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div class="col-span-1">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', isset($maintenanceRecord) ? $maintenanceRecord->start_date->format('Y-m-d') : date('Y-m-d')) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('start_date') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="col-span-1">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', isset($maintenanceRecord) && $maintenanceRecord->end_date ? $maintenanceRecord->end_date->format('Y-m-d') : '') }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('end_date') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-span-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('status') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>
                            <option value="pending" {{ old('status', isset($maintenanceRecord) ? $maintenanceRecord->status : '') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', isset($maintenanceRecord) ? $maintenanceRecord->status : '') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', isset($maintenanceRecord) ? $maintenanceRecord->status : '') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', isset($maintenanceRecord) ? $maintenanceRecord->status : '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Issue Description -->
                    <div class="col-span-2">
                        <label for="issue_description" class="block text-sm font-medium text-gray-700 mb-1">Issue Description <span class="text-red-500">*</span></label>
                        <textarea id="issue_description" name="issue_description" rows="4" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('issue_description') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Describe the issue requiring maintenance..." required>{{ old('issue_description', isset($maintenanceRecord) ? $maintenanceRecord->issue_description : '') }}</textarea>
                        @error('issue_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Resolution Description -->
                    <div class="col-span-2">
                        <label for="resolution_description" class="block text-sm font-medium text-gray-700 mb-1">Resolution Description</label>
                        <textarea id="resolution_description" name="resolution_description" rows="4" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('resolution_description') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Describe how the issue was resolved...">{{ old('resolution_description', isset($maintenanceRecord) ? $maintenanceRecord->resolution_description : '') }}</textarea>
                        @error('resolution_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <button type="button" onclick="window.history.back()" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ isset($maintenanceRecord) ? 'Update' : 'Create' }} Record
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Movement Record (if editing) -->
    @if(isset($maintenanceRecord))
    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Record Equipment Movement</h4>
        </div>
        <div class="p-6">
            <p class="mb-4 text-sm text-gray-600">
                If this maintenance requires updating the equipment status, you can record a movement here.
            </p>
            <div class="mt-2">
                <a href="{{ route('movement.create', ['equipment_id' => $maintenanceRecord->equipment_id, 'type' => 'maintenance']) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                    Record Movement
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // End date validation - should be after or equal to start date
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const statusSelect = document.getElementById('status');
        
        // Function to validate end date
        function validateEndDate() {
            if (endDateInput.value) {
                if (endDateInput.value < startDateInput.value) {
                    endDateInput.setCustomValidity('End date must be after or equal to start date');
                } else {
                    endDateInput.setCustomValidity('');
                }
            } else {
                endDateInput.setCustomValidity('');
            }
        }
        
        // Add event listeners
        startDateInput.addEventListener('change', validateEndDate);
        endDateInput.addEventListener('change', validateEndDate);
        
        // Relationship between status and end date
        statusSelect.addEventListener('change', function() {
            if (this.value === 'completed') {
                if (!endDateInput.value) {
                    endDateInput.value = new Date().toISOString().split('T')[0];
                }
            }
        });
        
        // Make resolution description required if status is completed
        const form = document.querySelector('form');
        const resolutionDescription = document.getElementById('resolution_description');
        
        form.addEventListener('submit', function(event) {
            if (statusSelect.value === 'completed' && !resolutionDescription.value.trim()) {
                event.preventDefault();
                resolutionDescription.setCustomValidity('Resolution description is required when status is completed');
                resolutionDescription.reportValidity();
            } else {
                resolutionDescription.setCustomValidity('');
            }
        });
    });
</script>
@endsection