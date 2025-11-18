@extends('layouts.base')

@section('title', 'Все записи')

@section('content')

    @if(count($rows) === 0)
        <p>Записей нет.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Файл</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Сообщение</th>
                        <th>Время</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr>
                            <td>{{ $row['_filename'] ?? '-' }}</td>
                            <td class="col-name">{{ $row['name'] ?? '-' }}</td>
                            <td class="col-email">{{ $row['email'] ?? '-' }}</td>
                            <td class="col-message" style="white-space:pre-wrap;">{{ $row['message'] ?? '-' }}</td>
                            <td>{{ $row['created_at'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
