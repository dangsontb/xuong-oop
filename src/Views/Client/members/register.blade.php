@extends('layouts.master')

@section('title')
    Register
@endsection

@section('content')
    <div class="col-lg-12 mt-5">
        <div class="white_box mb_30">
            <div class="row justify-content-center">
                <div class="col-lg-6">

                    <div class="modal-content cs_modal">
                        <div class="modal-header theme_bg_1 justify-content-center">
                            <h5 class="modal-title text_white">Resister</h5>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class>
                                    <input type="text" class="form-control" placeholder="Full Name">
                                </div>
                                <div class>
                                    <input type="text" class="form-control" placeholder="Enter your email">
                                </div>
                                <div class>
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>
                               
                                <a href="#" class="btn_1 full_width text-center"> Sign Up</a>
                                <p>Need an account? <a data-bs-toggle="modal" data-bs-target="#sing_up"
                                        data-bs-dismiss="modal" href="#">Log in</a></p>
                                <div class="text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#forgot_password"
                                        data-bs-dismiss="modal" class="pass_forget_btn">Forget
                                        Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
