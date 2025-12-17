@extends('layouts.base')

@section('title', 'Создать объявление')

@section('content')

    <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Поставщик</label>
            <select name="user_id">
                @foreach($users as $u)
                    <option value="{{ $u->id }}" @if(old('user_id')==$u->id) selected @endif>{{ $u->name }} ({{ $u->email }})</option>
                @endforeach
            </select>
            @error('user_id') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Тип услуги</label>
            <select name="service_type_id">
                @foreach($serviceTypes as $st)
                    <option value="{{ $st->id }}" @if(old('service_type_id')==$st->id) selected @endif>{{ $st->name }}</option>
                @endforeach
            </select>
            @error('service_type_id') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Название</label>
            <input name="title" value="{{ old('title') }}">
            @error('title') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Цена</label>
            <input name="price" value="{{ old('price') }}">
            @error('price') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Валюта</label>
            <input name="currency" value="{{ old('currency','RUB') }}">
        </div>

        <div>
            <label>Теги (через запятую)</label>
            <input name="tags_input" value="{{ old('tags_input') }}" placeholder="сантехник,ремонт">
            <small>Теги будут разбиты по запятым</small>
        </div>

        <div>
            <label>Описание</label>
            <textarea name="description" rows="6">{{ old('description') }}</textarea>
            @error('description') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Изображения</label>
            <input type="file" name="images_files[]" accept="image/*" multiple>
            @error('images_files') <div class="errors">{{ $message }}</div> @enderror
            @error('images_files.*') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <button type="submit">Создать</button>
    </form>
@endsection