@extends('layouts.base')

@section('title', 'Создание типа услуги')

@section('content')

    <form method="POST" action="{{ route('service-types.store') }}">
        @csrf
        <div>
            <label>Название</label>
            <input name="name" value="{{ old('name') }}">
            @error('name') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Slug</label>
            <input name="slug" value="{{ old('slug') }}">
            @error('slug') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Описание</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <button type="submit">Создать</button>
    </form>
@endsection
