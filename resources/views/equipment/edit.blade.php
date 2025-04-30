@extends('layouts.app')
@section('title', 'Edit Equipment')
@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Equipment</h1>
            <p class="mt-1 text-gray-600">Update information for {{ $equipment->name }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('equipment.show', $equipment) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Details
            </a>
        </div>
    </div>

    <!-- Edit Equipment Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Equipment Information</h4>
        </div>
        <div class="p-6">
            <form action="{{ route('equipment.update', $equipment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $equipment->name) }}" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <br>
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700">Brand *</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand', $equipment->brand) }}" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <br>
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">Model *</label>
                            <input type="text" name="model" id="model" value="{{ old('model', $equipment->model) }}" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            @error('model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <br>
                        <div>
                            <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number *</label>
                            <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $equipment->serial_number) }}" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            @error('serial_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <!-- Additional Information -->
                    <div class="space-y-4">
                        <div>
                            <label for="mac_address" class="block text-sm font-medium text-gray-700">MAC Address</label>
                            <input type="text" name="mac_address" id="mac_address" value="{{ old('mac_address', $equipment->mac_address) }}" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <p class="mt-1 text-xs text-gray-500">Format: XX:XX:XX:XX:XX:XX or XXXX.XXXX.XXXX</p>
                            @error('mac_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <br>
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category *</label>
                            <select id="category_id" name="category_id" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <br>
                        <div>
                            <label for="status_id" class="block text-sm font-medium text-gray-700">Status *</label>
                            <select id="status_id" name="status_id" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                <option value="">Select a status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status_id', $equipment->status_id) == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('notes', $equipment->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('equipment.show', $equipment) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Update Equipment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6">
        <!-- Record Movement Form -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-4 py-3 border-b border-gray-200">
                <h4 class="font-semibold text-gray-800">Quick Actions</h4>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Record Movement -->
                <div>
                    <h5 class="text-lg font-medium text-gray-900 mb-4">Record Movement</h5>
                    <form action="{{ route('movement.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
                        <input type="hidden" name="from_status_id" value="{{ $equipment->status_id }}">

                        <div>
                            <label for="movement_type" class="block text-sm font-medium text-gray-700">Movement Type *</label>
                            <select id="movement_type" name="type" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                <option value="entry">Entry</option>
                                <option value="exit">Exit</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                        <br>
                        <div>
                            <label for="to_status_id" class="block text-sm font-medium text-gray-700">New Status *</label>
                            <select id="to_status_id" name="to_status_id" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                <option value="">Select a status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $equipment->status_id ? 'disabled' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div>
                            <label for="movement_notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="movement_notes" name="notes" rows="2" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                                Record Movement
                            </button>
                        </div>
                    </form>
                </div><br>

                <!-- Maintenance Request -->
                <div>
                    <h5 class="text-lg font-medium text-gray-900 mb-4">Create Maintenance Record</h5>
                    <form action="{{ route('maintenance.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

                        <div>
                            <label for="maintenance_type" class="block text-sm font-medium text-gray-700">Maintenance Type *</label>
                            <input type="text" name="maintenance_type" id="maintenance_type" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required placeholder="Preventive, Corrective, etc.">
                        </div>
                        <br>
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date *</label>
                            <input type="date" name="start_date" id="start_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                        </div>
                        <br>
                        <div>
                            <label for="issue_description" class="block text-sm font-medium text-gray-700">Issue Description *</label>
                            <textarea id="issue_description" name="issue_description" rows="2" class="mt-1 block w-full shadow-sm border-gray-300 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required></textarea>
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Create Maintenance Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection