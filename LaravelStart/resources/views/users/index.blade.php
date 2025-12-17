@extends('layouts.base')

@section('title', 'Поставщики услуг')

@section('content')

    <p>
        <a href="{{ route('users.create') }}">Создать поставщика</a>
    </p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Телефон</th>
                <th>Объявлений</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>
                        <a href="{{ route('users.show', $u->id) }}">
                            {{ $u->name }}
                        </a>
                    </td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->contact_number ?? '-' }}</td>
                    <td>{{ $u->listings_count }}</td>
                    <td>
                        <a href="{{ route('users.edit', $u->id) }}">Редактировать</a>
                        <form action="{{ route('users.destroy', $u->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Удалить пользователя?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
