@extends('layouts.base')

@section('title', 'Создать поставщика')

@section('content')

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div>
            <label>Имя</label>
            <input name="name" value="{{ old('name') }}">
            @error('name') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Email</label>
            <input name="email" value="{{ old('email') }}">
            @error('email') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Пароль</label>
            <input type="password" name="password">
            @error('password') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Контактный номер</label>
            <input name="contact_number" value="{{ old('contact_number') }}">
        </div>

        <button type="submit">Создать</button>
    </form>
@endsection
