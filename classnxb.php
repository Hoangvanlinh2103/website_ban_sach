<?php
    require_once("connection.php");
    class NXB{
        public $manxb;
        public $tennxb;
        public $diachinxb;
        public $sdt;
        public $email;
        public function __construct($manxb,$tennxb,$dcnxb,$sdt,$email){
            $this->manxb = $manxb;
            $this->tennxb = $tennxb;
            $this->diachinxb = $dcnxb;
            $this->sdt = $sdt;
            $this->email = $email;
        }
        public function __destruct(){

        }


        // Đêm số lượng nxb đã lưu trong hệ thống
        public static function soluongnxb(){
            $conn = DBConnection::Connect();
            $sql = "SELECT COUNT(MANXB) AS tongnxb FROM tbnxb";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tongnxb = $row['tongnxb'];
            } else {
                $tongnxb = 0; 
            }
        
            $conn->close();
            return $tongnxb;
        }
       

        // Tăng mã nxb tự động
        public static function Tangnxb($conn) {
            $sql = "SELECT MANXB FROM tbnxb ORDER BY LPAD(SUBSTRING(MANXB, 4), 10, '0') DESC LIMIT 1;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = $row["MANXB"];  
                $number = intval(substr($lastId, 3)) + 1;  // substr($lastId, 2) cắt bỏ phần KH giữ lại phần số, intval chuyển đổi phần số thành số nguyên sau đó tăng 1
                $newId = "NXB" . sprintf("%03d", $number);
            }
            return $newId;
        }


        // Thêm dữ liệu nxb
        public static function Add(NXB $nxb){
            $success = false;
            $conn = DBConnection::Connect();
            $nxb->manxb = self::Tangnxb($conn);
            $sql = "INSERT INTO tbnxb(MANXB,TENNXB,DIACHINXB,SDT,EMAILNXB) VALUES(?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssis",$nxb->manxb,$nxb->tennxb,$nxb->diachinxb,$nxb->sdt,$nxb->email);
            if($success = $stmt->execute()){
                echo "<script> alert('Thêm nhà xuất bản thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Cập nhật lại dữ liệu nxb theo mã
        public static function Edit(NXB $nxb){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbnxb SET TENNXB = ?, DIACHINXB = ?, SDT = ?, EMAILNXB = ? WHERE MANXB = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiss",$nxb->tennxb,$nxb->diachinxb,$nxb->sdt,$nxb->email,$nxb->manxb);
            if($success = $stmt->execute()){
                echo "<script> alert('Thay đổi thông tin nhà xuất bản thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Xóa dữ liệu nxb
        public static function Delete(string $manxb){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM tbnxb WHERE MANXB = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$manxb);
            if($success = $stmt->execute()){
                echo "<script> alert('Xóa nhà xuất bản thành công'); </script> ";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Lấy danh sách dữ liệu khách hàng
        public static function GetAll(){
            $dsnxb = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbnxb";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dsnxb[] = new NXB($row["MANXB"],$row["TENNXB"],$row["DIACHINXB"],$row["SDT"],$row["EMAILNXB"]);
            }
            $conn->close();
            return $dsnxb;
        }


        // Lấy dữ liệu khách hàng theo mã
        public static function Get(string $tim){
            $dsnxb = array();
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbnxb WHERE MANXB = '$tim' ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dsnxb[] = new NXB($row["MANXB"],$row["TENNXB"],$row["DIACHINXB"],$row["SDT"],$row["EMAILNXB"]);
            }
            $conn->close();
            return $dsnxb;
        }


        // Tìm kiếm dữ liệu theo yêu cầu
        public static function GetElement(string $tim){
            $dsnxb = array();
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbnxb WHERE MANXB LIKE '%$tim%' OR TENNXB LIKE '%$tim%' OR DIACHINXB LIKE '%$tim%' ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dsnxb[] = new NXB($row["MANXB"],$row["TENNXB"],$row["DIACHINXB"],$row["SDT"],$row["EMAILNXB"]);
                }
            }
            else{
                $dsnxb = self::GetAll();
            }
            $conn->close();
            return $dsnxb;
        }
    }

?>