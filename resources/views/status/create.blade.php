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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Add Status</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Add Status</h1>
            <p class="mt-1 text-gray-600">Create a new equipment status.</p>
        </div>
    </div>

    <!-- Create Status Form -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Status Information</h4>
        </div>
        
        <form action="{{ route('status.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 @enderror" placeholder="e.g. Available, In Maintenance, Deployed" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">The display name of the status.</p>
            </div>
            
            <!-- Slug -->
            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug <span class="text-red-500">*</span></label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('slug') border-red-500 @enderror" placeholder="e.g. available, maintenance, deployed" required>
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">URL-friendly version of the name. Use lowercase letters, numbers, and hyphens only.</p>
            </div>
            
            <!-- Color -->
            <div class="mb-6">
                <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color <span class="text-red-500">*</span></label>
                <div class="flex">
                    <input type="color" name="color_picker" id="color_picker" value="{{ old('color', '#6b7280') }}" class="h-10 w-12 border border-gray-300 rounded-l-md">
                    <input type="text" name="color" id="color" value="{{ old('color', '#6b7280') }}" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-r-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('color') border-red-500 @enderror" placeholder="e.g. #6b7280" required>
                </div>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Choose a color for this status. Use hexadecimal color codes (e.g. #6b7280).</p>
                
                <!-- Color Presets -->
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Presets</label>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" class="color-preset w-8 h-8 rounded-full bg-green-500" data-color="#10b981" title="Green (Available)"></button>
                        <button type="button" class="color-preset w-8 h-8 rounded-full bg-red-500" data-color="#ef4444" title="Red (Unavailable)"></button>
                        <button type="button" class="color-preset w-8 h-8 rounded-full bg-yellow-500" data-color="#f59e0b" title="Yellow (Maintenance)"></button>
                        <button type="button" class="color-preset w-8 h-8 rounded-full bg-blue-500" data-color="#3b82f6" title="Blue (Deployed)"></button>
                        <button type="button" class="color-preset w-8 h-8 rounded-full bg-purple-500" data-color="#8b5cf6" title="Purple (Reserved)"></button>
                        <button type="button" class="color-preset w-8 h-8 rounded-full bg-pink-500" data-color="#ec4899" title="Pink (Special)"></button>
                        <button type="button" class="color-preset w-8 h-8 rounded-full bg-indigo-500" data-color="#6366f1" title="Indigo (Assigned)"></button>
                        <button type="button" class="color-preset w-8 h-8 rounded-full bg-gray-500" data-color="#6b7280" title="Gray (Default)"></button>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="3" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('description') border-red-500 @enderror" placeholder="Brief description of what this status means...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Optional description explaining the purpose of this status.</p>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('status.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Cancel
                </a>
                
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Status
                </button>
            </div>
        </form>
    </div>
    
    <!-- Quick Help/Guide -->
    <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200">
            <h4 class="font-semibold text-gray-800">Status Guidelines</h4>
        </div>
        <div class="p-6">
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><strong>Names:</strong> Use simple, descriptive names that clearly indicate the equipment's state (e.g., "Available", "In Maintenance", "Deployed").</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><strong>Slugs:</strong> Create URL-friendly versions of your status names using lowercase letters, numbers, and hyphens (e.g., "available", "in-maintenance", "deployed").</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><strong>Colors:</strong> Choose distinctive colors that help staff quickly identify statuses. Aim for colors that convey meaning (e.g., green for available, red for unavailable, yellow for maintenance).</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><strong>Descriptions:</strong> Include clear explanations of what the status means and when it should be applied to equipment.</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from name
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        
        nameInput.addEventListener('input', function() {
            // Convert to lowercase, replace spaces and special chars with hyphens
            const slug = this.value.toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with hyphens
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple hyphens with single hyphen
                .replace(/^-+/, '')             // Trim hyphens from start
                .replace(/-+$/, '');            // Trim hyphens from end
                
            slugInput.value = slug;
        });
        
        // Sync color picker with text input
        const colorPicker = document.getElementById('color_picker');
        const colorInput = document.getElementById('color');
        
        colorPicker.addEventListener('input', function() {
            colorInput.value = this.value;
        });
        
        colorInput.addEventListener('input', function() {
            // Ensure value is a valid hex color
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                colorPicker.value = this.value;
            }
        });
        
        // Color presets
        const colorPresets = document.querySelectorAll('.color-preset');
        colorPresets.forEach(button => {
            button.addEventListener('click', function() {
                const color = this.getAttribute('data-color');
                colorPicker.value = color;
                colorInput.value = color;
            });
        });
    });
</script>
@endsection

@endsection