<?php
    require_once("connection.php");
    class Donhangnhap{
        public $madh;
        public $ngay;
        public $manv;
        public $tennv;
        public $manxb;
        public $tennxb;
        public $diachinxb;
        public $sdt;
        public $tongtien;
        public $tttt;
        public $masach;
        public $slnhap;
        public $tensach;
        public $img;
        public $gianhap;
        public $thanhtien;
        public $ghichu;
        public function __construct($madh,$ngay,$manv,$tennv,$manxb,$tennxb,$dcnxb,$sdt,$tt,$tttt,$mas,$tens,$img,$sl,$gianhap,$thanhtien,$ghichu){
            $this->madh = $madh;
            $this->ngay = $ngay;
            $this->manv = $manv;
            $this->tennv = $tennv;
            $this->manxb = $manxb;
            $this->tennxb = $tennxb;
            $this->diachinxb = $dcnxb;
            $this->sdt = $sdt;
            $this->tongtien = $tt;
            $this->tttt = $tttt;
            $this->masach = $mas;
            $this->tensach = $tens;
            $this->img = $img;
            $this->slnhap = $sl;
            $this->gianhap = $gianhap;
            $this->thanhtien = $thanhtien;
            $this->ghichu = $ghichu;
        }
        public function __destruct(){

        }


        // Lấy danh sách đơn hàng
       public static function GetAllDonhang(){
            $dsdonh = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbdonhangnhap ORDER BY NGAYNHAP DESC  ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dsdonh[] = new Donhangnhap($row["MADHNHAP"],$row["NGAYNHAP"],$row["MANV"],null,$row["MANCC"],NULL,NULL,NULL,$row["TONGTIEN"],$row["TINHTRANGTT"],NULL,NULL,NULL,NULL,NULL,NULL,null);
            }
            $conn->close();
            return $dsdonh;
        }


        // Tìm kiếm đơn hàng theo điều kiện tìm
        public static function GetElementdonhang(string $tim){
            $dsdh = null;
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbdonhangnhap WHERE  MADHNHAP LIKE '%$tim%' OR NGAYNHAP LIKE '%$tim%' OR MANV LIKE '%$tim%' OR MANCC LIKE '%$tim%' OR TINHTRANGTT LIKE '%$tim%' ORDER BY NGAYNHAP DESC  ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dsdh[] = new Donhangnhap($row["MADHNHAP"],$row["NGAYNHAP"],$row["MANV"],null,$row["MANCC"],NULL,NULL,NULL,$row["TONGTIEN"],$row["TINHTRANGTT"],NULL,NULL,NULL,NULL,NULL,NULL,null);
                }
            }
            else{
                $dsdh = self::GetAllDonhang();
            }
            $conn->close();
            return $dsdh;
        }


       // Tăng mã đơn hàng tự động
        public static function TangMadonhang() {
            $conn = DBConnection::Connect();
            $sql = "SELECT MADHNHAP FROM tbdonhangnhap ORDER BY LPAD(SUBSTRING(MADHNHAP, 4), 10, '0') DESC LIMIT 1;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = $row["MADHNHAP"];  
                $number = intval(substr($lastId, 3)) + 1;  // substr($lastId, 3) cắt bỏ phần KH giữ lại phần số, intval chuyển đổi phần số thành số nguyên sau đó tăng 1
                $newId = "DHN" . sprintf("%03d", $number);
            }
            return $newId;
        }


        // Thêm vào bảng đơn hàng nhập
        public static function Adddonhang($madh,$ngay,$manv,$manxb,$tongtien,$tttt){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "INSERT INTO tbdonhangnhap(MADHNHAP,NGAYNHAP,MANV,MANCC,TONGTIEN,TINHTRANGTT) VALUES(?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssds",$madh,$ngay,$manv,$manxb,$tongtien,$tttt);
            if($success = $stmt->execute()){
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Thêm vào bảng đơn hàng nhập chi tiết
        public static function Adddonhang_chitiet($madh, $masach, $slnhap, $gianhap, $thanhtien, $ghichu) {
            $success = false;
            $conn = DBConnection::Connect();
        
            // Kiểm tra xem đơn hàng chi tiết đã có mã đơn hàng và mã sách chưa
            $sql = "SELECT SLNHAP FROM tbdonhangnhap_ct WHERE MADHNHAP = ? AND MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $madh, $masach);
            $stmt->execute();
            $stmt->bind_result($current_slnhap);
            $stmt->fetch();
        
            if ($current_slnhap !== null) { // Kiểm tra nếu SLNHAP đã tồn tại
                // Nếu tồn tại, cập nhật số lượng mới và tính lại THANHTIEN
                $new_slnhap = $current_slnhap + $slnhap;
                $stmt->close();
                $tt = $new_slnhap * $gianhap;
                $sql = "UPDATE tbdonhangnhap_ct SET SLNHAP = ?, THANHTIEN = ? WHERE MADHNHAP = ? AND MASACH = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("idss", $new_slnhap, $tt, $madh, $masach);
                $success = $stmt->execute();
            } else {
                // Nếu không tồn tại, thêm mới
                $stmt->close();
        
                $sql = "INSERT INTO tbdonhangnhap_ct (MADHNHAP, MASACH, SLNHAP, GIANHAP, THANHTIEN, GHICHU) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssidds", $madh, $masach, $slnhap, $gianhap, $thanhtien, $ghichu);
                $success = $stmt->execute();
            }
        
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Cập nhật lại tổng tiền của đơn hàng từ đơn hàng nhập chi tiết theo mã đơn hàng
        public static function EditTongtien($madh){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbdonhangnhap t1 SET t1.TONGTIEN = (SELECT SUM(t2.THANHTIEN) FROM tbdonhangnhap_ct t2 WHERE t2.MADHNHAP = t1.MADHNHAP) WHERE t1.MADHNHAP = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$madh);
            if($success = $stmt->execute()){

            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Cập nhật tình trạng đơn hàng
        public static function EditDonhang(string $madh){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbdonhangnhap SET TINHTRANGTT = 'Đã thanh toán' WHERE MADHNHAP = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$madh);
            if($success = $stmt->execute()){
                echo "<script> alert('Thay đổi thông tin đơn hàng thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Xóa đơn hàng nhập
        public static function Delete(string $madh){
                $success = false;
                $conn = DBConnection::Connect();
                $sql = "DELETE FROM tbdonhangnhap WHERE MADHNHAP = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s",$madh);
                if($success = $stmt->execute()){
                    echo "<script> alert('Xóa đơn hàng thành công'); </script> ";
                }
                $stmt->close();
                $conn->close();
                return $success;
        }


       // Lấy tổng tiền từ đơn hàng nhập theo mã đơn hàng
       public static function gettongtien($madh){
            $conn = DBConnection::Connect();
            $sql = "SELECT TONGTIEN FROM tbdonhangnhap WHERE MADHNHAP = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$madh);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $tongtien = $row['TONGTIEN'] ?? 0;
                } else {
                    
                }
            }
            $stmt->close();
            $conn->close();
            return $tongtien;
        }


        // Lấy thông tin đơn hàng nhập chi tiết theo mã đơn hàng để hiện danh sách sản phẩm của đơn hàng nhập đó
        public static function GetDHNhap($madh){
            $dsdonh = []; // Sử dụng mảng để lưu tất cả các đơn hàng
            $conn = DBConnection::Connect();
            $sql = "SELECT t1.MADHNHAP,t1.NGAYNHAP,t1.MANV,t5.TENNV,
            CASE WHEN t1.MANCC IS NULL THEN 'Không có' ELSE t1.MANCC END AS MANCC,
            CASE WHEN t1.MANCC IS NULL THEN 'Không có' ELSE COALESCE(t3.TENNXB, 'Không có') END AS TENNXB,
            CASE WHEN t1.MANCC IS NULL THEN 'Không có' ELSE COALESCE(t3.DIACHINXB, 'Không có') END AS DIACHINXB,
            CASE WHEN t1.MANCC IS NULL THEN 'Không có' ELSE COALESCE(t3.SDT, 'Không có') END AS SDT,
            t1.TONGTIEN,t1.TINHTRANGTT,t2.MASACH,t4.TENSACH,t4.HINHANH,t2.SLNHAP,t2.GIANHAP,t2.THANHTIEN,t2.GHICHU
            FROM 
                tbdonhangnhap t1 
            JOIN 
                tbdonhangnhap_ct t2 ON t1.MADHNHAP = t2.MADHNHAP 
            LEFT JOIN 
                tbnxb t3 ON t1.MANCC = t3.MANXB 
            JOIN 
                tbsach t4 ON t2.MASACH = t4.MASACH 
            JOIN 
                tbnhanvien t5 ON t1.MANV = t5.MANV
            WHERE 
                t1.MADHNHAP =?  
            GROUP BY 
                t1.MADHNHAP, t2.MASACH, t1.NGAYNHAP, t1.MANV, 
                t3.TENNXB, t3.DIACHINXB, t3.SDT, t4.TENSACH, 
                t4.HINHANH, t2.SLNHAP, t2.GIANHAP, t5.TENNV,t2.THANHTIEN,t2.GHICHU";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$madh);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Tạo đối tượng Donhangxuat với dữ liệu từ kết quả truy vấn
                        $dsdonh[] = new Donhangnhap( // Thêm vào mảng
                            $row["MADHNHAP"],
                            $row["NGAYNHAP"],
                            $row["MANV"],
                            $row["TENNV"],
                            $row["MANCC"],
                            $row["TENNXB"],
                            $row["DIACHINXB"],
                            $row["SDT"],
                            $row["TONGTIEN"],
                            $row["TINHTRANGTT"],
                            $row["MASACH"],
                            $row["TENSACH"],
                            $row["HINHANH"],
                            $row["SLNHAP"],
                            $row["GIANHAP"],
                            $row["THANHTIEN"],
                            $row["GHICHU"]
                        );
                    }
                }
            }
            $stmt->close();
            $conn->close();
            return $dsdonh; // Trả về mảng
        }

        
        // Xóa sản phẩm trong đơn hàng chi tiết theo mã đơn hàng và cập nhật lại số lượng sách trong hệ thống
        public static function DeleteDHXCT(string $madh,string $masach) {
            $success = false;
            $conn = DBConnection::Connect();
            
            // Câu lệnh SQL để lấy số lượng
            $sql = "SELECT SLNHAP FROM tbdonhangnhap_ct WHERE MADHNHAP = ? AND MASACH = ? ";
            
            $stmtsl = $conn->prepare($sql);
            $stmtsl->bind_param("ss", $madh,$masach);
            $stmtsl->execute();
            $result = $stmtsl->get_result();
            
            $slnhap = 0;
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $slnhap = $row['SLNHAP'] ?? 0;
            }
            
            // Cập nhật lại số lượng sách trong bảng sách
            $sqlupdate = "UPDATE tbsach set SLSACH = SLSACH - ? WHERE MASACH = ? ";
            $stmtupdate = $conn->prepare($sqlupdate);
            $stmtupdate->bind_param("is", $slnhap,$masach);
            $stmtupdate->execute();

            $sql = "DELETE FROM tbdonhangnhap_ct WHERE MADHNHAP = ? AND MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss",$madh,$masach);
            if($success = $stmt->execute()){
                echo "<script> alert('Xóa đơn hàng thành công'); </script> ";
            }
            
            $stmtsl->close();
            $stmtupdate->close();
            $stmt->close();
            $conn->close();
            
            return $success;
        }
      
    }
?>