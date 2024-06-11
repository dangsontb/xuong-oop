@extends('layouts.master')

@section('title')
Danh sách Order
@endsection

@section('content')
<div class="container">
    <h1 class="mt-4">Order Management</h1>
   
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Delivery Status</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order['id'] }}</td>
                <td>{{ $order['user_name'] }}</td>
                <td>
                    <form action="{{ url('admin/orders/' . $order['id'] . '/status/update') }}" method="POST">
                        @csrf
                        <select name="status_delivery" class="form-control" onchange="this.form.submit()">
                            <option value="0" {{ $order['status_delivery'] == 0 ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="1" {{ $order['status_delivery'] == 1 ? 'selected' : '' }}>Chờ lấy hàng</option>
                            <option value="2" {{ $order['status_delivery'] == 2 ? 'selected' : '' }}>Chờ giao hàng</option>
                            <option value="3" {{ $order['status_delivery'] == 3 ? 'selected' : '' }}>Đã giao</option>
                            <option value="4" {{ $order['status_delivery'] == 4 ? 'selected' : '' }}>Đã hủy</option>
                            <option value="5" {{ $order['status_delivery'] == 5 ? 'selected' : '' }}>Trả hàng</option>
                        </select>
                    </form>
                </td>
                <td>{{ $order['status_payment'] }}</td>
                <td>
                    <a href="{{ url('admin/orders/' . $order['id']) }}" class="btn btn-info">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
