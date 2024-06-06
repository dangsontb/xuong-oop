<?php 

namespace Dangson\XuongOop\Controllers\Client;

use Dangson\XuongOop\Commons\Controller;

class HomeController extends Controller
{
    public function index() {
        $name = 'DangSON';

        $this->renderViewClient('home', [
            'name' => $name
        ]);
    }
}