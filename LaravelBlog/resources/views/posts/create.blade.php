@extends('layouts.base')

@section('title', 'Создать новый пост - LaravelBlog')

@section('content')
    <div class="page-header">
        <h2 class="page-title">Создать новый пост</h2>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Назад к списку</a>
    </div>

    <div class="card">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title" class="form-label">Заголовок</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}"
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
                >{{ old('content') }}</textarea>
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
                    <option value="draft" {{ old('publication_option', 'draft') === 'draft' ? 'selected' : '' }}>Черновик</option>
                    <option value="publish_now" {{ old('publication_option') === 'publish_now' ? 'selected' : '' }}>Опубликовать сейчас</option>
                    <option value="schedule" {{ old('publication_option') === 'schedule' ? 'selected' : '' }}>Опубликовать по времени</option>
                </select>
                @error('publication_option')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="scheduled_at" class="form-label">Дата и время публикации (для отложенной публикации)</label>
                <input 
                    type="datetime-local" 
                    id="scheduled_at" 
                    name="scheduled_at" 
                    class="form-control @error('scheduled_at') is-invalid @enderror"
                    value="{{ old('scheduled_at') }}"
                >
                @error('scheduled_at')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <small style="color: #7f8c8d;">Оставьте пустым, если не планируете отложенную публикацию</small>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-success">Создать пост</button>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection
