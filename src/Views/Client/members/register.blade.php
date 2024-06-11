@extends('layouts.master')

@section('title')
    Register
@endsection

@section('content')
    <div class="col-lg-12 " style="margin-top: 100px">
        <div class="white_box mb_30">
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    @if (!empty($_SESSION['errors']))
                    <div class="alert alert-warning">
                        
                        @foreach ($_SESSION['errors'] as $error)
                            <ul>
                                <li>{{$error }}</li>
                            </ul>
                        @endforeach
                        @php
                            unset($_SESSION['errors']);
                        @endphp
                    </div>
                @endif

                    <div class="modal-content cs_modal">
                        <div class="modal-header theme_bg_1 justify-content-center">
                            <h5 class="modal-title text_white">Register</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('auth/handle-register')}}" method="POST">
                                <div class>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>
                                <div class>
                                    <input type="text" name="email" class="form-control" placeholder="Enter your email">
                                </div>
                                <div class>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <div class>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm  Password">
                                </div>
                               
                                <button type="submit" class="btn_1 full_width text-center">Register</button>
                                <p>Need an account? <a data-bs-toggle="modal" data-bs-target="#sing_up"
                                        data-bs-dismiss="modal" href="{{ url('auth/login')}}">Log in</a></p>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
