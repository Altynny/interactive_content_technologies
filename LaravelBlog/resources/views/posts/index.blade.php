@extends('layouts.base')

@section('title', 'Все посты - LaravelBlog')

@section('content')
    <div class="page-header">
        <h2 class="page-title">Все посты</h2>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Создать новый пост</a>
    </div>

    @if($posts->count() > 0)
        <div class="posts-grid">
            @foreach($posts as $post)
                <article class="post-card">
                    <h3 class="post-card-title">
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                    </h3>
                    
                    <div class="post-meta">
                        <span class="post-status status-{{ $post->publication_state }}">
                            {{ ucfirst($post->publication_state) }}
                        </span>
                        <span>{{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : 'Не опубликовано' }}</span>
                        @if($post->user)
                            <span>— автор: {{ $post->user->name }}</span>
                        @endif
                    </div>

                    <p class="post-excerpt">
                        {{ Str::limit($post->content, 150) }}
                    </p>

                    <div class="action-buttons">
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Читать</a>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">Редактировать</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить пост?')">
                                Удалить
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📝</div>
            <h3>Пока нет постов</h3>
            <p>Создайте свой первый пост, чтобы начать</p>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Создать пост</a>
        </div>
    @endif
@endsection
