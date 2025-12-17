@extends('layouts.base')

@section('title', 'Типы услуг')

@section('content')

    <p><a href="{{ route('service-types.create') }}">Создать тип</a></p>

    <table>
        <thead><tr><th>ID</th><th>Название</th><th>Slug</th><th>Действия</th></tr></thead>
        <tbody>
            @foreach($types as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td><a href="{{ route('service-types.show', $t) }}">{{ $t->name }}</a></td>
                    <td>{{ $t->slug }}</td>
                    <td>
                        <a href="{{ route('service-types.edit', $t) }}">Редактировать</a>
                        <form method="POST" action="{{ route('service-types.destroy', $t) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Удалить?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
