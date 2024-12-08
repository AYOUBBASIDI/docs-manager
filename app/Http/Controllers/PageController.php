<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {
            $pages = Page::all();
            $organizedPages = $this->organizePagesIntoFolders($pages);
            $view->with('pages', $pages);
            $view->with('organizedPages', $organizedPages);
        });
    }

    public function index(Request $request)
    {
        $query = Page::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        $pages = $query->get();
        return view('pages.index', compact('pages'));
    }

    public function show($path)
{
    $page = Page::where('path', '/' . trim($path, '/'))->firstOrFail();
    
    // Get previous and next pages
    $allPages = Page::orderBy('path')->get();
    $currentIndex = $allPages->search(function($p) use ($page) {
        return $p->id === $page->id;
    });
    
    $previousPage = $currentIndex > 0 ? $allPages[$currentIndex - 1] : null;
    $nextPage = $currentIndex < $allPages->count() - 1 ? $allPages[$currentIndex + 1] : null;
    
    return view('pages.show', compact('page', 'previousPage', 'nextPage'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'path' => [
                'required',
                'unique:pages',
                'regex:/^[a-zA-Z0-9\-\/]+$/',
            ],
            'content' => 'required',
            'tags' => 'nullable|string|max:255',
        ]);

        $path = '/' . trim(preg_replace('/\/+/', '/', $validated['path']), '/');
        
        try {
            $page = Page::create([
                'title' => $validated['title'],
                'path' => $path,
                'content' => $validated['content'],
                'tags' => $validated['tags']
            ]);

            return redirect()->route('pages.show', ltrim($path, '/'))
                ->with('success', 'Page created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create page: ' . $e->getMessage());
        }
    }

    private function organizePagesIntoFolders($pages)
{
    $organized = [
        '_pages' => [] // Add this line to store root-level pages
    ];
    
    foreach ($pages as $page) {
        $pathParts = explode('/', trim($page->path, '/'));
        
        // If this is a root-level page (no slashes in path)
        if (count($pathParts) === 1) {
            $organized['_pages'][] = $page;
            continue;
        }
        
        // Handle nested pages
        $current = &$organized;
        for ($i = 0; $i < count($pathParts) - 1; $i++) {
            if (!isset($current[$pathParts[$i]])) {
                $current[$pathParts[$i]] = ['_pages' => []];
            }
            $current = &$current[$pathParts[$i]];
        }
        
        // Add the page to its location
        $current['_pages'][] = $page;
    }
    
    return $organized;
}

    public function create()
    {
        return view('pages.create');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'path' => "required|unique:pages,path,$id",
            'content' => 'required',
        ]);

        $validated['path'] = Str::slug($validated['path']);

        $page->update($validated);

        return redirect()->route('pages.show', $page->path)
            ->with('success', 'Page updated successfully!');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('pages.index')
            ->with('success', 'Page deleted successfully!');
    }
}