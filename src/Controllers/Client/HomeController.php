<?php 

namespace Dangson\XuongOop\Controllers\Client;

use Dangson\XuongOop\Commons\Controller;
use Dangson\XuongOop\Commons\Helper;
use Dangson\XuongOop\Models\Category;
use Dangson\XuongOop\Models\Product;

class HomeController extends Controller
{
    private Product $product;

    private Category $category;

    public function __construct(){
        $this->product = new Product();

        $this->category = new Category();
    }

    public function index() {

        [$products, $totalPage ] = $this->product->paginateHome($_GET['page'] ?? 1);

        $categories = $this->category->all();

        $this->renderViewClient('home', [
            'products'      => $products,
            'total'         => $totalPage,
            'page'          => $_GET['page'] ?? 1,
            // 'categories'    => $categories
        ]);
    }
    public function shop() {

        $this->renderViewClient('products.productDetail');
    }
    
    
}