<!-- resources/views/pages/index.blade.php -->
@extends('layouts.app')

@section('title', 'Documentation Pages')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Documentation Pages</h1>
            <a href="{{ route('pages.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Page
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pages as $page)
                <div class="bg-white rounded-xl border border-gray-200 hover:border-primary-500 hover:shadow-md transition-all duration-200">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1">{{ $page->title }}</h2>
                        <p class="text-gray-600 mb-4 text-sm line-clamp-2">{{ Str::limit(strip_tags($page->content), 150) }}</p>
                        
                        @if($page->tags)
                            <div class="flex flex-wrap gap-1 mb-4">
                                @foreach($page->tags_array as $tag)
                                    <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('pages.show', ltrim($page->path, '/')) }}" 
                               class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-700">
                                <span>Read more</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('pages.edit', $page->id) }}" 
                                   class="text-gray-400 hover:text-gray-600" 
                                   title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-300">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No documentation pages yet</h3>
                        <p class="text-gray-500 mb-4">Get started by creating your first documentation page.</p>
                        <a href="{{ route('pages.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create First Page
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection