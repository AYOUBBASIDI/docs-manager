<!-- resources/views/components/folder-tree.blade.php -->
@props(['items', 'level' => 0])

<div class="space-y-0.5">
    {{-- Root level pages --}}
    @if(isset($items['_pages']))
        @foreach($items['_pages'] as $page)
            <div class="py-1">
                <a href="{{ route('pages.show', ltrim($page->path, '/')) }}" 
                   class="flex items-center text-sm {{ request()->is('pages/' . ltrim($page->path, '/')) 
                        ? 'bg-primary-50 text-primary-700 font-medium' 
                        : 'text-gray-700 hover:bg-gray-50' }} px-2 py-1.5 rounded-lg">
                    <svg class="w-4 h-4 mr-2 flex-shrink-0 {{ request()->is('pages/' . ltrim($page->path, '/')) 
                            ? 'text-primary-600' 
                            : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span class="truncate">{{ $page->title }}</span>
                </a>
            </div>
        @endforeach
    @endif

    {{-- Folders and their contents --}}
    @foreach($items as $folder => $content)
        @if($folder !== '_pages')
            <div class="ml-{{ $level * 3 }}" x-data="{ open: true }">
                <button @click="open = !open" 
                        class="flex items-center w-full px-2 py-1.5 text-sm rounded-lg hover:bg-gray-50 group">
                    <svg class="w-4 h-4 mr-1 text-gray-400 transition-transform duration-200"
                         :class="{ 'rotate-90': open }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <span class="font-medium text-gray-700">{{ $folder }}</span>
                </button>
                
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0"
                     x-transition:enter-end="transform opacity-100"
                     class="mt-1">
                    @if(isset($content['_pages']))
                        @foreach($content['_pages'] as $page)
                            <a href="{{ route('pages.show', ltrim($page->path, '/')) }}" 
                               class="flex items-center pl-8 pr-2 py-1.5 text-sm rounded-lg {{ request()->is('pages/' . ltrim($page->path, '/')) 
                                    ? 'bg-primary-50 text-primary-700 font-medium' 
                                    : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0 {{ request()->is('pages/' . ltrim($page->path, '/')) 
                                        ? 'text-primary-600' 
                                        : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span class="truncate">{{ $page->title }}</span>
                            </a>
                        @endforeach
                    @endif

                    @if($content !== ['_pages' => []])
                        <x-folder-tree :items="$content" :level="$level + 1" />
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>