@extends('layouts.master')

@section('title')
    Chi tiết danh mục: {{ $category['name'] }}
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
            @foreach ($category as $field => $value)
                <tr>
                    <td>{{ $field }}</td>
                    <td>
                            {{ $value }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
