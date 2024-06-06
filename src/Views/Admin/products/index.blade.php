@extends('layouts.master')
@section('title')
    Danh sách sản phẩm
@endsection

@section('content')
    <div class="table-responsive">
        <a href="{{ url('admin/products/create') }}" class="btn btn-primary btn-sm rounded-pill">Thêm Mới</a>

        @if (!empty($_SESSION['status']) && $_SESSION['status'])
            <div class="alert alert-success mt-3">
                {{ $_SESSION['msg'] }}

            </div>

            @php
                unset($_SESSION['status']);
                unset($_SESSION['msg']);
            @endphp
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IMAGE</th>
                    <th>NAME</th>
                    <th>CREATED_AT</th>
                    <th>UDATED_AT</th>
                    <th>DANH MỤC</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product['id'] }}</td>
                        <td>
                            @if (isset($product['img_thumbnail']))
                                <img src="{{ asset($product['img_thumbnail']) }}" alt="" width="80px">
                            @endif

                        </td>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['created_at'] }}</td>
                        <td>{{ $product['updated_at']}}</td>
                        <td>{{ $product['c_name']}}</td>
                        <td>

                            <a class="btn btn-info rounded-pill"
                                href="{{ url('admin/products/') . $product['id'] . '/show' }}">Xem</a>

                            <a class="btn btn-warning rounded-pill"
                                href="{{ url('admin/products/') . $product['id'] . '/edit' }}">Sửa</a>

                            <a class="btn btn-danger rounded-pill"
                                href="{{ url('admin/products/') . $product['id'] . '/delete' }}"
                                onclick="return confirm('Chắc chắn muốn xóa ?')">Xóa</a>

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="col-lg-12">
            <div class="white_box mb_30">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                            <a class="page-link " href=" {{ url('admin/products?page=' . $page - 1) }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $totalPage; $i++)
                            <li class="page-item {{ $i == $page ? 'active' : '' }}"><a class="page-link"
                                    href="{{ url('admin/products?page=') . $i }}">{{ $i }}</a></li>
                        @endfor


                        <li class="page-item {{ $page == $totalPage ? 'disabled' : '' }}">
                            <a class="page-link "
                                href="{{ $page < $totalPage ? url('admin/products?page=' . $page + 1) : '' }}"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    @endsection
