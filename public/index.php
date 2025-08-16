<?php
require_once __DIR__ . '/../src/controllers/ProductController.php';

$request = $_SERVER['REQUEST_URI'];
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
    default:
        http_response_code(404);
        echo "404 Not Found!";
        break;
}