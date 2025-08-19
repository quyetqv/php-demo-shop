<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/NhanVienFullTime.php';
require_once __DIR__ . '/../models/NhanVienPartTime.php';

class ProductController {
    private $model;

    public function __construct() {
        $this->model = new ProductModel();
    }

    public function index() {

        // Sử dụng các lớp con
        // $nhanVienFullTime = new NhanVienFullTime("Nguyễn Văn A", 10000000, 2000000);
        // $nhanVienPartTime = new NhanVienPartTime("Trần Thị B", 50000, 100);

        // echo "Lương của nhân viên full-time " . $nhanVienFullTime->getTen() . " là: " . number_format($nhanVienFullTime->tinhLuong()) . " VND\n";
        // echo "Lương của nhân viên part-time " . $nhanVienPartTime->getTen() . " là: " . number_format($nhanVienPartTime->tinhLuong()) . " VND\n";

        // Sẽ báo lỗi Fatal error: Cannot instantiate abstract class NhanVien
        // $nhanVien = new NhanVien("Lê Văn C", 5000000); 

        // $top10Products = $this->model->getLatest10Products();

        $redis = new Redis();
        $redis->connect('redis', 6379); // 'redis' là tên service trong docker-compose

        $search = $_GET['search'] ?? '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $total = 0;
        $startQuery = microtime(true);

        $cacheKey = "products:{$search}:{$page}";
        $totalKey = "total";
        if ($redis->exists($cacheKey)) {
            $products = json_decode($redis->get($cacheKey), true);
            $total = $redis->get($totalKey);
        } else {
            $stmt = $this->model->getAll($search, $limit, $offset, $total);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $redis->set($cacheKey, json_encode($products), 60); // cache 60 giây
            $redis->set($totalKey, $total, 60); // cache 60 giây
        }

        $endQuery = microtime(true);
        $queryTime = round(($endQuery - $startQuery) * 1000, 2); // ms
        $totalPages = ceil($total / $limit);
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