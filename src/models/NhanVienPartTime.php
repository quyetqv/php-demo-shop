<?php
require_once __DIR__ . '/NhanVien.php';
// Lớp con NhanVienPartTime kế thừa từ NhanVien
class NhanVienPartTime extends NhanVien {
    private $soGioLam;
    private $donGiaMoiGio;

    public function __construct($ten, $donGiaMoiGio, $soGioLam) {
        // Gán luongCoBan = 0 vì NhanVienPartTime không có lương cơ bản cố định
        parent::__construct($ten, 0); 
        $this->donGiaMoiGio = $donGiaMoiGio;
        $this->soGioLam = $soGioLam;
    }

    // Định nghĩa lại phương thức trừu tượng tinhLuong()
    public function tinhLuong() {
        return $this->donGiaMoiGio * $this->soGioLam;
    }
}