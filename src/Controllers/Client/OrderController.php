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
use Rakit\Validation\Validator;

class OrderController extends Controller
{
    public Order $order;

    public User $user;

    public OrderDetail $orderDetail;

    private Cart $cart;
    private CartDetail $cartDetail;

    private Product $product;

    public function __construct()
    {
        $this->user         = new User();
        $this->order        = new Order();
        $this->orderDetail  = new OrderDetail;
        $this->cartDetail   = new CartDetail;
        $this->cart         = new Cart;
        $this->product      = new Product();
    }


    public function checkout()
    { // CHưa đang nhập phải tạo tài khoản 
        $validator = new Validator;

        $validation = $validator->make($_POST, [
            'user_name'             => 'required:min:6',
            'user_email'            => 'required|email',
            'user_phone'            => 'required|numeric:10',
            'user_address'          => 'required',
        ]);
        $validation->validate();

        if ($validation->fails()) {
            // handling errors
            $_SESSION['errors-checkout'] = $validation->errors()->firstOfAll();

            header('Location: ' . url('cart/detail'));
        } else {

            $userID = $_SESSION['user']['id'] ?? null;


            // if(isset($_GET['resultCode']) &&  $_GET['resultCode']== 0){
            //     echo 'insetr';
            // }

            if ($_POST['payment']  == '0') {

                if (!$userID) {
                    $conn = $this->user->getConnection();
                    $this->user->insert([
                        'name'          => $_POST['user_name'],
                        'email'         => $_POST['user_email'],
                        'password'      => password_hash($_POST['user_email'], PASSWORD_DEFAULT),
                        'type'          => 'member',
                        'is_active'     => 0

                    ]);

                    $userID = $conn->lastInsertId();
                }

                // Thêm dữ liệu vào order và order_detail
                $conn = $this->order->getConnection();

                $this->order->insert([
                    'user_id'           => $userID,
                    'user_name'         => $_POST['user_name'],
                    'user_email'        => $_POST['user_email'],
                    'user_phone'        => $_POST['user_phone'],
                    'user_address'      => $_POST['user_address'],

                ]);

                $orderID = $conn->lastInsertId();

                $key = 'cart';

                if (isset($_SESSION['user'])) {
                    $key .=  '-' . $_SESSION['user']['id'];
                }


                foreach ($_SESSION[$key] as $productID => $item) {

                    $this->orderDetail->insert([
                        'order_id'         => $orderID,
                        'product_id'       => $productID,
                        'quantity'         => $item['quantity'],
                        'price_regular'    => $item['price_regular'],
                        'price_sale'       => $item['price_sale'] ?: null,
                    ]);
                }

                // Xóa dữ liệu cart  và cartDetail theo CartID -  $_SESSION['cart_id']

                $this->cartDetail->deleteByCartID($_SESSION['cart_id']);

                $this->cart->deleteByUserID($userID);

                // Xóa session


                unset($_SESSION[$key]);

                if (isset($_SESSION['user'])) {
                    unset($_SESSION['cart_id']);
                }

                $_SESSION['success'] = 'Thanh toán thành công';

                header("Location: " . url('order/oderDetail'));
                exit;
            } else { // MOMOO
                $_SESSION['info-order'] = [
                    'name'              => $_POST['user_name'],
                    'email'             => $_POST['user_email'],
                    'password'          => password_hash($_POST['user_email'], PASSWORD_DEFAULT),
                    'type'              => 'member',
                    'is_active'         => 0,
                    'user_phone'        => $_POST['user_phone'],
                    'user_address'      => $_POST['user_address'],
                ];



                $this->momoPay($_POST['totalPrice']);
            }
        }
    }

    public function momo()
    {
        if (isset($_GET['resultCode']) &&  $_GET['resultCode'] == 0) {

            $userID = $_SESSION['user']['id'] ?? null;

            if (!$userID) {

                $conn = $this->user->getConnection();

                $this->user->insert([
                    'name'          => $_SESSION['info-order']['name'],
                    'email'         => $_SESSION['info-order']['email'],
                    'password'      => password_hash($_SESSION['info-order']['email'], PASSWORD_DEFAULT),
                    'type'          => 'member',
                    'is_active'     => 0

                ]);

                $userID = $conn->lastInsertId();
            }

            // Thêm dữ liệu vào order và order_detail
            $conn = $this->order->getConnection();

            $this->order->insert([
                'user_id'           => $userID,
                'user_name'         => $_SESSION['info-order']['name'],
                'user_email'        => $_SESSION['info-order']['email'],
                'user_phone'        => $_SESSION['info-order']['user_phone'],
                'user_address'      => $_SESSION['info-order']['user_address'],

            ]);

            $orderID = $conn->lastInsertId();

            $key = 'cart';

            if (isset($_SESSION['user'])) {
                $key .=  '-' . $_SESSION['user']['id'];
            }


            foreach ($_SESSION[$key] as $productID => $item) {

                $this->orderDetail->insert([
                    'order_id'         => $orderID,
                    'product_id'       => $productID,
                    'quantity'         => $item['quantity'],
                    'price_regular'    => $item['price_regular'],
                    'price_sale'       => $item['price_sale'] ?: null,
                ]);
            }

            // Xóa dữ liệu cart  và cartDetail theo CartID -  $_SESSION['cart_id']

            $this->cartDetail->deleteByCartID($_SESSION['cart_id']);

            $this->cart->deleteByUserID($userID);

            // Xóa session


            unset($_SESSION[$key]);

            if (isset($_SESSION['user'])) {
                unset($_SESSION['cart_id']);
            }

            unset($_SESSION['info-order']);

            $_SESSION['success'] = 'Thanh toán thành công';

            header("Location: " . url('order/oderDetail'));  // order-detail
            exit;
        }
    }

    public function orderHistory()
    {
        $userID = $_SESSION['user']['id'] ?? null;
        if (!$userID) {
            header('Location: ' . url('login'));
            exit;
        }

        $orders = $this->order->findByUserID($userID);
        $orderDetails = [];

        foreach ($orders as $order) {
            $orderDetails= $this->orderDetail->findByOrderIDClient($order['id']);
         
        }
        //   echo '<pre>';
        //     print_r($orderDetails);
        $this->renderViewClient('orders.orderDetail',
            [
                'orders' => $orders,
                'orderDetails' => $orderDetails,
            ]
        );
    }

    
}
