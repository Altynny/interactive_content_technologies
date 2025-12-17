@extends('layouts.base')

@section('title', 'Объявления')

@section('content')

    <p>
        <a href="{{ route('listings.create') }}">Создать новое объявление</a>
    </p>

    <form method="GET" action="{{ route('listings.index') }}" style="margin-bottom:12px;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск..." />
        <select name="type">
            <option value="">Все типы</option>
            @foreach($serviceTypes as $st)
                <option value="{{ $st->id }}" @if(request('type') == $st->id) selected @endif>{{ $st->name }}</option>
            @endforeach
        </select>
        <button type="submit">Применить фильтр</button>
    </form>

    @if($listings->count())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th><th>Название</th><th>Тип</th><th>Цена</th><th>Поставщик</th><th>Статус</th><th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listings as $l)
                        <tr>
                            <td>{{ $l->id }}</td>
                            <td><a href="{{ route('listings.show', $l->id) }}">{{ $l->title }}</a></td>
                            <td>{{ $l->serviceType->name ?? '-' }}</td>
                            <td>{{ $l->price }} {{ $l->currency }}</td>
                            <td>{{ $l->user->name ?? '-' }}</td>
                            <td>{{ $l->is_active ? 'Активно' : 'Неактивно' }}</td>
                            <td>
                                <a href="{{ route('listings.edit', $l->id) }}">Редактировать</a>
                                <form action="{{ route('listings.destroy', $l->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Удалить?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Удалить</button>
                                </form>
                                @if($l->trashed())
                                    <form action="{{ route('listings.restore', $l->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit">Восстановить</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $listings->links() }}
    @else
        <p>Записей нет.</p>
    @endif
@endsection
