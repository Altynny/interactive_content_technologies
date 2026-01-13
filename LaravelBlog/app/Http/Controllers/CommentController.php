<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'is_approved' => false,
        ]);

        event(new CommentCreated($comment));

        return redirect()->back()
            ->with('success', 'Комментарий отправлен на модерацию!');
    }

    public function destroy(Comment $comment)
    {   
        if (Auth::id() !== $comment->user_id && Auth::id() !== $comment->post->user_id) {
            abort(403);
        }

        $this->authorize('delete', $comment);
        $comment->delete();

        return redirect()->back()
            ->with('success', 'Комментарий удалён!');
    }

    public function moderate(Comment $comment)
    {
        if (Auth::id() !== $comment->post->user_id) {
            abort(403);
        }

        $comment->update(['is_approved' => true]);

        return redirect()->back()
            ->with('success', 'Комментарий одобрен!');
    }
}
