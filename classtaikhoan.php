<?php
    require_once("connection.php");
    class Taikhoan{
        public $user;
        public $password;
        public $thanphan;
        public $makh;
        public $manv;
        public function __construct($user,$pass,$tp,$mkh,$mnv){
            $this->user = $user;
            $this->password = $pass;
            $this->thanphan = $tp;
            $this->makh = $mkh;
            $this->manv = $mnv;
        }
        public function __destruct(){

        }

        // Đếm số lượng tài khoản
        public static function soluongtaikhoan(){
            $conn = DBConnection::Connect();
            $sql = "SELECT COUNT(USERNAME) AS tonguser FROM tbtaikhoan";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tonguser = $row['tonguser'];
            } else {
                $tonguser = 0; // Nếu không có kết quả trả về, đặt tổng số sản phẩm là 0
            }
        
            $conn->close();
            return $tonguser;
        }
        
        // Thêm tài khoản vào bảng
        public static function Add($user,$password,$thanphan,$manv){
            $success = false;
            $conn = DBConnection::Connect();
            // Kiểm tra xem tài khoản người dùng đã tồn tại chưa
            $sqlCheckUser = "SELECT * FROM tbtaikhoan WHERE USERNAME = ?";
            $stmtCheckUser = $conn->prepare($sqlCheckUser);
            $stmtCheckUser->bind_param("s", $user);
            $stmtCheckUser->execute();
            $resultCheckUser = $stmtCheckUser->get_result();
        
            if ($resultCheckUser->num_rows > 0) {
                $stmtCheckUser->close();
                $conn->close();
                echo "<script> alert('Tên tài khoản đã tồn tại!'); window.location='them.php?name=taikhoan'; </script>";
                exit();
            }
            else{
                $sql = "INSERT INTO tbtaikhoan(USERNAME,PASSWORD,ROLE,MANV) VALUES(?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss",$user,$password,$thanphan,$manv);
                if($success = $stmt->execute()){
                    echo "<script> alert('Thêm tài khoản thành công!');</script>";
                }
            }
            $stmt->close();
            $conn->close();
            return $success;
        }

        // Cập nhật lại thông tin tài khoản
        public static function Edit(string $user, string $password){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbtaikhoan SET PASSWORD = ? WHERE USERNAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss",$password,$user);
            if($success = $stmt->execute()){
                echo "<script> alert('Thay đổi thông tin tài khoản thành công'); </script> ";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }

        // Xóa tài khoản 
        public static function Delete(string $user){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM tbtaikhoan WHERE USERNAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$user);
            if($success = $stmt->execute()){
                echo "<script> alert('Xóa tài khoản thành công'); </script> ";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }

        // Lấy toàn bộ thông tin 
        public static function GetAll(){
            $dstk = array();
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbtaikhoan";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dstk[] = new Taikhoan($row["USERNAME"],$row["PASSWORD"],$row["ROLE"],$row["MAKH"],$row["MANV"]);
            }
            $conn->close();
            return $dstk;
        }

        // Lấy 1 tài khoản theo mã
        public static function Get(string $tim){
            $dstk = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbtaikhoan WHERE USERNAME = '$tim' ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dstk[] = new Taikhoan($row["USERNAME"],$row["PASSWORD"],$row["ROLE"],$row["MAKH"],$row["MANV"]);
            }
            $conn->close();
            return $dstk;
        }

        // Tìm kiếm tài khoản theo yêu cầu
        public static function GetElement(string $tim) {
            $dstk = [];
            $conn = DBConnection::Connect();
            if ($tim) {
                $sql = "SELECT * FROM tbtaikhoan WHERE USERNAME LIKE '%$tim%' OR ROLE LIKE '%$tim%' OR MANV LIKE '%$tim%' OR MAKH LIKE '%$tim%'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $dstk[] = new Taikhoan($row["USERNAME"],$row["PASSWORD"],$row["ROLE"],$row["MAKH"],$row["MANV"]);
                }
            } else {
                $dstk = self::GetAll();
            }
            $conn->close();
            return $dstk;
        }

          #Chức năng đăng nhập
          public static function dangnhap(string $user, string $pass) {
            $tk = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbtaikhoan WHERE USERNAME = ? AND PASSWORD = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $user, $pass);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tk = new Taikhoan($row["USERNAME"], $row["PASSWORD"], $row["ROLE"], $row["MAKH"], $row["MANV"]);
                }
            }
            $stmt->close();
            $conn->close();
            return $tk;
        }


        // Chức năng lấy mã nhân viên
        public static function GetManv(string $user) {
            $tk = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT MANV FROM tbtaikhoan WHERE USERNAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tk = $row["MANV"];
            }
            $stmt->close();
            $conn->close();
            return $tk;
        }    
        
         // Chức năng lấy mã khách hàng
         public static function GetMakh(string $user) {
            $tk = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT MAKH FROM tbtaikhoan WHERE USERNAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tk = $row["MAKH"];
            }
            $stmt->close();
            $conn->close();
            return $tk;
        }      
        
        
        // Tự động thêm makh
        public static function TangMakh($conn) {
            $sql = "SELECT MAKH FROM tbkhachhang ORDER BY MAKH DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = $row["MAKH"];  // Lấy mã khách hàng từ truy vấn
                $number = intval(substr($lastId, 2)) + 1;  // substr($lastId, 2) cắt bỏ phần KH giữ lại phần số, intval chuyển đổi phần số thành số nguyên sau đó tăng 1
                $newId = "KH" . sprintf("%03d", $number);
            }
    
            return $newId;
        }

        
        // Chức năng đăng ký của khách hàng
        public static function dangky($user, $password, $tenkh, $dckh, $sdt) {
            $conn = DBConnection::Connect();
            $success = false;
            // Kiểm tra xem tài khoản người dùng đã tồn tại chưa
            $sqlCheckUser = "SELECT * FROM tbtaikhoan WHERE USERNAME = ?";
            $stmtCheckUser = $conn->prepare($sqlCheckUser);
            $stmtCheckUser->bind_param("s", $user);
            $stmtCheckUser->execute();
            $resultCheckUser = $stmtCheckUser->get_result();
        
            if ($resultCheckUser->num_rows > 0) {
                $stmtCheckUser->close();
                $conn->close();
                echo "<script> alert('Email đã tồn tại!'); window.location='dangnhap.php'; </script>";
                exit();
            }
        
            // Kiểm tra xem số điện thoại đã tồn tại chưa
            $sqlCheckSdt = "SELECT * FROM tbkhachhang WHERE SDT = ?";
            $stmtCheckSdt = $conn->prepare($sqlCheckSdt);
            $stmtCheckSdt->bind_param("i", $sdt);
            $stmtCheckSdt->execute();
            $resultCheckSdt = $stmtCheckSdt->get_result();
        
            if ($resultCheckSdt->num_rows > 0) {
                $stmtCheckSdt->close();
                $conn->close();
                echo "<script> alert('Số điện thoại đã được đăng ký!'); window.location='dangnhap.php'; </script>";
                exit();
            }
        
            // Nếu cả tài khoản người dùng và số điện thoại đều chưa tồn tại, thực hiện đăng ký
            $makh = self::TangMakh($conn);

            // Insert into tbkhachhang
            $sql2 = "INSERT INTO tbkhachhang (MAKH, TENKH, DIACHIKH, SDT) VALUES (?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("ssss", $makh, $tenkh, $dckh, $sdt);
            if ($stmt2->execute()) {
                $success = true;
            }
            $role = 'Khách hàng';
            $manv = null;
            // Insert into tbtaikhoan
            $sql1 = "INSERT INTO tbtaikhoan (USERNAME, PASSWORD, ROLE, MAKH, MANV) VALUES (?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("sssss", $user, $password, $role, $makh, $manv);
            if (!$stmt1->execute()) {
                echo "Lỗi đăng ký tài khoản: " . $stmt1->error; // Thêm dòng này
                $success = false;
            }
        
            // Đóng kết nối và statement
            $stmt2->close();
            $stmt1->close();
            $conn->close();

            if ($success) {
                echo "<script>alert('Đăng ký thành công!'); window.location='dangnhap.php'; </script>";
                exit();
            } else {
                echo "<script>alert('Đăng ký thất bại!');</script>";
            }
        }

        // Cập nhật lại thông tin tài khoản
        public static function EditPASS(string $password, string $makh) {
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbtaikhoan SET PASSWORD = ? WHERE MAKH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $password, $makh);
                
            if ($stmt->execute()) {
                echo "<script> alert('Thay đổi mật khẩu thành công'); </script>";
                $success = true;
            }
            $stmt->close();
            $conn->close();
            return $success;
        }

        // Cập nhật lại thông tin tài khoản
        public static function Quenmatkhau(string $password, string $user) {
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbtaikhoan SET PASSWORD = ? WHERE USERNAME = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $password, $user);
                
            if ($stmt->execute()) {
                echo "<script> alert('Thay đổi mật khẩu thành công'); </script>";
                $success = true;
            }
            $stmt->close();
            $conn->close();
            return $success;
        }

         // Cập nhật lại thông tin tài khoản
         public static function GetEmail(string $makh) {
            $email = "";  // Khởi tạo biến email
            $conn = DBConnection::Connect();
            $sql = "SELECT USERNAME FROM tbtaikhoan WHERE MAKH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $makh);
                
            if ($stmt->execute()) {
                $stmt->bind_result($email);  // Liên kết biến $email với kết quả truy vấn
                $stmt->fetch();  // Lấy kết quả truy vấn
            }
            $stmt->close();
            $conn->close();
            return $email;
        }


    }
?>