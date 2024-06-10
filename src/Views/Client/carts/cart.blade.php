@extends('layouts.master')

@section('title')
    Cart of you
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="container" style="margin-top:100px">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Shoping Cart
            </span>
        </div>
    </div>


    <!-- Shoping Cart -->
    <div class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">

                @if (!empty($_SESSION['cart']) || !empty($_SESSION['cart-' . $_SESSION['user']['id']]))
                    <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                <table class="table-shopping-cart">
                                    <tr class="table_head">
                                        <th class="column-1">Ảnh </th>
                                        <th class="column-2"></th>
                                        <th class="column-3">Số lượng</th>
                                        <th class="column-4">Giá</th>
                                        <th class="column-5">Thành tiền</th>
                                        <th class="column-6">Xóa</th>
                                    </tr>

                                    @php
                                        $cart = $_SESSION['cart'] ?? $_SESSION['cart-' . $_SESSION['user']['id']];
                                        $total = 0;

                                    @endphp

                                    <!-- foreach san pham -->
                                    @foreach ($cart as $item)
                                        @php
                                            $intoMoney =
                                                $item['quantity'] * ($item['price_sale'] ?: $item['price_regular']);
                                            $total += $intoMoney;
                                        @endphp
                                        <tr class="table_row">
                                            <td class="column-1">
                                                <div class="how-itemcart1">
                                                    <img src="{{ asset($item['img_thumbnail']) }}" alt="IMG">
                                                </div>
                                            </td>
                                            <td class="column-2">{{ $item['name'] }}</td>
                                            <td class="column-3">

                                                @php
                                                    $url = url('cart/quantityDec') . '?productID=' . $item['id'];

                                                    // if (isset($_SESSION['cart-' . $_SESSION['user']['id']])) {
                                                    //     $url .= '&cartID=' . $_SESSION['cart_id'];
                                                    // }
                                                    $url .= '&cartID=' . $_SESSION['cart_id'];
                                                @endphp

                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                    <a href="{{ $url }}"
                                                        class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </a>

                                                    <input class="mtext-104 cl3 txt-center num-product" readonly
                                                        name="quantity" value="{{ $item['quantity'] }}">

                                                    @php
                                                        $url = url('cart/quantityInc') . '?productID=' . $item['id'];

                                                        // if (isset($_SESSION['cart-' . $_SESSION['user']['id']])) {
                                                        //     $url .= '&cartID=' . $_SESSION['cart_id'];
                                                        // }
                                                        $url .= '&cartID=' . $_SESSION['cart_id'];
                                                    @endphp

                                                    <a href="{{ $url }}"
                                                        class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </a>

                                                </div>
                                            </td>
                                            {{-- <td class="column-3">
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </div>

                                                    <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                        name="quantity" value="{{ $item['quantity']}}">

                                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </div>
                                                </div>
                                                
                                            </td> --}}
                                            <td class="column-4">
                                                {{ number_format($item['price_sale'] ?: $item['price_regular']) }}</td>
                                            <td class="column-5">
                                                {{ number_format($intoMoney) }}
                                            </td>
                                            <td class="column-6">
                                                @php

                                                    $url = url('cart/remove') . '?productID=' . $item['id'];

                                                    // if (isset($_SESSION['cart' . '-' . $_SESSION['user']['id']])) {
                                                    //     $url .= '&cartID=' . $_SESSION['cart_id'];
                                                    // }
                                                    $url .= '&cartID=' . $_SESSION['cart_id'];
                                                @endphp

                                                <a class="btn" onclick="return confirm('Có chắc chắn không ?')"
                                                    href="{{ $url }}">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach


                                </table>
                            </div>
                        </div>
                    </div>
                    <form action="{{ url('order/checkout') }}" method="POST"
                        class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            @if (!empty($_SESSION['errors-checkout']))
                                <div class="alert alert-warning">
                                    <ul>
                                        @foreach ($_SESSION['errors-checkout'] as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>

                                    @php
                                        unset($_SESSION['errors-checkout']);
                                    @endphp
                                </div>
                            @endif
                            <h4 class="mtext-109 cl2 p-b-30">
                                Your Information
                            </h4>

                            <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                                <div class="size-208 w-full-ssm">
                                    <span class="stext-110 cl2">
                                        Name
                                    </span>
                                </div>

                                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="user_name"
                                            value="{{ $_SESSION['user']['name'] ?? null }}" placeholder="Enter Name">
                                    </div>
                                </div>

                                <div class="size-208 w-full-ssm">
                                    <span class="stext-110 cl2">
                                        Email
                                    </span>
                                </div>

                                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="email" name="user_email"
                                            value="{{ $_SESSION['user']['email'] ?? null }}" placeholder="Enter Email">
                                    </div>
                                </div>

                                <div class="size-208 w-full-ssm">
                                    <span class="stext-110 cl2">
                                        Phone
                                    </span>
                                </div>

                                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="user_phone"
                                            value="{{ $_SESSION['user']['phone'] ?? null }}" placeholder="Enter Phone">
                                    </div>
                                </div>

                                <div class="size-208 w-full-ssm">
                                    <span class="stext-110 cl2">
                                        Address
                                    </span>
                                </div>

                                <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text"
                                            name="user_address" value="{{ $_SESSION['user']['address'] ?? null }}"
                                            placeholder="Enter Address">
                                    </div>
                                </div>

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="payment" value="1" checked>Momo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="payment" value="0" > Thanh toán sau khi nhận hàng
                                    </label>
                                </div>
                         

                        </div>
                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Total:
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    @if (!empty($_SESSION['cart']) || !empty($_SESSION['cart' . '-' . $_SESSION['user']['id']]))
                                        {{ number_format($total) }}
                                    @endif
                                </span>

                                <input type="hidden" name="totalPrice" value="{{$total}}">
                            </div>
                        </div>
                        <button
                            type="submit" name="payUrl" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Proceed to Checkout
                        </button>

            </div>
            </form>

            @endif

        </div>
    </div>
@endsection
