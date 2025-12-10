@extends('layouts.base')

@section('title', 'Форма отправки')

@section('content')
    @if(session('success'))
        <div class="flash-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('form.submit') }}">
        @csrf

        <div style="margin-bottom:10px;">
            <label for="name">Имя пользователя</label><br>
            <input id="name" name="name" value="{{ old('name') }}" style="width:100%; padding:8px;">
            @error('name')
            <div class="errors">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom:10px;">
            <label for="email">Email</label><br>
            <input id="email" name="email" value="{{ old('email') }}" style="width:100%; padding:8px;">
            @error('email')
            <div class="errors">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom:10px;">
            <label for="message">Сообщение</label><br>
            <textarea id="message" name="message" rows="6" style="width:100%; padding:8px;">{{ old('message') }}</textarea>
            @error('message')
            <div class="errors">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" style="padding:10px 14px;">Отправить</button>
    </form>
@endsection
