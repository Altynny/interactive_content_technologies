@extends('layouts.base')

@section('title', $listing->title)

@section('content')
    <h1>{{ $listing->title }}</h1>

    <p><strong>Тип:</strong> {{ $listing->serviceType->name ?? '-' }}</p>
    <p><strong>Поставщик:</strong> {{ $listing->user->name ?? '-' }} ({{ $listing->user->email ?? '-' }})</p>
    <p><strong>Цена:</strong> {{ $listing->price }} {{ $listing->currency }}</p>
    <p><strong>Описание:</strong></p>
    <div style="white-space:pre-wrap;">{{ $listing->description }}</div>

    @if($listing->tags->count())
        <p><strong>Теги:</strong> {{ $listing->tags->pluck('name')->join(', ') }}</p>
    @endif

    @if($listing->images->count())
        <p><strong>Изображения:</strong></p>
        @foreach($listing->images as $img)
            <div><img src="{{ $img->path }}" alt="{{ $img->alt }}" style="max-width:200px"></div>
        @endforeach
    @endif

    <p>
        <a href="{{ route('listings.edit', $listing->id) }}">Редактировать</a> |
        <a href="{{ route('listings.index') }}">Назад к списку</a>
    </p>
@endsection