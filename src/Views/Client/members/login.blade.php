@extends('layouts.master')

@section('title')
    Login
@endsection

@section('content')
    <div class="col-lg-12 " style="margin-top: 100px">
        <div class="white_box mb_30 mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    @if (!empty($_SESSION['error']))
                        <div class="alert alert-warning">
                            
                            {{ $_SESSION['error'] }}
                            @php
                                unset($_SESSION['error']);
                            @endphp
                        </div>
                    @endif

                    <div class="modal-content cs_modal">
                        <div class="modal-header justify-content-center theme_bg_1">
                            <h2 class="modal-title text_white">Login</h2>
                        </div>

                        <div class="modal-body">

                            <form action="{{ url('auth/handle-login') }}" method="POST">
                                <div class>
                                    <input type="text" class="form-control" name="email"
                                        placeholder="Enter your email">
                                </div>
                                <div class>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                <button type="submit" class="btn_1 full_width text-center">Login</button>
                            </form>

                            <p>Need an account? <a data-bs-toggle="modal" data-bs-target="#sing_up" data-bs-dismiss="modal"
                                    href="{{url('auth/register')}}"> Register</a></p>
                           
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
