<?php 

namespace Dangson\XuongOop\Controllers\Client;

use Dangson\XuongOop\Commons\Controller;

class CartController extends Controller
{
    public function cart() {
        $this-> renderViewClient('carts.cart');
    }

    public function store() {
        echo __CLASS__ . '@' . __FUNCTION__;
    }
}