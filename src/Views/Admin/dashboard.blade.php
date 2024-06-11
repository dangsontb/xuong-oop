@extends('layouts.master')
@section('title')
    Dashboard
@endsection


@section('content')
<div class="row">
    <div class="col-12">
        <div class="page_title_box d-flex align-items-center justify_content_between">
            <div class="page_title_left">
                <h3 class="f_s_30 f_w_700 text_white">Dashboard</h3>
            </div>
        </div>
    </div>
</div>
  
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="container-fluid p-0">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="dashboard_header mb_50">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="dashboard_header_title">
                                            <h3> Chart Box</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="dashboard_breadcam text-end">
                                            <p><a href="index-2.html">Dashboard</a> <i class="fas fa-caret-right"></i> Chart
                                                Box</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 widget-chart">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg bg-primary"></div>
                                    <i class="ti-settings text-primary"></i>
                                </div>
                                <div class="widget-numbers"><span>{{ $totalProducts }}</span></div>
                                <div class="widget-subheading">Tổng số sản phẩm</div>
                                <div class="widget-description text-success">
                                    <i class="fa fa-angle-up ">
                                    </i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 widget-chart">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg bg-danger"></div>
                                    <i class="ti-settings text-danger"></i>
                                </div>
                                <div class="widget-numbers"><span>{{ $totalCategories }}</span></div>
                                <div class="widget-subheading">Tổng số danh mục</div>
                                <div class="widget-description text-primary">
                                    <i class="fa fa-angle-up ">
                                    </i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 widget-chart">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg bg-info"></div>
                                    <i class="ti-settings text-info"></i>
                                </div>
                                <div class="widget-numbers"><span>{{ $totalUsers }}</span></div>
                                <div class="widget-subheading">Tổng số người dùng</div>
                                <div class="widget-description text-info">
                                    <i class="fa fa-arrow-right ">
                                    </i>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <h4 class="mt-5">Tổng số sản phẩm theo danh mục</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Danh mục</th>
                            <th>Tổng số sản phẩm</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productCounts as $count)
                        <tr>
                            <td>{{ $count['category_name'] }}</td>
                            <td>{{ $count['total'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
