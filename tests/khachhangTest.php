<?php
use PHPUnit\Framework\TestCase;

require_once 'classkhachhang.php';
require_once 'connection.php'; // Đảm bảo đường dẫn chính xác

class KhachhangTest extends TestCase {

    public function testSoLuongKhachHang() {
        // Kiểm tra phương thức soluongkhachhang
        $this->assertIsInt(Khachhang::soluongkhachhang());
    }

    public function testTangMakh() {
        $mockConn = $this->createMock(mysqli::class);
        $mockConn->method('query')
                 ->willReturn(new class {
                     public function num_rows() { return 1; }
                     public function fetch_assoc() {
                         return ["MAKH" => "KH005"];
                     }
                 });
        $newId = Khachhang::TangMakh($mockConn);
        $this->assertEquals("KH006", $newId);
    }

    public function testAddKhachHang() {
        $khachHang = new Khachhang("", "Nguyen Van A", "123 ABC Street", "0123456789");
        $this->assertTrue(Khachhang::Add($khachHang));
    }

    public function testEditKhachHang() {
        $khachHang = new Khachhang("KH001", "Nguyen Van B", "456 XYZ Avenue", "0987654321");
        $this->assertTrue(Khachhang::Edit($khachHang));
    }

    public function testDeleteKhachHang() {
        $this->assertTrue(Khachhang::Delete("KH002"));
    }

    public function testGetAll() {
        $result = Khachhang::GetAll();
        $this->assertIsArray($result);
        if (count($result) > 0) {
            $this->assertInstanceOf(Khachhang::class, $result[0]);
        }
    }

    public function testGetById() {
        $result = Khachhang::Get("KH001");
        $this->assertIsArray($result);
        $this->assertInstanceOf(Khachhang::class, $result[0]);
    }

    public function testGetElement() {
        $result = Khachhang::GetElement("Nguyen");
        $this->assertIsArray($result);
        if (count($result) > 0) {
            $this->assertInstanceOf(Khachhang::class, $result[0]);
        }
    }
}
