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
use Dangson\XuongOop\Controllers\Client\CartController;
use Dangson\XuongOop\Controllers\Client\ContactController;
use Dangson\XuongOop\Controllers\Client\HomeController;
use Dangson\XuongOop\Controllers\Client\LoginController;
use Dangson\XuongOop\Controllers\Client\OrderController;
use Dangson\XuongOop\Controllers\Client\ProductController;

$router->get( '/',                          HomeController::class       . '@index');


$router->get( 'about',                      AboutController::class      . '@index');

$router->get( 'contact',                    ContactController::class    . '@index');
$router->post( 'contact/store',             ContactController::class    . '@store');

$router->get( 'productDetail/{id}',         ProductController::class    . '@detail');
$router->get( 'products',                   ProductController::class    . '@index');
$router->get( 'products/category_id/{id}',  ProductController::class    . '@findByCategory');


$router->get( 'auth/login',                 LoginController::class      . '@showFormLogin');
$router->post( 'auth/handle-login',         LoginController::class      . '@login');
$router->get( 'auth/register',              LoginController::class      . '@showFormRegister');
$router->get( 'auth/logout',                LoginController::class      . '@logout');

$router -> post('cart/add',                 CartController::class       . '@add');
$router -> get('cart/quantityInc',          CartController::class       . '@quantityInc');
$router -> get('cart/quantityDec',          CartController::class       . '@quantityDec');
$router -> get('cart/remove',               CartController::class       . '@remove');

$router-> get('cart/detail',                CartController::class       . '@detail' );

$router-> post('order/checkout',            OrderController::class      . '@checkout' );

$router-> get('order/momo',                 OrderController::class       . '@momo' );