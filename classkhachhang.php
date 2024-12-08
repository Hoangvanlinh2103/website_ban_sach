<?php
    require_once("connection.php");
    class Khachhang{
        public $makh;
        public $tenkh;
        public $diachikh;
        public $sdt;
        public function __construct($makh,$tenkh,$dckh,$sdt){
            $this->makh = $makh;
            $this->tenkh = $tenkh;
            $this->diachikh = $dckh;
            $this->sdt = $sdt;
        }
        public function __destruct(){

        }


        // Đêm số lượng khách hàng đã lưu trong hệ thống
        public static function soluongkhachhang(){
            $conn = DBConnection::Connect();
            $sql = "SELECT COUNT(MAKH) AS tongkh FROM tbkhachhang";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tongkh = $row['tongkh'];
            } else {
                $tongkh = 0; // Nếu không có kết quả trả về, đặt tổng số khách hàng là 0
            }
        
            $conn->close();
            return $tongkh;
        }
       

        // Tăng mã khách hàng tự động
        public static function TangMakh($conn) {
            $sql = "SELECT MAKH FROM tbkhachhang ORDER BY LPAD(SUBSTRING(MAKH, 3), 10, '0') DESC LIMIT 1;";
            $result = $conn->query($sql);
            $newId = "KH1";
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = $row["MAKH"];  
                $number = intval(substr($lastId, 2)) + 1;  // substr($lastId, 2) cắt bỏ phần KH giữ lại phần số, intval chuyển đổi phần số thành số nguyên sau đó tăng 1
                $newId = "KH" . sprintf("%03d", $number);
            }
            return $newId;
        }


        // Thêm dữ liệu khách hàng
        public static function Add(Khachhang $kh){
            $success = false;
            $conn = DBConnection::Connect();
            $kh->makh = self::TangMakh($conn);
            $sql = "INSERT INTO tbkhachhang(MAKH,TENKH,DIACHIKH,SDT) VALUES(?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss",$kh->makh,$kh->tenkh,$kh->diachikh,$kh->sdt);
            if($success = $stmt->execute()){
                echo "<script> alert('Thêm khách hàng thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Cập nhật lại dữ liệu khách hàng theo mã
        public static function Edit(Khachhang $kh){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbkhachhang SET TENKH = ?, DIACHIKH = ?, SDT = ? WHERE MAkH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssis",$kh->tenkh,$kh->diachikh,$kh->sdt,$kh->makh);
            if($success = $stmt->execute()){
                echo "<script> alert('Thay đổi thông tin khách hàng thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Xóa dữ liệu khách hàng
        public static function Delete(string $makh){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM tbkhachhang WHERE MAKH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$makh);
            if($success = $stmt->execute()){
                echo "<script> alert('Xóa khách hàng thành công'); </script> ";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Lấy danh sách dữ liệu khách hàng
        public static function GetAll(){
            $dskh = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbkhachhang";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dskh[] = new Khachhang($row["MAKH"],$row["TENKH"],$row["DIACHIKH"],$row["SDT"]);
            }
            $conn->close();
            return $dskh;
        }


        // Lấy dữ liệu khách hàng theo mã
        public static function Get(string $tim){
            $dskh = array();
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbkhachhang WHERE MAKH = '$tim' ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dskh[] = new Khachhang($row["MAKH"],$row["TENKH"],$row["DIACHIKH"],$row["SDT"]);
            }
            $conn->close();
            return $dskh;
        }


        // Tìm kiếm dữ liệu theo yêu cầu
        public static function GetElement(string $tim){
            $dskh = array();
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbkhachhang WHERE MAKH LIKE '%$tim%' OR TENKH LIKE '%$tim%' OR DIACHIKH LIKE '%$tim%' ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dskh[] = new Khachhang($row["MAKH"],$row["TENKH"],$row["DIACHIKH"],$row["SDT"]);
                }
            }
            else{
                $dskh = self::GetAll();
            }
            $conn->close();
            return $dskh;
        }
    }

?>