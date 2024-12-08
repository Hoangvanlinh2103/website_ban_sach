<?php
    require_once("connection.php");
    class Donhangxuat{
        public $madh;
        public $ngay;
        public $manv;
        public $tennv;
        public $makh;
        public $tenkh;
        public $diachikh;
        public $sdt;
        public $tongtien;
        public $ttdh;
        public $tttt;
        public $masach;
        public $slxuat;
        public $tensach;
        public $img;
        public $giaban;
        public $ptkm;
        public $thanhtien;
        public function __construct($madh,$ngay,$manv,$tennv,$makh,$tenkh,$dckh,$sdt,$tt,$ttdh,$tttt,$mas,$tens,$img,$sl,$giaban,$ptkm,$thanhtien){
            $this->madh = $madh;
            $this->ngay = $ngay;
            $this->manv = $manv;
            $this->tennv = $tennv;
            $this->makh = $makh;
            $this->tenkh = $tenkh;
            $this->diachikh = $dckh;
            $this->sdt = $sdt;
            $this->tongtien = $tt;
            $this->ttdh = $ttdh;
            $this->tttt = $tttt;
            $this->masach = $mas;
            $this->tensach = $tens;
            $this->img = $img;
            $this->slxuat = $sl;
            $this->giaban = $giaban;
            $this->ptkm = $ptkm;
            $this->thanhtien = $thanhtien;
        }
        public function __destruct(){

        }


        // Lấy danh sách đơn hàng xuất nhân viên đã chấp nhận
        public static function GetAllDonhang(){
                $dsdonh = null;
                $conn = DBConnection::Connect();
                $sql = "SELECT * FROM tbdonhangxuat WHERE TINHTRANGDH = 'Đang xử lý' OR TINHTRANGDH = 'Đã hoàn thành' OR TINHTRANGDH = 'Đã hủy' ORDER BY NGAYXUAT DESC  ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dsdonh[] = new Donhangxuat($row["MADHXUAT"],$row["NGAYXUAT"],$row["MANV"],null,$row["MAKH"],NULL,NULL,NULL,$row["TONGTIEN"],$row["TINHTRANGDH"],$row["TINHTRANGTT"],NULL,NULL,NULL,NULL,NULL,NULL,null);
                }
                $conn->close();
                return $dsdonh;
        }
        // Lấy danh sách đơn hàng xuất nhân viên chưa chấp nhận
        public static function GetAllDathang(){
            $dsdonh = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbdonhangxuat WHERE TINHTRANGDH = 'Chưa xử lý' ORDER BY NGAYXUAT DESC  ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dsdonh[] = new Donhangxuat($row["MADHXUAT"],$row["NGAYXUAT"],$row["MANV"],null,$row["MAKH"],NULL,NULL,NULL,$row["TONGTIEN"],$row["TINHTRANGDH"],$row["TINHTRANGTT"],NULL,NULL,NULL,NULL,NULL,NULL,null);
            }
            $conn->close();
            return $dsdonh;
        }


        // Tìm kiếm thông tin theo yêu cầu của đơn hàng nhân viên đã chấp nhận
        public static function GetElementdonhang(string $tim){
            $dsdh = null;
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbdonhangxuat WHERE TINHTRANGDH = 'Đang xử lý' OR TINHTRANGDH = 'Đã hoàn thành' OR TINHTRANGDH = 'Đã hủy' AND MADHXUAT LIKE '%$tim%' OR NGAYXUAT LIKE '%$tim%' OR MANV LIKE '%$tim%' OR MAKH LIKE '%$tim%' OR TINHTRANGDH LIKE '%$tim%' OR TINHTRANGTT LIKE '%$tim%' ORDER BY NGAYXUAT DESC  ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dsdh[] = new Donhangxuat($row["MADHXUAT"],$row["NGAYXUAT"],$row["MANV"],null,$row["MAKH"],NULL,NULL,NULL,$row["TONGTIEN"],$row["TINHTRANGDH"],$row["TINHTRANGTT"],NULL,NULL,NULL,NULL,NULL,NULL,null);
                }
            }
            else{
                $dsdh = self::GetAllDonhang();
            }
            $conn->close();
            return $dsdh;
        }


        // Tìm kiếm thông tin theo yêu cầu của đơn hàng nhân viên chưa chấp nhận
        public static function GetElementdathang(string $tim){
            $dsdh = null;
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbdonhangxuat WHERE TINHTRANGDH = 'Chưa xử lý' AND MADHXUAT LIKE '%$tim%' OR NGAYXUAT LIKE '%$tim%' OR MANV LIKE '%$tim%' OR MAKH LIKE '%$tim%' OR TINHTRANGDH LIKE '%$tim%' OR TINHTRANGTT LIKE '%$tim%' ORDER BY NGAYXUAT DESC  ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dsdh[] = new Donhangxuat($row["MADHXUAT"],$row["NGAYXUAT"],$row["MANV"],null,$row["MAKH"],NULL,NULL,NULL,$row["TONGTIEN"],$row["TINHTRANGDH"],$row["TINHTRANGTT"],NULL,NULL,NULL,NULL,NULL,NULL,null);
                }
            }
            else{
                $dsdh = self::GetAllDathang();
            }
            $conn->close();
            return $dsdh;
        }


        // Tăng mã đơn hàng tự động
        public static function TangMadonhang() {
            $conn = DBConnection::Connect();
            $sql = "SELECT MADHXUAT FROM tbdonhangxuat ORDER BY LPAD(SUBSTRING(MADHXUAT, 4), 10, '0') DESC LIMIT 1;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = $row["MADHXUAT"];  
                $number = intval(substr($lastId, 3)) + 1;  // substr($lastId, 3) cắt bỏ phần KH giữ lại phần số, intval chuyển đổi phần số thành số nguyên sau đó tăng 1
                $newId = "DHX" . sprintf("%03d", $number);
            }
            return $newId;
        }


        // Thêm đơn hàng xuất
        public static function Adddonhang($madh,$ngay,$manv,$makh,$tongtien,$ttdh){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "INSERT INTO tbdonhangxuat(MADHXUAT,NGAYXUAT,MANV,MAKH,TONGTIEN,TINHTRANGDH) VALUES(?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssds",$madh,$ngay,$manv,$makh,$tongtien,$ttdh);
            if($success = $stmt->execute()){
            }
            $stmt->close();
            $conn->close();
            return $success;
        }

        // Thêm đơn hàng xuất
        public static function Adddonhang_online($madh,$ngay,$manv,$makh,$tongtien,$ttdh,$tttt){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "INSERT INTO tbdonhangxuat(MADHXUAT,NGAYXUAT,MANV,MAKH,TONGTIEN,TINHTRANGDH,TINHTRANGTT) VALUES(?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssdss",$madh,$ngay,$manv,$makh,$tongtien,$ttdh,$tttt);
            if($success = $stmt->execute()){
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Thêm vào đơn hàng xuất chi tiết
        public static function Adddonhang_chitiet($madh, $masach, $slxuat) {
            $success = false;
            $conn = DBConnection::Connect();
            
            // Lấy giá bán của sách
            $sql = "SELECT GIABAN FROM tbsach WHERE MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $masach);
            $stmt->execute();
            $stmt->bind_result($giaban);
            $stmt->fetch();
            $stmt->close();
            
            // Kiểm tra xem mã đơn hàng xuất và mã sách đã có chưa
            $sql = "SELECT NGAYXUAT FROM tbdonhangxuat WHERE MADHXUAT = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $madh);
            $stmt->execute();
            $stmt->bind_result($current_ngay);
            $stmt->fetch();
            $stmt->close();
            
            // Lấy phần trăm khuyến mãi (nếu có) từ bảng khuyến mãi
            $sql = "SELECT MAX(COALESCE(t7.PTKM, 0)) AS PTKM
                    FROM tbkhuyenmai t6
                    JOIN tbkhuyenmai_ct t7 ON t7.MAKM = t6.MAKM AND t7.MASACH = ?
                    WHERE ? BETWEEN t6.NGAYBD AND t6.NGAYKT";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $masach, $current_ngay);
            $stmt->execute();
            $stmt->bind_result($ptkm);
            $stmt->fetch();
            $stmt->close();
            
            // Đảm bảo gán giá trị mặc định cho PTKM nếu không có khuyến mãi
            $ptkm = isset($ptkm) ? $ptkm : 0;
            
            // Tính ThanhTien (Số lượng * Giá bán - Giảm giá)
            $thanhtien = ($slxuat * $giaban) - ($slxuat * $giaban * $ptkm / 100);
            
            // Kiểm tra nếu đơn hàng chi tiết đã tồn tại
            $sql = "SELECT SLXUAT, THANHTIEN FROM tbdonhangxuat_ct WHERE MADHXUAT = ? AND MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $madh, $masach);
            $stmt->execute();
            $stmt->bind_result($current_slxuat, $current_thanhtien);
            $stmt->fetch();
            $stmt->close();
        
            if ($current_slxuat !== null) {
                // Nếu tồn tại, cập nhật số lượng và thành tiền
                $new_slxuat = $current_slxuat + $slxuat;
                $new_thanhtien = $current_thanhtien + $thanhtien;
                
                $sql = "UPDATE tbdonhangxuat_ct SET SLXUAT = ?, THANHTIEN = ? WHERE MADHXUAT = ? AND MASACH = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("idss", $new_slxuat, $new_thanhtien, $madh, $masach);
                $success = $stmt->execute();
            } else {
                // Nếu không tồn tại, thêm mới
                $sql = "INSERT INTO tbdonhangxuat_ct (MADHXUAT, MASACH, SLXUAT, THANHTIEN) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssid", $madh, $masach, $slxuat, $thanhtien);
                $success = $stmt->execute();
            }
            
            $stmt->close();
            $conn->close();
            return $success;
        }
        

        public static function updateTongTien($madh) {
            // Kết nối tới cơ sở dữ liệu
            $conn = DBConnection::Connect();
            
            // Câu lệnh SQL cập nhật TONGTIEN cho đơn hàng
            $sql = "UPDATE tbdonhangxuat t1 SET t1.TONGTIEN = (SELECT SUM(t2.THANHTIEN) FROM tbdonhangxuat_ct t2 
            WHERE t2.MADHXUAT = t1.MADHXUAT) WHERE t1.MADHXUAT = ?";
        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $madh);
            if ($stmt->execute()) {
               
                return true;
            } else {
               
                return false;
            }
        
            // Đóng kết nối và câu lệnh
            $stmt->close();
            $conn->close();
        }
        

        // Cập nhật lại tình trạng đơn hàng thành hoàn thành
        public static function EditDonhang_hoanthanh(string $madh){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbdonhangxuat SET TINHTRANGDH = 'Đã hoàn thành', TINHTRANGTT = 'Đã thanh toán' WHERE MADHXUAT = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$madh);
            if($success = $stmt->execute()){
                echo "<script> alert('Thay đổi thông tin đơn hàng thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Cập nhật lại tình trạng đơn hàng thành hủy
        public static function EditDonhang_huy(string $madh){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbdonhangxuat SET TINHTRANGDH = 'Đã hủy' WHERE MADHXUAT = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$madh);
            if($success = $stmt->execute()){
                echo "<script> alert('Thay đổi thông tin đơn hàng thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Phương thức để giảm số lượng sách trong bảng Sach
        public static function updatesach($masach, $slxuat) {
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbsach SET SLSACH = SLSACH - ? WHERE MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('is', $slxuat,$masach);
            $stmt->execute();
        }


        // Phương thức để nhân viên chấp nhận đơn đặt hàng từ khách 
        public static function EditDathang(string $manv,string $madh){
            $conn = DBConnection::Connect();
            // 1. Lấy mã sách và số lượng xuất từ chi tiết đơn hàng
            $sql = "SELECT MASACH, SLXUAT FROM tbdonhangxuat_ct WHERE MADHXUAT = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $madh);
            $stmt->execute();
            $stmt->bind_result($masach, $slxuat);

            // 2. Giảm số lượng cho mỗi sách trong bảng Sach
            while ($stmt->fetch()) {
                self::updatesach($masach, $slxuat); // Gọi phương thức tĩnh
            }
            $stmt->close();

            // 3. Cập nhật trạng thái đơn đặt hàng thành "Đang xử lý"
            $sql = "UPDATE tbdonhangxuat SET MANV = ?, TINHTRANGDH = 'Đang xử lý' WHERE MADHXUAT = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $manv,$madh);
            $stmt->execute();
            $conn->close();
        }


        // Xóa đơn hàng
       public static function Delete(string $madh){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM tbdonhangxuat WHERE MADHXUAT = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$madh);
            if($success = $stmt->execute()){
                echo "<script> alert('Xóa đơn hàng thành công'); </script> ";
            }
            $stmt->close();
            $conn->close();
            return $success;
       }


       // Lấy tổng tiền của đơn hàng
       public static function gettongtien($madh){
            $conn = DBConnection::Connect();
            $sql = "SELECT TONGTIEN FROM tbdonhangxuat WHERE MADHXUAT = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$madh);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $tongtien = $row['TONGTIEN'];
                } else {
                    $tongtien = 0; // No result found
                }
            }
            $stmt->close();
            $conn->close();
            return $tongtien;
        }


        // Lấy thông tin đơn hàng chi tiết của theo đơn hàng
        public static function GetDHXuat($madh) {
            $dsdonh = []; // Sử dụng mảng để lưu tất cả các đơn hàng
            $conn = DBConnection::Connect();
            $sql = "SELECT t1.MADHXUAT, t1.NGAYXUAT,
            CASE WHEN t1.MANV IS NULL THEN 'Không có' ELSE t1.MANV END AS MANV,
            CASE WHEN t1.MANV IS NULL THEN 'Không có' ELSE COALESCE(t5.TENNV, 'Không có') END AS TENNV,
            CASE WHEN t1.MAKH IS NULL THEN 'Không có' ELSE t1.MAKH END AS MAKH,
            CASE WHEN t1.MAKH IS NULL THEN 'Không có' ELSE COALESCE(t3.TENKH, 'Không có') END AS TENKH,
            CASE WHEN t1.MAKH IS NULL THEN 'Không có' ELSE COALESCE(t3.DIACHIKH, 'Không có') END AS DIACHIKH,
            CASE WHEN t1.MAKH IS NULL THEN 'Không có' ELSE COALESCE(t3.SDT, 'Không có') END AS SDT,
            t1.TONGTIEN, t1.TINHTRANGDH, t1.TINHTRANGTT, t2.MASACH, t4.TENSACH, t4.HINHANH, t2.SLXUAT, t4.GIABAN,
            (t2.SLXUAT * t4.GIABAN) AS GIACHINH,
            t2.THANHTIEN
            FROM 
                tbdonhangxuat t1 
            JOIN 
                tbdonhangxuat_ct t2 ON t1.MADHXUAT = t2.MADHXUAT 
            LEFT JOIN 
                tbkhachhang t3 ON t1.MAKH = t3.MAKH 
            JOIN 
                tbsach t4 ON t2.MASACH = t4.MASACH 
            LEFT JOIN 
                tbnhanvien t5 ON t1.MANV = t5.MANV
            LEFT JOIN 
                tbkhuyenmai_ct t7 ON t7.MASACH = t4.MASACH 
            WHERE 
                t1.MADHXUAT = ?  
            GROUP BY 
                t1.MADHXUAT, t2.MASACH, t1.NGAYXUAT, t1.MANV, 
                t3.TENKH, t3.DIACHIKH, t3.SDT, t4.TENSACH, 
                t4.HINHANH, t2.SLXUAT, t4.GIABAN, t5.TENNV";
        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $madh);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    $tongTienMoi = 0; // Khởi tạo biến tổng tiền mới
                    while ($row = $result->fetch_assoc()) {
                        // Tạo đối tượng Donhangxuat với dữ liệu từ kết quả truy vấn
                        $dsdonh[] = new Donhangxuat( // Thêm vào mảng
                            $row["MADHXUAT"],
                            $row["NGAYXUAT"],
                            $row["MANV"],
                            $row["TENNV"],
                            $row["MAKH"],
                            $row["TENKH"],
                            $row["DIACHIKH"],
                            $row["SDT"],
                            $row["TONGTIEN"],
                            $row["TINHTRANGDH"],
                            $row["TINHTRANGTT"],
                            $row["MASACH"],
                            $row["TENSACH"],
                            $row["HINHANH"],
                            $row["SLXUAT"],
                            $row["GIABAN"],
                            $row["GIACHINH"],
                            $row["THANHTIEN"]
                        );
                    }
                }
            }
            $stmt->close();
            $conn->close();
            return $dsdonh; // Trả về mảng
        }
        

        // Xóa sách trong đơn hàng chi tiết
        public static function DeleteDHXCT(string $madh,string $masach){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM tbdonhangxuat_ct WHERE MADHXUAT = ? AND MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss",$madh,$masach);
            if($success = $stmt->execute()){
                echo "<script> alert('Xóa đơn hàng thành công'); </script> ";
            }
            $stmt->close();
            $conn->close();
            return $success;
       }


       // Lấy tình trạng đơn hàng của theo mã đơn hàng
       public static function GetTinhTrangDH(string $madh){
            $conn = DBConnection::Connect();
            $sql = "SELECT TINHTRANGDH FROM tbdonhangxuat WHERE MADHXUAT = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$madh);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $tinhtrang = $row['TINHTRANGDH'];
                }
            }
            $stmt->close();
            $conn->close();
            return $tinhtrang;
       }

       // Lấy tình trạng đơn hàng của theo mã đơn hàng
       public static function GetTTDH(string $makh){
        $conn = DBConnection::Connect();
        $sql = "SELECT TINHTRANGDH FROM tbdonhangxuat WHERE MAKH = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s",$makh);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tinhtrang = $row['TINHTRANGDH'];
            }
        }
        $stmt->close();
        $conn->close();
        return $tinhtrang;
        }

         // Lấy thông tin đơn hàng chi tiết của theo đơn hàng
         public static function GetKHdonhang($tinhtrang,$makh) {
            $dsdonh = []; // Sử dụng mảng để lưu tất cả các đơn hàng
            $conn = DBConnection::Connect();
            $sql = "SELECT t1.MADHXUAT, t1.NGAYXUAT, t2.MASACH, t3.TENSACH, t3.HINHANH, t2.SLXUAT, t1.TONGTIEN, t1.TINHTRANGDH, t1.TINHTRANGTT 
                    FROM tbdonhangxuat t1 
                    JOIN tbdonhangxuat_ct t2 ON t1.MADHXUAT = t2.MADHXUAT 
                    JOIN tbsach t3 ON t2.MASACH = t3.MASACH 
                    WHERE t1.TINHTRANGDH = ? AND t1.MAKH = ?
                    ORDER BY NGAYXUAT DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss",$tinhtrang,$makh);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dsdonh[] = new Donhangxuat($row["MADHXUAT"], $row["NGAYXUAT"], null, null, null, null, null, null, $row["TONGTIEN"], $row["TINHTRANGDH"], $row["TINHTRANGTT"], $row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["SLXUAT"], null, null, null);
                    }
                }
            }
            $stmt->close();
            $conn->close();
            return $dsdonh; // Trả về mảng
        }
        
    }
?>