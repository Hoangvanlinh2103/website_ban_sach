<?php
    require_once("connection.php");
    class Thanhtoanxuat{
        public $madhx;
        public $ngaytt;
        public $tongtien;
        public function __construct($madh,$ngay,$tt){
           $this->madhx = $madh;
           $this->ngaytt = $ngay;
           $this->tongtien = $tt;
        }
        public function __destruct(){

        }
        
        // lấy tất cả dữ liệu
       public static function GetAllThanhToanXuat(){
            $dstt = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbthanhtoan_xuathang ORDER BY NGAYTT DESC  ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dstt[] = new Thanhtoanxuat($row["DHX"],$row["NGAYTT"],$row["TONGTIEN"]);
            }
            $conn->close();
            return $dstt;
       }
        
       // tìm kiếm
        public static function GetElementdonhang(string $tim){
            $dstt = null;
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbthanhtoan_xuathang WHERE DHX LIKE '%$tim%' OR NGAYTT LIKE '%$tim%' ORDER BY NGAYTT DESC  ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dstt[] = new Thanhtoanxuat($row["DHX"],$row["NGAYTT"],$row["TONGTIEN"]);
                }
            }
            else{
                $dstt = self::GetAllThanhToanXuat();
            }
            $conn->close();
            return $dstt;
        }

        // thêm
        public static function AddThanhToanXuat(Thanhtoanxuat $ttx) {
            $success = false;
            $conn = DBConnection::Connect();
            
            // Kiểm tra xem mã đơn hàng đã tồn tại chưa
            $checkSql = "SELECT COUNT(*) AS count FROM tbthanhtoan_xuathang WHERE DHX = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("s", $ttx->madhx);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                $sql = "UPDATE tbthanhtoan_xuathang t1 SET t1.TONGTIEN = (SELECT t2.TONGTIEN FROM tbdonhangxuat t2 WHERE t2.MADHXUAT = t1.DHX ) WHERE t1.DHX = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s",  $madh);
                $success = $stmt->execute();
                $stmt->close();
                return false;
            }
            
            // Nếu không tồn tại, thì thực hiện thêm mới
            $sql = "INSERT INTO tbthanhtoan_xuathang(DHX, NGAYTT, TONGTIEN) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssd", $ttx->madhx, $ttx->ngaytt, $ttx->tongtien);
            
            if ($success = $stmt->execute()) {
                // Thêm thành công
            }
            
            $stmt->close();
            $checkStmt->close();
            $conn->close();
            return $success;
        }

        // cập nhật
        public static function update_thanhtoanxuat($madh) {
            $success = false;
            $conn = DBConnection::Connect();
            
            // Kiểm tra xem MADHXUAT có tồn tại trong tbthanhtoan_xuathang không
            $checkSql = "SELECT COUNT(*) FROM tbthanhtoan_xuathang WHERE DHX = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("s", $madh);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();
            
            // Nếu MADHXUAT tồn tại, thực hiện cập nhật TONGTIEN
            if ($count > 0) {
                $sql = "UPDATE tbthanhtoan_xuathang t1 SET t1.TONGTIEN = (SELECT t2.TONGTIEN FROM tbdonhangxuat t2 WHERE t2.MADHXUAT = t1.DHX ) WHERE t1.DHX = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s",  $madh);
                $success = $stmt->execute();
                $stmt->close();
            }
            
            $conn->close();
            return $success;
        }   
        
        public static function GetTongTienTheoThangNam($thang, $nam) {
            $conn = DBConnection::Connect();
            
            // Truy vấn SQL đã sửa để tính tổng doanh thu theo ngày
            $sql = "SELECT NGAYTT, SUM(TONGTIEN) AS tongtienxuat 
                    FROM tbthanhtoan_xuathang 
                    WHERE MONTH(NGAYTT) = ? AND YEAR(NGAYTT) = ? 
                    GROUP BY NGAYTT  ORDER BY NGAYTT ASC";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $thang, $nam);  // Bind tháng và năm
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Khởi tạo mảng dữ liệu
            $data = [];
            
            // Lặp qua kết quả và tạo mảng dữ liệu
            while ($row = $result->fetch_assoc()) {
                $data[] = ['ngay' => $row['NGAYTT'], 'doanhthu' => $row['tongtienxuat']];
            }
            
            $stmt->close();
            $conn->close();
            
            return $data;
        }

        public static function getDoanhThuCaoNhatTheoThangTrongNam($nam) {
            $conn = DBConnection::Connect();
            $sql = "SELECT MONTH(NGAYTT) AS thang, SUM(TONGTIEN) AS tongtienxuat FROM tbthanhtoan_xuathang WHERE YEAR(NGAYTT) = ? GROUP BY MONTH(NGAYTT) ORDER BY thang ASC;";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $nam);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = ['thang' => $row['thang'], 'doanhthu' => $row['tongtienxuat']];
            }
        
            $stmt->close();
            $conn->close();
        
            return $data;
        }
        
        
    }

    class ThanhToanNhap{
        public $madhn;
        public $ngaytt;
        public $tongtien;
        public function __construct($madh,$ngay,$tt){
           $this->madhn = $madh;
           $this->ngaytt = $ngay;
           $this->tongtien = $tt;
        }
        public function __destruct(){

        }
        
        // Lấy tất cả dữ liệu
       public static function GetAllThanhToanNhap(){
            $dstt = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbthanhtoan_nhaphang ORDER BY NGAYTT DESC  ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dstt[] = new ThanhToanNhap($row["DHN"],$row["NGAYTT"],$row["TONGTIEN"]);
            }
            $conn->close();
            return $dstt;
       }
        
       // Tìm kiếm dữ liệu
        public static function GetElementdonhang(string $tim){
            $dstt = null;
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbthanhtoan_nhaphang WHERE DHN LIKE '%$tim%' OR NGAYTT LIKE '%$tim%' ORDER BY NGAYTT DESC  ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dstt[] = new ThanhToanNhap($row["DHN"],$row["NGAYTT"],$row["TONGTIEN"]);
                }
            }
            else{
                $dstt = self::GetAllThanhToanNhap();
            }
            $conn->close();
            return $dstt;
        }

        // thêm dữ liệu vào bảng
        public static function AddThanhToanNhap(ThanhToanNhap $ttn) {
            $success = false;
            $conn = DBConnection::Connect();
            
            // Kiểm tra xem mã đơn hàng đã tồn tại chưa
            $checkSql = "SELECT COUNT(*) AS count FROM tbthanhtoan_nhaphang WHERE DHN = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("s", $ttn->madhn);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row['count'] > 0) {
                $sql = "UPDATE tbthanhtoan_nhaphang t1 SET t1.TONGTIEN = (SELECT t2.TONGTIEN FROM tbdonhangnhap t2 WHERE t2.MADHNHAP = t1.DHN ) WHERE t1.DHN = ? " ;
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s",  $madh);
                $success = $stmt->execute();
                $stmt->close();
                return false;
            }
            
            // Nếu không tồn tại, thì thực hiện thêm mới
            $sql = "INSERT INTO tbthanhtoan_nhaphang(DHN, NGAYTT, TONGTIEN) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssd", $ttn->madhn, $ttn->ngaytt, $ttn->tongtien);
            
            if ($success = $stmt->execute()) {
                // Thêm thành công
            }
            
            $stmt->close();
            $checkStmt->close();
            $conn->close();
            return $success;
        }

        // cập nhật dữ liệu
        public static function update_thanhtoannhap($madh) {
            $success = false;
            $conn = DBConnection::Connect();
            
            // Kiểm tra xem MADHXUAT có tồn tại trong tbthanhtoan_nhaphang không
            $checkSql = "SELECT COUNT(*) FROM tbthanhtoan_nhaphang WHERE DHN = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("s", $madh);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();
            
            // Nếu MADHXUAT tồn tại, thực hiện cập nhật TONGTIEN
            if ($count > 0) {
                $sql = "UPDATE tbthanhtoan_nhaphang t1 SET t1.TONGTIEN = (SELECT t2.TONGTIEN FROM tbdonhangnhap t2 WHERE t2.MADHNHAP = t1.DHN ) WHERE t1.DHN = ? " ;
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s",  $madh);
                $success = $stmt->execute();
                $stmt->close();
            }
            
            $conn->close();
            return $success;
        }

        public static function GetTongTien(){
            $dstt = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT NGAYTT, SUM(TONGTIEN) AS tongtiennhap FROM tbthanhtoan_nhaphang GROUP BY NGAYTT ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dstt[] = new ThanhToanNhap(null,$row["NGAYTT"],$row["tongtiennhap"]);
            }
            $conn->close();
            return $dstt;
       }
        
    }
?>