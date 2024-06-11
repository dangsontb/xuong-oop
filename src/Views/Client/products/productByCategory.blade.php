@extends('layouts.master')

@section('title')
    Shop
@endsection

@section('content')
    <div class="container">
        <div class="p-b-10" style="margin-top: 100px;">
            <h3 class="ltext-103 cl5">
                Product Overview
            </h3>
        </div>

        <div class="flex-w flex-sb-m p-b-52">
   

            <div class="flex-w flex-c-m m-tb-10">
                <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                    <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                    <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    Filter
                </div>

         
            </div>

            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 p-b-15">
                <div class="bor8 dis-flex p-l-15">
                    <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>

                    <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
                        placeholder="Search">
                </div>
            </div>

            <!-- Filter -->
            <div class="dis-none panel-filter w-full p-t-10">
                <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                    <div class="filter-col1 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Sort By
                        </div>

                        <ul>
                            <li class="p-b-6">
                                <a href="#" class="filter-link stext-106 trans-04">
                                    Default
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="#" class="filter-link stext-106 trans-04">
                                    Popularity
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="#" class="filter-link stext-106 trans-04">
                                    Average rating
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="#" class="filter-link stext-106 trans-04 filter-link-active">
                                    Newness
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="#" class="filter-link stext-106 trans-04">
                                    Price: Low to High
                                </a>
                            </li>

                            <li class="p-b-6">
                                <a href="#" class="filter-link stext-106 trans-04">
                                    Price: High to Low
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <div class="row isotope-grid">
            @foreach ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ asset($product['img_thumbnail']) }}" alt="IMG-PRODUCT">

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
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                    <img class="icon-heart1 dis-block trans-04"
                                        src="{{ asset('assets/client/images/icons/icon-heart-01.png') }}" alt="ICON">
                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                        src="{{ asset('assets/client/images/icons/icon-heart-02.png') }}" alt="ICON">
                                </a>
                            </div>
                        </div>
                        <div>
                            <form action="{{ url('cart/add') }}" method="post">
                                <input type="hidden" name="productID"  value="{{$product['id']}}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="block0-btn flex-c-m stext-103 cl2 size-102 bg0 bor10  p-lr-10 trans-9">Add To Cart</button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>



        </div>

        <!-- Load more -->
        <div class="col-lg-12">
            <div class="white_box mb_30">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                            <a class="page-link " href=" {{ url('products/category_id/'. $category . '?page=' . $page - 1) }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $totalPage; $i++)
                            <li class="page-item  {{ $i == $page ? 'active' : '' }}"><a class="  page-link"
                                    href="{{ url('products/category_id/'. $category . '?page=' ) . $i }} ">{{ $i }}</a></li>
                        @endfor


                        <li class="page-item {{ $page == $totalPage ? 'disabled' : '' }}">
                            <a class="page-link "
                                href="{{ $page < $totalPage ? url('products/category_id/'. $category . '?page=' . $page + 1) : '' }}"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        
    </div>
@endsection
