<?php

// Website có các trang là:
//      Trang chủ
//      Giới thiệu
//      Sản phẩm
//      Chi tiết sản phẩm
//      Liên hệ

// Để định nghĩa được, điều đầu tiên làm là phải tạo Controller trước
// Tiếp theo, khai function tương ứng để xử lý
// Bước cuối, định nghĩa đường dẫn

// HTTP Method: get, post, put (path), delete, option, head

use Dangson\XuongOop\Controllers\Client\AboutController;
use Dangson\XuongOop\Controllers\Client\ContactController;
use Dangson\XuongOop\Controllers\Client\HomeController;
use Dangson\XuongOop\Controllers\Client\LoginController;
use Dangson\XuongOop\Controllers\Client\ProductController;

$router->get( '/',                  HomeController::class       . '@index');
$router->get( '/about',             AboutController::class      . '@index');

$router->get( '/contact',           ContactController::class    . '@index');
$router->post( '/contact/store',    ContactController::class    . '@store');

$router->get( '/products',          ProductController::class    . '@index');
$router->get( '/products/{id}',     ProductController::class    . '@detail');

$router->get( '/auth/login',             LoginController::class      . '@showFormLogin');
$router->post( '/auth/handle-login',     LoginController::class      . '@login');
$router->post( '/auth/logout',           LoginController::class      . '@logout');
