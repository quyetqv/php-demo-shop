<?php
require_once __DIR__ . '/../Database.php';

class OrderModel {
    private $conn;
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function create($items) {
        $this->conn->beginTransaction();
        $stmt = $this->conn->prepare("INSERT INTO orders (created_at) VALUES (NOW())");
        $stmt->execute();
        $orderId = $this->conn->lastInsertId();
        $stmtItem = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($items as $item) {
            $stmtItem->execute([$orderId, $item['id'], $item['quantity'], $item['price']]);
        }
        $this->conn->commit();
        return $orderId;
    }
}
