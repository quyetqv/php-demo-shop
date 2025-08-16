<?php
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class CartController {
    private $cartModel;
    private $productModel;
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
    }

    public function index() {
        $cart = $this->cartModel->getCart();
        $products = [];
        $total = 0;
        foreach ($cart as $productId => $qty) {
            $stmt = $this->productModel->getAll('', 1, 0);
            $product = $this->productModel->getById($productId);
            if ($product) {
                $product['quantity'] = $qty;
                $product['subtotal'] = $qty * $product['price'];
                $products[] = $product;
                $total += $product['subtotal'];
            }
        }
        include __DIR__ . '/../../views/cart.php';
    }

    public function add() {
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;
        if ($productId) {
            $this->cartModel->addToCart($productId, $quantity);
        }
        header('Location: /cart');
    }

    public function update() {
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;
        if ($productId) {
            $this->cartModel->updateCart($productId, $quantity);
        }
        header('Location: /cart');
    }

    public function clear() {
        $this->cartModel->clearCart();
        header('Location: /cart');
    }
}
