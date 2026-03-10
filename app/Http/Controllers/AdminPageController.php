<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function index()
    {
        $pages = Page::with('author')->latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.form', ['page' => new Page()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        $data['is_published'] = $request->has('is_published');
        $data['user_id'] = auth()->id();

        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page créée !');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . ($page->id);
        $data['is_published'] = $request->has('is_published');

        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page modifiée !');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page supprimée !');
    }
}
