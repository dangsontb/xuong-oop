@extends('layouts.master')

@section('title', 'Order Details')

@section('content')
<div class="container">
    <h1 class="mt-4">Order Details</h1>
    <div class="card mt-4">
        <div class="card-header">
            Order #{{ $order['id'] }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Customer: {{ $user['name'] }}</h5>
            <p class="card-text">Email: {{ $user['email'] }}</p>
            <p class="card-text">Phone: {{ $user['phone'] }}</p>
            <p class="card-text">Address: {{ $order['user_address'] }}</p>
            <h5 class="mt-4">Order Items</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderDetails as $detail)
                    <tr>
                        <td>{{ $detail['product_id'] }}</td>
                        <td>{{ $detail['quantity'] }}</td>
                        <td>{{ $detail['price_sale'] }}</td>
                        <td>{{ $detail['quantity'] * $detail['price_sale'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ url('admin/orders') }}" class="btn btn-primary mt-4">Back to Orders</a>
        </div>
    </div>
</div>
@endsection
