<?php

namespace Dangson\XuongOop\Controllers\Client;

use Dangson\XuongOop\Commons\Controller;
use Dangson\XuongOop\Commons\Helper;
use Dangson\XuongOop\Models\Cart;
use Dangson\XuongOop\Models\CartDetail;
use Dangson\XuongOop\Models\Order;
use Dangson\XuongOop\Models\OrderDetail;
use Dangson\XuongOop\Models\Product;
use Dangson\XuongOop\Models\User;
use Rakit\Validation\Rules\Url;

class CartController extends Controller
{
    private Product $product;

    private CartDetail $cartDetail;

    private Cart $cart;

    private User $user;   
    private Order $order;   
    private OrderDetail $orderDetail;   

    public function __construct()
    {
        $this->product      = new Product();
        $this->cart         = new Cart();
        $this->cartDetail   = new CartDetail();
        $this->user         = new User();
        $this->order        = new Order();
        $this->orderDetail  = new OrderDetail();
    }

    public function add()
    {
        // Lấy thông tin sản phẩm qua ID
        $product = $this->product->findByID($_POST['productID']);
     
        // Khởi tạo SESSION CART
        // Check xem đăng nhập hay không
        $key = 'cart';
      
        if (isset($_SESSION['user'])) {
            $key .=  '-' . $_SESSION['user']['id'];
        }

        if (!isset($_SESSION[$key][$product['id']])) {

            $_SESSION[$key][$product['id']] =  $product + ['quantity' => $_POST['quantity'] ?? 1];
        } else{
            $_SESSION[$key][$product['id']]['quantity'] += $_POST['quantity'];
        }
        // Helper::debug($_SESSION['cart-user']);

        // Helper::debug($_SESSION['cart']);
        // Nếu mà nó đăng nhập thì mình phải lưu  vào  CSDL
        if (isset($_SESSION['user'])) {

            $conn = $this->cart->getConnection();

            // $conn->beginTransaction();
            try {

                $cart = $this->cart->findByUserID($_SESSION['user']['id']);
                
                if (empty($cart)) {
                    $this->cart->insert([
                        'user_id' => $_SESSION['user']['id'],
                    ]);
                }
                // Helper::debug($_SESSION['cart_id']);
                $cartID = $cart['id'] ??  $conn->lastInsertId();
                
                $_SESSION['cart_id'] = $cartID;
                
                $this->cartDetail->deleteByCartID($cartID);

                foreach ($_SESSION[$key] as $productID => $item) {

                    $this->cartDetail->insert([
                        'cart_id' => $cartID,
                        'product_id' => $productID,
                        'quantity'  => $item['quantity']
                    ]);
                }

                // $conn->commit();
            } catch (\Exception $e) {
                // $conn->rollBack();
                throw $e;
            }
        }
        // Helper::debug($_SESSION[$key][$product['id']]);
        // Helper::debug($_SESSION['cart' . '-' . $_SESSION['user']['id']]);

        header("Location: " . url('cart/detail'));
        exit;
    }

    public function detail()
    { // chi tiết giỏ hàng
        $this->renderViewClient('carts.cart');
    }


    public function quantityInc()
    { // Tăng số lượng
        // Lấy ra dữ liệu từ cart_detail để dảm bảo nó có tồn tại bản ghi
        
        $cartDetail = $this->cartDetail->findByCartIDAndProductID($_GET['cartID'], $_GET['productID']);

        if (!empty($cartDetail)) {
            //THay đỏi SESSION
            $key = 'cart';

            if (isset($_SESSION['user'])) {
                $key .=  '-' . $_SESSION['user']['id'];
            }

            $_SESSION[$key][$_GET['productID']]['quantity'] += 1;


            // Thay đổi trong db nếu đang đăng nhập
            if (isset($_SESSION['user'])) {
                $this->cartDetail->updateByCartIDAndProductID(
                    $_GET['cartID'],
                    $_GET['productID'],
                    $_SESSION[$key][$_GET['productID']]['quantity']
                );
            }

            header("Location: " . url('cart/detail'));
            exit;
        }

        $key = 'cart';

        $_SESSION[$key][$_GET['productID']]['quantity'] += 1;
        header("Location: " . url('cart/detail'));
        exit;
    }

    public function quantityDec()
    { //Giảm số lương
        // Lấy ra dữ liệu từ cart_detail để dảm bảo nó có tồn tại bản ghi
        $cartDetail = $this->cartDetail->findByCartIDAndProductID($_GET['cartID'], $_GET['productID']);
        $key = 'cart';
        if (!empty($cartDetail)) {
            //THay đỏi SESSION
 

            if (isset($_SESSION['user'])) {
                $key .=  '-' . $_SESSION['user']['id'];
            }

            if ($_SESSION[$key][$_GET['productID']]['quantity'] > 1) {
                $_SESSION[$key][$_GET['productID']]['quantity'] -= 1;
            }

            // Thay đổi trong db nếu đang đăng nhập
            if (isset($_SESSION['user'])) {
                $this->cartDetail->updateByCartIDAndProductID(
                    $_GET['cartID'],
                    $_GET['productID'],
                    $_SESSION[$key][$_GET['productID']]['quantity']
                );
            }

            header("Location: " . url('cart/detail'));
            exit;
        }

        if ($_SESSION[$key][$_GET['productID']]['quantity'] > 1) {
            $_SESSION[$key][$_GET['productID']]['quantity'] -= 1;
        }
        header("Location: " . url('cart/detail'));
        exit;
    }

    public function remove()
    { // xóa item or xóa trắng
        $key = 'cart';

        if (isset($_SESSION['user'])) {
            $key .= '-' . $_SESSION['user']['id'];
        }

        unset($_SESSION[$key][$_GET['productID']]);

        if (isset($_SESSION['user'])) {
            $this->cartDetail->deleteByCartIDAndProductID($_GET['cartID'], $_GET['productID'],);
        }

        header("Location: " . url('cart/detail'));
        exit;
    }
}
