@extends('layouts.base')

@section('title', 'Форма отправки')

@section('content')
    @if(session('success'))
        <div class="flash-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="errors">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('form.submit') }}">
        @csrf

        <div style="margin-bottom:10px;">
            <label for="name">Имя пользователя</label><br>
            <input id="name" name="name" value="{{ old('name') }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label for="email">Email</label><br>
            <input id="email" name="email" value="{{ old('email') }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label for="message">Сообщение</label><br>
            <textarea id="message" name="message" rows="6" style="width:100%; padding:8px;">{{ old('message') }}</textarea>
        </div>

        <button type="submit" style="padding:10px 14px;">Отправить</button>
    </form>
@endsection
