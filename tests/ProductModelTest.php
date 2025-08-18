<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/models/ProductModel.php';

class ProductModelTest extends TestCase {
    public function testCreate() {
        // Tạo mock PDOStatement
        $mockStmt = $this->createMock(PDOStatement::class);
        $mockStmt->expects($this->any())->method('bindValue');
        $mockStmt->expects($this->once())->method('execute')->willReturn(true);

        // Tạo mock PDO
        $mockPDO = $this->createMock(PDO::class);
        $mockPDO->expects($this->once())
            ->method('prepare')
            ->willReturn($mockStmt);

        $model = new ProductModel($mockPDO);
        $result = $model->create('Test', 100, 1);
        $this->assertTrue($result);
    }
}