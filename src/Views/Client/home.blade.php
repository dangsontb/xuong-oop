@extends('layouts.master')

@section('title')
    Trang chủ
@endsection
@section('slide')
    @include('layouts.partials.slide')
@endsection

@section('banner')
    @include('layouts.partials.banner')
@endsection

@section('content')
    <div class="container">
        <div class="p-b-10">
            <h3 class="ltext-103 cl5">
                Product Overview
            </h3>
        </div>



        <div class="row isotope-grid">

            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ asset($product['img_thumbnail']) }}" height="220px" alt="IMG-PRODUCT">

                            <a href="{{ url('productDetail/' . $product['id']) }}"
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 ">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product['name'] }}
                                </a>

                                <span class="stext-105 cl3 text-danger ">
                                    {{ $product['price_sale'] ? number_format($product['price_sale']) : '' }}
                                </span>
                                <span class="opacity-25}}">
                                    {{ !$product['price_sale'] ? number_format($product['price_regular']) : '' }}
                                </span>
                            </div>

                            <div class="block2-txt-child2 flex-r p-t-3">

                                <form action="{{ url('cart/add') }}" method="post">
                                    <input type="hidden" name="productID"  value="{{$product['id']}}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-secondary btn-sm rounded-pill">Add To Cart</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Load more -->
        <div class="flex-c-m flex-w w-full p-t-45">
            <a href="{{ url('products') }}" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                Xem thêm
            </a>
        </div>
    </div>
@endsection
