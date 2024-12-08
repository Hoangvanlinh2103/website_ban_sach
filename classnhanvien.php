<?php
    require_once("connection.php");
    class Nhanvien{
        public $manv;
        public $tennv;
        public $diachinv;
        public $sdt;
        public $chucvu;
        public $luong;
        public function __construct($mnv,$tnv,$dcnv,$sdt,$cv,$lg){
            $this->manv = $mnv;
            $this->tennv = $tnv;
            $this->diachinv = $dcnv;
            $this->sdt = $sdt;
            $this->chucvu = $cv;
            $this->luong = $lg;
        }
        public function __destruct(){

        }


        // Đếm số lượng nhân viên trong hệ thống
        public static function soluongnhanvien(){
            $conn = DBConnection::Connect();
            $sql = "SELECT COUNT(MANV) AS tongnv FROM tbnhanvien";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tongnv = $row['tongnv'];
            } else {
                $tongnv = 0; // Nếu không có kết quả trả về, đặt tổng số khách hàng là 0
            }
        
            $conn->close();
            return $tongnv;
        }


        // Tăng mã nhân viên tự động
        public static function TangManv($conn) {
            $sql = "SELECT MANV FROM tbnhanvien ORDER BY LPAD(SUBSTRING(MANV, 3), 10, '0') DESC LIMIT 1;";
            $result = $conn->query($sql);
            $newId = "NV1";
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = $row["MANV"];  
                $number = intval(substr($lastId, 2)) + 1;  // substr($lastId, 2) cắt bỏ phần NV giữ lại phần số, intval chuyển đổi phần số thành số nguyên sau đó tăng 1
                $newId = "NV" . sprintf("%03d", $number);
            }
            return $newId;
        }


        // Thêm dữ liệu vào bảng nhân viên
        public static function Add(Nhanvien $nv){
            $success = false;
            $conn = DBConnection::Connect();
            $nv->manv = self::TangManv($conn);
            $sql = "INSERT INTO tbnhanvien(MANV,TENNV,DIACHINV,SDT,CHUCVU,LUONG) VALUES(?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssd",$nv->manv,$nv->tennv,$nv->diachinv,$nv->sdt,$nv->chucvu,$nv->luong);
            if($success = $stmt->execute()){
                echo "<script> alert('Thêm nhân viên thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Cập nhật dư liệu nhân viên theo mã
        public static function Edit(Nhanvien $nv){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbnhanvien SET TENNV = ?, DIACHINV = ?, SDT = ?, CHUCVU = ?, LUONG = ? WHERE MANV = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssisds",$nv->tennv,$nv->diachinv,$nv->sdt,$nv->chucvu,$nv->luong,$nv->manv);
            if($success = $stmt->execute()){
                echo "<script> alert('Thay đổi thông tin nhân viên thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Xóa dữ liệu nhân viên
        public static function Delete(string $manv){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM tbnhanvien WHERE MANV = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$manv);
            if($success = $stmt->execute()){
                echo "<script> alert('Xóa nhân viên thành công'); </script> ";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Lấy danh sách dữ liệu nhân viên
        public static function GetAll(){
            $dsnv = array();
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbnhanvien";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dsnv[] = new Nhanvien($row["MANV"],$row["TENNV"],$row["DIACHINV"],$row["SDT"],$row["CHUCVU"],$row["LUONG"]);
            }
            $conn->close();
            return $dsnv;
        }


        // Lấy dữ liệu nhân viên theo mã 
        public static function Get(string $tim){
            $dsnv = array();
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbnhanvien WHERE MANV = '$tim' ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dsnv[] = new Nhanvien($row["MANV"],$row["TENNV"],$row["DIACHINV"],$row["SDT"],$row["CHUCVU"],$row["LUONG"]);
            }
            $conn->close();
            return $dsnv;
        }


        // Tìm kiếm nhân viên theo yêu cầu
        public static function GetElement(string $tim){
            $dsnv = array();
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbnhanvien WHERE MANV LIKE '%$tim%' OR TENNV LIKE '%$tim%' OR DIACHINV LIKE '%$tim%' OR CHUCVU LIKE '%$tim%' ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dsnv[] = new Nhanvien($row["MANV"],$row["TENNV"],$row["DIACHINV"],$row["SDT"],$row["CHUCVU"],$row["LUONG"]);
                }
            }
            else{
                $dsnv = self::GetAll();
            }
            $conn->close();
            return $dsnv;
        }

        public static function GetManv(){
            $dsmanv = array();
            $conn = DBConnection::Connect();
            $sql = "SELECT MANV, TENNV FROM tbnhanvien";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $dsmanv[] = $row; // Lưu cả MANV và TENNV vào mảng
                }
            }
            $conn->close();
            return $dsmanv; // Trả về danh sách nhân viên
        }
        
        

    }

?>