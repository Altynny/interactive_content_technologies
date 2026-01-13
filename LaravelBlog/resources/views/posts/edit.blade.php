@extends('layouts.base')

@section('title', 'Редактировать пост - LaravelBlog')

@section('content')
    <div class="page-header">
        <h2 class="page-title">Редактировать пост</h2>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Назад к списку</a>
    </div>

    <div class="card">
        <form action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title" class="form-label">Заголовок</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $post->title) }}"
                    required
                >
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="content" class="form-label">Содержание</label>
                <textarea 
                    id="content" 
                    name="content" 
                    class="form-control @error('content') is-invalid @enderror"
                    rows="10"
                    required
                >{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="publication_option" class="form-label">Публикация</label>
                <select 
                    id="publication_option" 
                    name="publication_option" 
                    class="form-control @error('publication_option') is-invalid @enderror"
                    required
                >
                    @php
                        $currentOption = old('publication_option') ?? (
                            $post->publication_state === \App\Models\Post::STATE_SCHEDULED ? 'schedule' : (
                                $post->isPublished() ? 'publish_now' : 'draft'
                            )
                        );
                    @endphp
                    <option value="draft" {{ $currentOption === 'draft' ? 'selected' : '' }}>Черновик</option>
                    <option value="publish_now" {{ $currentOption === 'publish_now' ? 'selected' : '' }}>Опубликовать сейчас</option>
                    <option value="schedule" {{ $currentOption === 'schedule' ? 'selected' : '' }}>Опубликовать по времени</option>
                </select>
                @error('publication_option')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="scheduled_at" class="form-label">Дата и время публикации</label>
                <input 
                    type="datetime-local" 
                    id="scheduled_at" 
                    name="scheduled_at" 
                    class="form-control @error('scheduled_at') is-invalid @enderror"
                    value="{{ old('scheduled_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                >
                @error('scheduled_at')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-success">Обновить пост</button>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Отмена</a>
                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Просмотр</a>
            </div>
        </form>
    </div>
@endsection
