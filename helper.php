<?php

const PATH_ROOT = __DIR__ . '/';

if (!function_exists('asset')) {
    function asset($path)
    {
        return $_ENV['BASE_URL'] . $path;
    }
}

if (!function_exists('url')) {
    function url($uri = null)
    {
        return $_ENV['BASE_URL'] . $uri;
    }
}

if (!function_exists('is_logged')) { // Check đăng nhập
    function is_logged()
    {
        return isset($_SESSION['user']);
    }
}
if (!function_exists('is_admin')) { // Check admin
    function is_admin()
    {
        return is_logged() && $_SESSION['user']['type'] ==  'admin';
    }
}

if(!function_exists('avoid_login')){ // BỎ qua trang login khi đã đăng nhập
    function avoid_login(){
        if(is_logged()){
            
            if($_SESSION['user']['type'] == 'admin'){
                header('Location: '. url('admin/'));
                exit;
            } 
    
            header('Location: '. url());
            exit;
        }   
    }
}

if(!function_exists('avoid_register')){ // BỎ qua trang đăng ký khi đã đăng nhập
    function avoid_register(){
        if(is_logged()){
            
            if($_SESSION['user']['type'] == 'admin'){
                header('Location: '. url('admin/'));
                exit;
            } 
    
            header('Location: '. url());
            exit;
        }   
    }
}


