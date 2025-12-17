@extends('layouts.base')

@section('title', 'Редактировать поставщика')

@section('content')

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Имя</label>
            <input name="name" value="{{ old('name', $user->name) }}">
            @error('name') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Email</label>
            <input name="email" value="{{ old('email', $user->email) }}">
            @error('email') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Новый пароль (необязательно)</label>
            <input type="password" name="password">
            @error('password') <div class="errors">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>Контактный номер</label>
            <input name="contact_number" value="{{ old('contact_number', $user->contact_number) }}">
        </div>

        <button type="submit">Сохранить</button>
    </form>
@endsection
