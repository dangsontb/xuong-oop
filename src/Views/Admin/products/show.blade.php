@extends('layouts.master')

@section('title')
    Chi tiết sản phẩm : {{ $product['name'] }}
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
            @foreach ($product as $field => $value)
                <tr>
                    <td>{{ $field }}</td>
                    <td>
                        @if ($product['img_thumbnail'] == $value)
                            <img src="{{ asset($product['img_thumbnail']) }}" alt="" width="80px">
                        @else
                            {{ $value }}
                        @endif

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
