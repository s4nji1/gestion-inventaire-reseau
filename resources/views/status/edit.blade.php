@extends('layouts.app')
@section('title', 'Edit Status')
@section('content')
<div class="w-full">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Status</h1>
            <p class="mt-1 text-gray-600">Update status information.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a  href="{{ route('status.show', $status) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                View details
            </a>
        </div>
    </div>

    <!-- Edit Status Form -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center">
            <div class="w-6 h-6 rounded-full mr-2" style="background-color: {{ $status->color }}"></div>
            <h4 class="font-semibold text-gray-800">Status Information</h4>
        </div>
        
        <form action="{{ route('status.update', $status) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $status->name) }}" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('name') border-red-500 @enderror" placeholder="e.g. Available, In Maintenance, Deployed" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">The display name of the status.</p>
            </div>
            
            <!-- Slug -->
            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug <span class="text-red-500">*</span></label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $status->slug) }}" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('slug') border-red-500 @enderror" placeholder="e.g. available, maintenance, deployed" required>
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">URL-friendly version of the name. Use lowercase letters, numbers, and hyphens only.</p>
            </div>
            
            <!-- Color -->
            <div class="mb-6">
                <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color <span class="text-red-500">*</span></label>
                <div class="flex">
                    <input type="color" name="color_picker" id="color_picker" value="{{ old('color', $status->color) }}" class="h-10 w-12 border border-gray-300 rounded-l-md">
                    <input type="text" name="color" id="color" value="{{ old('color', $status->color) }}" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-r-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('color') border-red-500 @enderror" placeholder="e.g. #6b7280" required>
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
                <textarea id="description" name="description" rows="3" class="shadow-sm bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('description') border-red-500 @enderror" placeholder="Brief description of what this status means...">{{ old('description', $status->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Optional description explaining the purpose of this status.</p>
            </div>
            
            <!-- Usage Warning -->
            @if($status->equipment_count > 0 || $status->fromMovements()->count() > 0 || $status->toMovements()->count() > 0)
                <div class="mb-6 p-4 bg-yellow-50 rounded-md border border-yellow-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Status in Use</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>This status is currently being used by {{ $status->equipment_count }} equipment item(s) and appears in {{ $status->fromMovements()->count() + $status->toMovements()->count() }} movement record(s). Changing it will affect all related records.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('status.show', $status) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Cancel
                </a>
                
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-blue uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Status
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from name (only if slug hasn't been manually modified)
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        let slugModified = false;
        
        // Store original values
        const originalName = nameInput.value;
        const originalSlug = slugInput.value;
        
        nameInput.addEventListener('input', function() {
            // Only auto-generate if slug hasn't been manually changed
            // or if it was previously auto-generated from the original name
            if (!slugModified) {
                // Convert to lowercase, replace spaces and special chars with hyphens
                const slug = this.value.toLowerCase()
                    .replace(/\s+/g, '-')           // Replace spaces with hyphens
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple hyphens with single hyphen
                    .replace(/^-+/, '')             // Trim hyphens from start
                    .replace(/-+$/, '');            // Trim hyphens from end
                    
                slugInput.value = slug;
            }
        });
        
        // Detect if slug has been manually changed
        slugInput.addEventListener('input', function() {
            // Check if current slug is different from what would be auto-generated
            const autoSlug = nameInput.value.toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
                
            slugModified = (this.value !== autoSlug);
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