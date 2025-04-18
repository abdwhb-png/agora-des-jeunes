<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['collection', 'user'])->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $collections = Collection::where('is_active', true)->get();
        return view('posts.create', compact('collections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'custom_fields' => 'nullable|array',
            'seo_meta' => 'nullable|array',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published,scheduled',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        Post::create($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post créé avec succès.');
    }

    public function edit(Post $post)
    {
        $collections = Collection::where('is_active', true)->get();
        return view('posts.edit', compact('post', 'collections'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'collection_id' => 'required|exists:collections,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'custom_fields' => 'nullable|array',
            'seo_meta' => 'nullable|array',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published,scheduled',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $post->update($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post mis à jour avec succès.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post supprimé avec succès.');
    }

    public function publish(Post $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post publié avec succès.');
    }

    public function schedule(Request $request, Post $post)
    {
        $validated = $request->validate([
            'published_at' => 'required|date|after:now',
        ]);

        $post->update([
            'status' => 'scheduled',
            'published_at' => $validated['published_at'],
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post programmé avec succès.');
    }
}
