@extends('layouts.master')

@section('title')
    Chi tiết người dùng : {{ $user['name'] }}
@endsection

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Trường dữ liệu</th>
                <th>Giá trị</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($user as $field => $value)
                <tr>
                    <td>{{ $field }}</td>
                    <td>
                        @if ($user['avatar'] == $value)
                            <img src="{{ asset($user['avatar']) }}" alt="" width="80px">
                        @else
                            {{ $value }}
                        @endif

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
