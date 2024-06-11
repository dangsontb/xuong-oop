<?php

namespace Dangson\XuongOop\Controllers\Admin;

use Dangson\XuongOop\Commons\Controller;
use Dangson\XuongOop\Commons\Helper;
use Dangson\XuongOop\Models\Category;
use Dangson\XuongOop\Models\Product;
use Dangson\XuongOop\Models\User;

class DashboardController extends Controller
{
   
    public Category $category;
    public Product $product;
    public User $user;

    public function __construct()
    {
        $this->category = new Category();
        $this->product = new Product();
        $this->user = new User();
    }

    public function  dashboard()
    {
        $totalProducts = $this->product->count();
        $totalCategories = $this->category->count();
        $totalUsers = $this->user->count();

        $productCounts = $this->category->getAllWithProductCount();

        $this->renderViewAdmin('dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers,
            'productCounts' => $productCounts,
        ]);
    }
}