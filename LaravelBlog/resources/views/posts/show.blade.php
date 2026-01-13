@extends('layouts.base')

@section('title', $post->title . ' - LaravelBlog')

@section('content')
    <article class="card">
        <div class="post-detail-header">
            <h1 class="post-detail-title">{{ $post->title }}</h1>
            
            <div class="post-meta">
                <span class="post-status status-{{ $post->publication_state }}">
                    {{ ucfirst($post->publication_state) }}
                </span>
                <span>Опубликовано: {{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : 'Не опубликовано' }}</span>
                @if($post->user)
                    <span>— автор: {{ $post->user->name }}</span>
                @endif
            </div>

            <div class="action-buttons">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Назад</a>
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Редактировать</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить пост?')">
                        Удалить
                    </button>
                </form>
            </div>
        </div>

        <div class="post-content">
            {!! nl2br(e($post->content)) !!}
        </div>
    </article>

    <!-- Comments Section -->
    <section class="comments-section">
        @auth
            <h2 class="comments-header">Комментарии ({{ $post->comments->count() }})</h2>
        @else
            <h2 class="comments-header">Комментарии ({{ $post->approvedComments()->count() }})</h2>
        @endauth

        <!-- Comment Form -->
            @if($post->isPublished())
                <div class="card">
                    <h3>Оставить комментарий</h3>
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="author_name" class="form-label">Ваше имя</label>
                            <input 
                                type="text" 
                                id="author_name" 
                                name="author_name" 
                                class="form-control @error('author_name') is-invalid @enderror"
                                value="{{ old('author_name') }}"
                                required
                            >
                            @error('author_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="author_email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                id="author_email" 
                                name="author_email" 
                                class="form-control @error('author_email') is-invalid @enderror"
                                value="{{ old('author_email') }}"
                                required
                            >
                            @error('author_email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content" class="form-label">Комментарий</label>
                            <textarea 
                                id="content" 
                                name="content" 
                                class="form-control @error('content') is-invalid @enderror"
                                rows="4"
                                required
                            >{{ old('content') }}</textarea>
                            @error('content')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Отправить комментарий</button>
                    </form>
                </div>
            @else
                <div class="card">
                    <p>Комментарии доступны только для опубликованных постов.</p>
                </div>
            @endif

        <!-- Comments List -->
        @php
            $commentsForListing = auth()->check() ? $post->comments : $post->approvedComments;
        @endphp

        @if($commentsForListing->count() > 0)
            <div style="margin-top: 2rem;">
                @foreach($commentsForListing as $comment)
                    <div class="comment {{ !$comment->is_approved ? 'pending' : '' }}">
                        <div class="comment-author">
                            {{ $comment->author_name }}
                            @if(!$comment->is_approved)
                                <span class="comment-status status-pending">На модерации</span>
                            @else
                                <span class="comment-status status-approved">Одобрен</span>
                            @endif
                        </div>
                        
                        <div class="comment-content">
                            {{ $comment->content }}
                        </div>
                        
                        <div class="comment-date">
                            {{ $comment->created_at->format('d.m.Y H:i') }}
                        </div>

                        @auth
                            @if(!$comment->is_approved)
                                <div class="action-buttons">
                                    <form action="{{ route('comments.approve', $comment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">Одобрить</button>
                                    </form>
                                    
                                    <form action="{{ route('comments.reject', $comment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить комментарий?')">
                                            Отклонить
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">💬</div>
                <p>Пока нет комментариев. Будьте первым!</p>
            </div>
        @endif
    </section>
@endsection
