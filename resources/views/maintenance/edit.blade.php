@extends('layouts.app')
@section('title', 'Edit Maintenance Record')
@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Maintenance Record</h1>
            <p class="mt-1 text-gray-600">Update maintenance record details for {{ $maintenanceRecord->equipment->name }}</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-2">
            <a href="{{ route('maintenance.show', $maintenanceRecord) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                View Details
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
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Maintenance Record Details</h4>
        </div>
        <div class="p-6">
            <form action="{{ route('maintenance.update', $maintenanceRecord) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Equipment Information (Read-only) -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Equipment</label>
                        <div class="flex items-center">
                            <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                                {{ $maintenanceRecord->equipment->name }} ({{ $maintenanceRecord->equipment->serial_number }})
                            </div>
                        </div>
                        <input type="hidden" name="equipment_id" value="{{ $maintenanceRecord->equipment_id }}">
                    </div>
                    <br>
                    <!-- Maintenance Type -->
                    <div class="col-span-1">
                        <label for="maintenance_type" class="block text-sm font-medium text-gray-700 mb-1">Maintenance Type <span class="text-red-500">*</span></label>
                        <select id="maintenance_type" name="maintenance_type" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('maintenance_type') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>
                            <option value="">-- Select Type --</option>
                            <option value="Préventive" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'Préventive' ? 'selected' : '' }}>Préventive</option>
                            <option value="Corrective" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'Corrective' ? 'selected' : '' }}>Corrective</option>
                            <option value="Upgrade" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'Upgrade' ? 'selected' : '' }}>Upgrade</option>
                            <option value="Hardware Repair" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'Hardware Repair' ? 'selected' : '' }}>Hardware Repair</option>
                            <option value="Software Update" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'Software Update' ? 'selected' : '' }}>Software Update</option>
                            <option value="Configuration" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'Configuration' ? 'selected' : '' }}>Configuration</option>
                            <option value="Inspection" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'Inspection' ? 'selected' : '' }}>Inspection</option>
                        </select>
                        @error('maintenance_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <br>
                    <!-- Start Date -->
                    <div class="col-span-1">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $maintenanceRecord->start_date->format('Y-m-d')) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('start_date') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <br>
                    <!-- End Date -->
                    <div class="col-span-1">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $maintenanceRecord->end_date ? $maintenanceRecord->end_date->format('Y-m-d') : '') }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('end_date') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <br>
                    <!-- Status -->
                    <div class="col-span-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('status') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>
                            <option value="pending" {{ old('status', $maintenanceRecord->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status', $maintenanceRecord->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ old('status', $maintenanceRecord->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $maintenanceRecord->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <br>
                    <!-- Created At (Display only) -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created At</label>
                        <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                            {{ $maintenanceRecord->created_at->format('Y-m-d H:i') }}
                        </div>
                    </div>
                    <br>
                    <!-- Issue Description -->
                    <div class="col-span-2">
                        <label for="issue_description" class="block text-sm font-medium text-gray-700 mb-1">Issue Description <span class="text-red-500">*</span></label>
                        <textarea id="issue_description" name="issue_description" rows="4" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('issue_description') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" required>{{ old('issue_description', $maintenanceRecord->issue_description) }}</textarea>
                        @error('issue_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <br>
                    <!-- Resolution Description -->
                    <div class="col-span-2">
                        <label for="resolution_description" class="block text-sm font-medium text-gray-700 mb-1">Resolution Description</label>
                        <textarea id="resolution_description" name="resolution_description" rows="4" class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('resolution_description') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Describe how the issue was resolved...">{{ old('resolution_description', $maintenanceRecord->resolution_description) }}</textarea>
                        @error('resolution_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p id="resolution_required_message" class="hidden mt-1 text-sm text-red-600">Resolution description is required when status is completed</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('maintenance.show', $maintenanceRecord) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Record
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Equipment Movement Section -->
    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Record Equipment Movement</h4>
        </div>
        <div class="p-6">
            <p class="mb-4 text-sm text-gray-600">
                If this maintenance has changed the equipment status, you can record a movement here.
            </p>
            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-2">
                <a href="{{ route('movement.create', ['equipment_id' => $maintenanceRecord->equipment_id, 'type' => 'maintenance']) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                    Create Movement
                </a>
                <a href="{{ route('movement.history', $maintenanceRecord->equipment) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    View Movement History
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Movement Records -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Recent Movements</h4>
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
                    @forelse($maintenanceRecord->equipment->movements->sortByDesc('created_at')->take(3) as $movement)
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
                                No recent movement records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($maintenanceRecord->equipment->movements->count() > 3)
                <div class="px-6 py-3 border-t border-gray-200 text-center">
                    <a href="{{ route('movement.history', $maintenanceRecord->equipment) }}" class="text-sm text-blue-600 hover:text-blue-800">
                        View all {{ $maintenanceRecord->equipment->movements->count() }} movements
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get form elements
        const form = document.querySelector('form');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const statusSelect = document.getElementById('status');
        const resolutionDescription = document.getElementById('resolution_description');
        const resolutionRequiredMessage = document.getElementById('resolution_required_message');
        
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
        
        // Function to validate resolution description based on status
        function validateResolution() {
            if (statusSelect.value === 'completed') {
                if (!resolutionDescription.value.trim()) {
                    resolutionRequiredMessage.classList.remove('hidden');
                    return false;
                } else {
                    resolutionRequiredMessage.classList.add('hidden');
                    return true;
                }
            }
            resolutionRequiredMessage.classList.add('hidden');
            return true;
        }
        
        // Add event listeners
        startDateInput.addEventListener('change', validateEndDate);
        endDateInput.addEventListener('change', validateEndDate);
        
        // If status is completed, set end date to today if not already set
        statusSelect.addEventListener('change', function() {
            if (this.value === 'completed') {
                if (!endDateInput.value) {
                    // Set end date to today
                    endDateInput.value = new Date().toISOString().split('T')[0];
                }
                validateResolution();
            } else {
                resolutionRequiredMessage.classList.add('hidden');
            }
        });
        
        // Validate resolution on input
        resolutionDescription.addEventListener('input', function() {
            if (statusSelect.value === 'completed') {
                validateResolution();
            }
        });
        
        // Form submission validation
        form.addEventListener('submit', function(event) {
            validateEndDate();
            
            if (!validateResolution()) {
                event.preventDefault();
                resolutionDescription.focus();
            }
        });
        
        // Check initial state
        if (statusSelect.value === 'completed') {
            validateResolution();
        }
    });
</script>
@endsection