<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Events\CommentCreated;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        if (! $post->isPublished()) {
            return back()->with('error', 'Нельзя комментировать неопубликованный пост');
        }

        $validated = $request->validate([
            'author_name' => 'required|max:255',
            'author_email' => 'required|email',
            'content' => 'required',
        ]);
        
        $comment = $post->comments()->create(array_merge($validated, ['is_approved' => false]));
        
        event(new CommentCreated($comment));
        
        return back()->with('success', 'Комментарий отправлен на модерацию');
    }
    
    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Комментарий одобрен');
    }
    
    public function reject(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Комментарий удален');
    }
}
