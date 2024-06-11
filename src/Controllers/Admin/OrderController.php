<?php

namespace Dangson\XuongOop\Controllers\Admin;

use Dangson\XuongOop\Commons\Controller;
use Dangson\XuongOop\Commons\Helper;
use Dangson\XuongOop\Models\Category;
use Dangson\XuongOop\Models\Order;
use Dangson\XuongOop\Models\OrderDetail;
use Dangson\XuongOop\Models\User;
use Rakit\Validation\Validator;

class OrderController extends Controller
{
    public Order $order;
    public OrderDetail $orderDetail;
    public User $user;

    public function __construct()
    {
        $this->order = new Order();
        $this->orderDetail = new OrderDetail();
        $this->user = new User();
    }

    public function index()
    {
        $orders = $this->order->getAllOrders();

        $this->renderViewAdmin('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show($id)
    {
        $order = $this->order->find($id);
        $orderDetails = $this->orderDetail->adminfindByOrderID($id);
        $user = $this->user->find($order['user_id']);
        // Helper::debug($orderDetails);
        
        $this->renderViewAdmin('orders.show', [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'user' => $user,
        ]);
        
    }

    public function updateStatus($id)
    {
        $status = $_POST['status_delivery'] ?? null;

        if ($status !== null) {
            $this->order->updateStatus($id, $status);
        }

        return $this->index(); 
    }
}