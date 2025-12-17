@extends('layouts.base')

@section('title', $type->name)

@section('content')
    <h1>{{ $type->name }}</h1>

    @if(!empty($type->description))
        <div style="margin-bottom:12px; white-space:pre-wrap;">{{ $type->description }}</div>
    @endif

    <p><strong>Всего объявлений:</strong> {{ $type->listings->count() }}</p>

    <p>
        <a href="{{ route('service-types.index') }}">← Все типы услуг</a>
        &nbsp;|&nbsp;
        <a href="{{ route('listings.index') }}">Все объявления</a>
        @auth
            &nbsp;|&nbsp;
            <a href="{{ route('service-types.edit', $type) }}">Редактировать тип</a>
        @endauth
    </p>

    @if($type->listings->isEmpty())
        <p>Для этого типа услуг объявлений пока нет.</p>
    @else
        <div class="table-wrap" style="margin-top:12px;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Поставщик</th>
                        <th>Цена</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($type->listings as $listing)
                        <tr>
                            <td>{{ $listing->id }}</td>
                            <td><a href="{{ route('listings.show', $listing->id) }}">{{ $listing->title }}</a></td>
                            <td>{{ $listing->user->name ?? '-' }}</td>
                            <td>{{ $listing->price }} {{ $listing->currency }}</td>
                            <td>{{ $listing->is_active ? 'Активно' : 'Неактивно' }}</td>
                            <td>
                                <a href="{{ route('listings.show', $listing->id) }}">Просмотр</a>

                                @auth
                                    &nbsp;|&nbsp;
                                    <a href="{{ route('listings.edit', $listing->id) }}">Редактировать</a>

                                    <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" style="display:inline;margin:0 4px;" onsubmit="return confirm('Удалить объявление?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:none;border:none;color:#c00;cursor:pointer;padding:0;">Удалить</button>
                                    </form>

                                    @if($listing->trashed())
                                        <form action="{{ route('listings.restore', $listing->id) }}" method="POST" style="display:inline;margin-left:6px;">
                                            @csrf
                                            <button type="submit" style="background:none;border:none;color:green;cursor:pointer;padding:0;">Восстановить</button>
                                        </form>
                                    @endif
                                @endauth
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
