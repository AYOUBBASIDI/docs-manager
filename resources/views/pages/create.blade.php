<!-- resources/views/pages/create.blade.php -->
@extends('layouts.app')

@section('title', 'Create New Page')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900">Create New Page</h1>
            <a href="{{ route('pages.index') }}" 
               class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition-colors duration-150">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    <form action="{{ route('pages.store') }}" method="POST" class="p-6 space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-shadow duration-150"
                       value="{{ old('title') }}" 
                       placeholder="Page title"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="path" class="block text-sm font-medium text-gray-700">Path</label>
                <div class="mt-1 flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                        /
                    </span>
                    <input type="text" 
                           id="path" 
                           name="path" 
                           class="flex-1 block w-full rounded-none rounded-r-lg border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-shadow duration-150"
                           value="{{ old('path') }}" 
                           placeholder="docs/getting-started"
                           required>
                </div>
                <p class="mt-1 text-xs text-gray-500">Use forward slashes to create folders (e.g., docs/guide/intro)</p>
                @error('path')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="tags" class="block text-sm font-medium text-gray-700">
                Tags
                <span class="text-gray-500">(comma-separated)</span>
            </label>
            <input type="text" 
                   id="tags" 
                   name="tags" 
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-shadow duration-150"
                   value="{{ old('tags') }}"
                   placeholder="guide, tutorial, api">
            @error('tags')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
            <textarea id="content" 
                      name="content" 
                      rows="12" 
                      class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-shadow duration-150"
                      placeholder="Write your documentation here..."
                      required>{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-100">
            <a href="{{ route('pages.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-150">
                Cancel
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-150">
                Create Page
            </button>
        </div>
    </form>
</div>
@endsection