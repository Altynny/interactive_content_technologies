@extends('layouts.base')

@section('title', 'Редактировать объявление')

@section('content')

    <form method="POST" action="{{ route('listings.update', $listing->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Поставщик</label>
            <select name="user_id">
                @foreach($users as $u)
                    <option value="{{ $u->id }}" @if(old('user_id', $listing->user_id)==$u->id) selected @endif>{{ $u->name }}</option>
                @endforeach
            </select>
            @error('user_id') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Тип услуги</label>
            <select name="service_type_id">
                @foreach($serviceTypes as $st)
                    <option value="{{ $st->id }}" @if(old('service_type_id', $listing->service_type_id)==$st->id) selected @endif>{{ $st->name }}</option>
                @endforeach
            </select>
            @error('service_type_id') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Название</label>
            <input name="title" value="{{ old('title', $listing->title) }}">
            @error('title') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Цена</label>
            <input name="price" value="{{ old('price', $listing->price) }}">
            @error('price') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Теги (через запятую)</label>
            <input name="tags_input" value="{{ old('tags_input', $listing->tags->pluck('name')->join(',')) }}">
        </div>

        <div>
            <label>Описание</label>
            <textarea name="description" rows="6">{{ old('description', $listing->description) }}</textarea>
            @error('description') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Текущие изображения</label>
            @if($listing->images->count())
                @foreach($listing->images as $img)
                    <div style="display:inline-block;margin:6px;text-align:center;">
                        <img src="{{ $img->path }}" alt="{{ $img->alt }}" style="max-width:120px;display:block;margin-bottom:4px;">
                        <label><input type="checkbox" name="delete_images[]" value="{{ $img->id }}"> Удалить</label>
                    </div>
                @endforeach
            @else
                <div>Изображений нет.</div>
            @endif
        </div>

        <div>
            <label>Добавить изображения</label>
            <input type="file" name="images_files[]" accept="image/*" multiple>
            @error('images_files') <div class="errors">{{ $message }}</div> @enderror
            @error('images_files.*') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <button type="submit">Сохранить</button>
    </form>
@endsection
