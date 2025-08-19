<?php
require_once __DIR__ . '/../Database.php';

class ProductModel {
    private $conn;
    private $table_name = "products";

    public function __construct($conn = null) {
        if ($conn) {
            $this->conn = $conn;
        } else {
            $database = new Database();
            $this->conn = $database->getConnection();
        }
    }

    public function getAll($search = '', $limit = 10, $offset = 0, &$total = 0) {
        $where = '';
        $params = [];
        if ($search !== '') {
            // Nếu search không chứa ký tự wildcard, tìm kiếm đầu chuỗi để tận dụng index
            if (preg_match('/^[a-zA-Z0-9 ]+$/', $search)) {
                $where = 'WHERE p.name LIKE :search';
                $params[':search'] = $search . '%';
            } else {
                $where = 'WHERE p.name LIKE :search';
                $params[':search'] = '%' . $search . '%';
            }
        }
        $countQuery = "SELECT COUNT(*) FROM " . $this->table_name . " p ";
        if ($where) $countQuery .= $where;
        $countStmt = $this->conn->prepare($countQuery);
        foreach ($params as $k => $v) $countStmt->bindValue($k, $v);
        $countStmt->execute();
        $total = $countStmt->fetchColumn();

        $query = "SELECT p.*, c.name as category_name FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id ";
        if ($where) $query .= $where . ' ';
        $query .= "ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        // Bind all params an toàn
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, is_int($v) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function create($name, $price, $category_id) {
        $query = "INSERT INTO " . $this->table_name . " (name, price, category_id) VALUES (:name, :price, :category_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":name", $name, \PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, \PDO::PARAM_STR);
        $stmt->bindValue(":category_id", $category_id, is_null($category_id) ? \PDO::PARAM_NULL : \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT p.*, c.name as category_name FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getLatest10Products() {
        $query = "SELECT p.*, c.name as category_name FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 10";
        $stmt = $this->conn->prepare($query);
        // Binding all all value if we have any
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}