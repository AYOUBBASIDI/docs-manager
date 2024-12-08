<!-- resources/views/pages/show.blade.php -->
@extends('layouts.app')

@section('title', $page->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $page->title }}</h1>
                <div class="flex items-center text-sm text-gray-500">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $page->updated_at->diffForHumans() }}
                    </span>
                    @if($page->tags)
                        <span class="mx-2">•</span>
                        <div class="flex flex-wrap gap-1">
                            @foreach($page->tags_array as $tag)
                                <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary-50 text-primary-700 text-xs">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <a href="{{ route('pages.edit', $page->id) }}" 
                   class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('pages.destroy', $page->id) }}" 
                      method="POST" 
                      class="inline-block"
                      x-data="{ confirmDelete: false }"
                      @submit.prevent="if(confirmDelete || confirm('Are you sure you want to delete this page?')) $el.submit()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="prose max-w-none">
            {!! nl2br(e($page->content)) !!}
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex items-center justify-between pt-6">
        @if(isset($previousPage))
            <a href="{{ route('pages.show', ltrim($previousPage->path, '/')) }}" 
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Previous: {{ $previousPage->title }}
            </a>
        @endif

        @if(isset($nextPage))
            <a href="{{ route('pages.show', ltrim($nextPage->path, '/')) }}" 
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 ml-auto">
                Next: {{ $nextPage->title }}
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @endif
    </div>
</div>
@endsection