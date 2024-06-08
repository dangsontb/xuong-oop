<?php 

namespace Dangson\XuongOop\Controllers\Client;

use Dangson\XuongOop\Commons\Controller;
use Dangson\XuongOop\Models\Category;
use Dangson\XuongOop\Models\Product;

class ProductController extends Controller
{

    private Product $product;

    private Category $category;

    public function __construct(){
        $this->product = new Product();

        $this->category = new Category();
    }
    
    public function index() {

        [$products, $totalPage] =$this->product->paginateHome($_GET['page'] ?? 1, 9);

        $this -> renderViewClient('products.index',[
            'products' => $products,
            'totalPage' => $totalPage,
            'page'  => $_GET['page'] ?? 1
        ]);
    }

    public function detail($id) {
        $product = $this->product->findByID($id);

        $this -> renderViewClient('products.productDetail',[
            'product'=> $product,
        ]);
    }
}