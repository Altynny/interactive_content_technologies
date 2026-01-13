<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::published()->latest('published_at')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'publication_option' => 'required|in:draft,publish_now,schedule',
            'scheduled_at' => 'nullable|date',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => $request->user()?->id ?? null,
        ];

        if ($validated['publication_option'] === 'publish_now') {
            $data['publication_state'] = Post::STATE_PUBLISHED;
            $data['published_at'] = now();
            $data['status'] = Post::STATE_PUBLISHED;
        } elseif ($validated['publication_option'] === 'schedule') {
            $when = $validated['scheduled_at'] ?? now();
            $data['published_at'] = $when;
            $data['publication_state'] = \Illuminate\Support\Carbon::parse($when)->gt(now()) ? Post::STATE_SCHEDULED : Post::STATE_PUBLISHED;
            $data['status'] = $data['publication_state'] === Post::STATE_PUBLISHED ? Post::STATE_PUBLISHED : Post::STATE_DRAFT;
        } else {
            $data['publication_state'] = Post::STATE_DRAFT;
            $data['published_at'] = null;
            $data['status'] = Post::STATE_DRAFT;
        }

        Post::create($data);
        return redirect()->route('posts.index')->with('success', 'Пост создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'publication_option' => 'required|in:draft,publish_now,schedule',
            'scheduled_at' => 'nullable|date',
        ]);

        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->user_id = $request->user()?->id ?? $post->user_id;

        if ($validated['publication_option'] === 'publish_now') {
            $post->publication_state = Post::STATE_PUBLISHED;
            $post->published_at = now();
            $post->status = Post::STATE_PUBLISHED;
        } elseif ($validated['publication_option'] === 'schedule') {
            $when = $validated['scheduled_at'] ?? now();
            $post->published_at = $when;
            $post->publication_state = \Illuminate\Support\Carbon::parse($when)->gt(now()) ? Post::STATE_SCHEDULED : Post::STATE_PUBLISHED;
            $post->status = $post->publication_state === Post::STATE_PUBLISHED ? Post::STATE_PUBLISHED : Post::STATE_DRAFT;
        } else {
            $post->publication_state = Post::STATE_DRAFT;
            $post->published_at = null;
            $post->status = Post::STATE_DRAFT;
        }

        $post->save();
        return redirect()->route('posts.index')->with('success', 'Пост обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Пост удален');
    }
}
