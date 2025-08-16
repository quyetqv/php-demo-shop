<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController {
    private $model;

    public function __construct() {
        $this->model = new ProductModel();
    }

    public function index() {
        $stmt = $this->model->getAll();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__ . '/../../views/product_list.php';
    }

    public function create() {
        $name = $_POST['name'] ?? '';
        $price = $_POST['price'] ?? 0;
        $category_id = $_POST['category_id'] ?? null;
        
        if ($this->model->create($name, $price, $category_id)) {
            header("Location: /");
        } else {
            echo "Unable to create product.";
        }
    }
    
    public function delete() {
        $id = $_POST['id'] ?? null;
        if ($this->model->delete($id)) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                http_response_code(200);
                echo json_encode(['success' => true]);
                return;
            }
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Unable to delete product.']);
            return;
        }
        header("Location: /");
    }
}