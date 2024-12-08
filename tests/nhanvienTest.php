<?php
use PHPUnit\Framework\TestCase;

require_once 'classnhanvien.php'; // Đường dẫn tới lớp Nhanvien
require_once 'connection.php';    // Đường dẫn tới kết nối cơ sở dữ liệu

class NhanvienTest extends TestCase {

    public function testSoLuongNhanVien() {
        // Kiểm tra tổng số lượng nhân viên trả về là kiểu số nguyên
        $this->assertIsInt(Nhanvien::soluongnhanvien());
    }

    public function testTangManv() {
        // Tạo mock đối tượng kết nối MySQLi
        $mockConn = $this->createMock(mysqli::class);
        $mockConn->method('query')
                 ->willReturn(new class {
                     public function num_rows() { return 1; }
                     public function fetch_assoc() {
                         return ["MANV" => "NV009"];
                     }
                 });

        $newId = Nhanvien::TangManv($mockConn);
        $this->assertEquals("NV010", $newId);
    }

    public function testAddNhanVien() {
        // Tạo đối tượng nhân viên mới để kiểm tra
        $nhanVien = new Nhanvien("", "Le Van A", "123 ABC Street", "0123456789", "Quản lý", 20000000);
        $this->assertTrue(Nhanvien::Add($nhanVien));
    }

    public function testEditNhanVien() {
        // Kiểm tra cập nhật thông tin nhân viên
        $nhanVien = new Nhanvien("NV002", "Nguyen Van B", "456 XYZ Avenue", "0987654321", "Nhân viên", 12000000);
        $this->assertTrue(Nhanvien::Edit($nhanVien));
    }

    public function testDeleteNhanVien() {
        // Kiểm tra xóa nhân viên theo mã
        $this->assertTrue(Nhanvien::Delete("NV003"));
    }

    public function testGetAllNhanVien() {
        // Kiểm tra lấy danh sách tất cả nhân viên
        $result = Nhanvien::GetAll();
        $this->assertIsArray($result);
        if (count($result) > 0) {
            $this->assertInstanceOf(Nhanvien::class, $result[0]);
        }
    }

    public function testGetNhanVienById() {
        // Kiểm tra lấy thông tin nhân viên theo mã
        $result = Nhanvien::Get("NV001");
        $this->assertIsArray($result);
        if (count($result) > 0) {
            $this->assertInstanceOf(Nhanvien::class, $result[0]);
        }
    }

    public function testGetElementNhanVien() {
        // Kiểm tra tìm kiếm nhân viên theo từ khóa
        $result = Nhanvien::GetElement("Le");
        $this->assertIsArray($result);
        if (count($result) > 0) {
            $this->assertInstanceOf(Nhanvien::class, $result[0]);
        }
    }

    public function testGetManvList() {
        // Kiểm tra lấy danh sách mã nhân viên và tên
        $result = Nhanvien::GetManv();
        $this->assertIsArray($result);
        if (count($result) > 0) {
            $this->assertArrayHasKey("MANV", $result[0]);
            $this->assertArrayHasKey("TENNV", $result[0]);
        }
    }
}
