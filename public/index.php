<?php
session_start();
require_once __DIR__ . '/../src/controllers/ProductController.php';
require_once __DIR__ . '/../src/controllers/CartController.php';
require_once __DIR__ . '/../src/controllers/OrderController.php';

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($request) {
    case '/':
    case '/products':
        $controller = new ProductController();
        $controller->index();
        break;
    case '/products/create':
        if ($method == 'POST') {
            $controller = new ProductController();
            $controller->create();
        } else {
            include __DIR__ . '/../views/product_form.php';
        }
        break;
    case '/products/delete':
        if ($method == 'POST') {
            $controller = new ProductController();
            $controller->delete();
        }
        break;
    
    case '/cart':
        $controller = new CartController();
        $controller->index();
        break;
    case '/cart/add':
        if ($method == 'POST') {
            $controller = new CartController();
            $controller->add();
        }
        break;
    case '/cart/update':
        if ($method == 'POST') {
            $controller = new CartController();
            $controller->update();
        }
        break;
    case '/cart/clear':
        if ($method == 'POST') {
            $controller = new CartController();
            $controller->clear();
        }
        break;
    case '/order/create':
        if ($method == 'POST') {
            $controller = new OrderController();
            $controller->create();
        }
        break;
    default:
        http_response_code(404);
        echo "404 Not Found!";
        break;
}