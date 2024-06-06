@extends('layouts.master')
@section('title')
    Danh sách User
@endsection

@section('content')
    <div class="table-responsive">
        <a href="{{ url('admin/users/create') }}" class="btn btn-primary btn-sm rounded-pill">Thêm Mới</a>

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
                    <th>EMAIL</th>
                    <th>CREATED AT</th>
                    <th>UPDATED AT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>
                            @if (isset($user['avatar']))
                                <img src="{{ asset($user['avatar']) }}" alt="" width="80px">
                            @endif

                        </td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['created_at'] }}</td>
                        <td>{{ $user['updated_at'] }}</td>
                        <td>

                            <a class="btn btn-info rounded-pill"
                                href="{{ url('admin/users/') . $user['id'] . '/show' }}">Xem</a>

                            <a class="btn btn-warning rounded-pill"
                                href="{{ url('admin/users/') . $user['id'] . '/edit' }}">Sửa</a>

                            <a class="btn btn-danger rounded-pill"
                                href="{{ url('admin/users/') . $user['id'] . '/delete' }}"
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
                            <a class="page-link " href=" {{ url('admin/users?page=' . $page - 1) }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $totalPage; $i++)
                            <li class="page-item {{ $i == $page ? 'active' : '' }}"><a class="page-link"
                                    href="{{ url('admin/users?page=') . $i }}">{{ $i }}</a></li>
                        @endfor


                        <li class="page-item {{ $page == $totalPage ? 'disabled' : '' }}">
                            <a class="page-link "
                                href="{{ $page < $totalPage ? url('admin/users?page=' . $page + 1) : '' }}"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    @endsection
