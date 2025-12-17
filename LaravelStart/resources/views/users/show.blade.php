@extends('layouts.base')

@section('title', $user->name)

@section('content')
    <h1>{{ $user->name }}</h1>

    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Контактный номер:</strong> {{ $user->contact_number ?? '-' }}</p>

    <p>
        <a href="{{ route('users.edit', $user->id) }}">Редактировать</a> |
        <a href="{{ route('users.index') }}">Назад к списку</a>
    </p>

    <hr>

    <h2>Объявления пользователя</h2>

    @if($user->listings->count())
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Тип услуги</th>
                    <th>Цена</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->listings as $listing)
                    <tr>
                        <td>{{ $listing->id }}</td>
                        <td>
                            <a href="{{ route('listings.show', $listing->id) }}">
                                {{ $listing->title }}
                            </a>
                        </td>
                        <td>{{ $listing->serviceType->name ?? '-' }}</td>
                        <td>{{ $listing->price }} {{ $listing->currency }}</td>
                        <td>{{ $listing->is_active ? 'Активно' : 'Неактивно' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>У пользователя пока нет объявлений.</p>
    @endif
@endsection
