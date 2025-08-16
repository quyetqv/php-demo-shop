<?php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class OrderController {
    private $orderModel;
    private $cartModel;
    private $productModel;
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
    }
    public function create() {
        $cart = $this->cartModel->getCart();
        $products = [];
        foreach ($cart as $productId => $qty) {
            $product = $this->productModel->getById($productId);
            if ($product) {
                $product['quantity'] = $qty;
                $products[] = $product;
            }
        }
        if (!empty($products)) {
            $this->orderModel->create($products);
            $this->cartModel->clearCart();
            header('Location: /cart?success=1');
            exit;
        } else {
            $msg = 'Cart is empty!';
            include __DIR__ . '/../../views/order_result.php';
        }
    }
}
