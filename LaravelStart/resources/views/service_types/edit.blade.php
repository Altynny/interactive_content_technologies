@extends('layouts.base')

@section('title', 'Редактирование типа услуги')

@section('content')

    <p>
        <a href="{{ route('service-types.index') }}">← Назад к списку</a>
    </p>

    <form method="POST" action="{{ route('service-types.update', $type) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 12px;">
            <label for="name">Название</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $type->name) }}"
                style="width:100%; padding:8px;"
            >
            @error('name')
                <div class="errors">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label for="slug">Slug</label>
            <input
                id="slug"
                name="slug"
                type="text"
                value="{{ old('slug', $type->slug) }}"
                style="width:100%; padding:8px;"
            >
            @error('slug')
                <div class="errors">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label for="description">Описание</label>
            <textarea
                id="description"
                name="description"
                rows="5"
                style="width:100%; padding:8px;"
            >{{ old('description', $type->description) }}</textarea>
            @error('description')
                <div class="errors">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" style="padding:10px 14px;">
            Сохранить изменения
        </button>
    </form>
@endsection
