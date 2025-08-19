<?php
require_once __DIR__ . '/NhanVien.php';
// Lớp con NhanVienFullTime kế thừa từ NhanVien
class NhanVienFullTime extends NhanVien {
    private $phuCap;

    public function __construct($ten, $luongCoBan, $phuCap) {
        parent::__construct($ten, $luongCoBan);
        $this->phuCap = $phuCap;
    }

    // Định nghĩa lại phương thức trừu tượng tinhLuong()
    public function tinhLuong() {
        return $this->luongCoBan + $this->phuCap;
    }
}