<?php

// Định nghĩa một abstract class tên là NhanVien
abstract class NhanVien {
    protected $ten;
    protected $luongCoBan;

    // Abstract method (phương thức trừu tượng) phải được các lớp con định nghĩa lại
    abstract public function tinhLuong();

    // Constructor chung cho các lớp con
    public function __construct($ten, $luongCoBan) {
        $this->ten = $ten;
        $this->luongCoBan = $luongCoBan;
    }

    // Phương thức thông thường
    public function getTen() {
        return $this->ten;
    }
}