<?php
    require_once("connection.php");
    class Khuyenmai{
        public $makm;
        public $tensk;
        public $tgbd;
        public $tgkt;
        public $masach;
        public $ptkm;
        public $tensach;
        public $img;
        public $theloai;
        public $giaban;
        public function __construct($makm,$tensk,$tgbd,$tgkt,$masach,$ptkm,$ten,$img,$theloai,$giaban){
            $this->makm = $makm;
            $this->tensk = $tensk;
            $this->tgbd = $tgbd;
            $this->tgkt = $tgkt;
            $this->masach = $masach;
            $this->ptkm = $ptkm;
            $this->tensach = $ten;
            $this->img = $img;
            $this->theloai = $theloai;
            $this->giaban = $giaban;
        }
        public function __destruct(){

        }

            #Tăng mã khuyến mãi tự động
        public static function tangMaKhuyenMai()
        {
            $conn = DBConnection::Connect();
            $sql = "SELECT MAKM FROM tbkhuyenmai ORDER BY LPAD(SUBSTRING(MAKM, 3), 10, '0') DESC LIMIT 1;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = $row["MAKM"];
                $number = intval(substr($lastId, 2)) + 1;  // substr($lastId, 3) cắt bỏ phần KH giữ lại phần số, intval chuyển đổi phần số thành số nguyên sau đó tăng 1
                $newId = "KM" . sprintf("%03d", $number);
            }

            return $newId;
        }

         # Thêm khuyến mãi
    public static function addKhuyenMai($makm, $tensk, $ngaybatdau, $ngayketthuc, $dssach, $ptkm): bool
    {
        $success = false;
        $conn = DBConnection::Connect();
        $conn->begin_transaction();
        try {
            // Thêm khuyến mãi vào bảng tbkhuyenmai
            $sql = "INSERT INTO tbkhuyenmai(MAKM, TENSK, NGAYBD, NGAYKT) VALUES(?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $makm, $tensk, $ngaybatdau, $ngayketthuc);

            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi thêm khuyến mãi.");
            }

            // Thêm chi tiết khuyến mãi tùy chọn cho từng sách
            foreach ($dssach as $index => $masach) {
                $phanTram = $ptkm[$index];  // Lấy phần trăm tương ứng từ danh sách
                if (!self::addKhuyenMaiChiTiet($conn, $makm, $masach, $phanTram)) {
                    throw new Exception("Lỗi khi thêm chi tiết khuyến mãi.");
                }
            }

            // Commit transaction
            $conn->commit();
            $success = true;
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $conn->rollback();
            error_log($e->getMessage());
        }

        $stmt->close();
        $conn->close();

        return $success;
    }

    // Hàm thêm chi tiết khuyến mãi vào bảng tbkhuyenmai_ct
    private static function addKhuyenMaiChiTiet($conn, $makm, $masach, $ptkm): bool
    {
        $sql = "INSERT INTO tbkhuyenmai_ct(MAKM, MASACH, PTKM) VALUES(?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssd", $makm, $masach, $ptkm);

        if (!$stmt->execute()) {
            error_log("Lỗi khi thêm chi tiết khuyến mãi: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        return true;
    }


    # Lấy danh sách khuyến mãi
    public static function getAllKhuyenMai()
    {
        $dskm = null;
        $conn = DBConnection::Connect();
        $sql = "SELECT * FROM tbkhuyenmai order by NGAYBD desc";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $dskm[] = new Khuyenmai($row["MAKM"], $row["TENSK"], $row["NGAYBD"], $row["NGAYKT"], NULL, NULL, NULL,NULL,NULL,NULL);
        }
        $conn->close();
        return $dskm;
    }

    public static function getKhuyenMaiDetail($makm)
    {
        $conn = DBConnection::Connect();

        // Lấy chi tiết khuyến mãi
        $sql_km = "SELECT * FROM tbkhuyenmai WHERE MAKM = ?";
        $stmt_km = $conn->prepare($sql_km);
        $stmt_km->bind_param("s", $makm);
        $stmt_km->execute();
        $result_km = $stmt_km->get_result();
        $khuyenmai = $result_km->fetch_assoc();

        // Lấy danh sách sách áp dụng khuyến mãi
        $sql_sach = "
            SELECT tbsach.MASACH, tbsach.TENSACH, tbkhuyenmai_ct.PTKM 
            FROM tbkhuyenmai_ct 
            JOIN tbsach ON tbkhuyenmai_ct.MASACH = tbsach.MASACH 
            WHERE tbkhuyenmai_ct.MAKM = ?
        ";
        $stmt_sach = $conn->prepare($sql_sach);
        $stmt_sach->bind_param("s", $makm);
        $stmt_sach->execute();
        $result_sach = $stmt_sach->get_result();

        $sachkhuyenmai = [];
        while ($row_sach = $result_sach->fetch_assoc()) {
            $sachkhuyenmai[] = $row_sach;
        }

        $stmt_km->close();
        $stmt_sach->close();
        $conn->close();

        // Trả về chi tiết khuyến mãi và danh sách sách
        return [
            'khuyenmai' => $khuyenmai,
            'sachkhuyenmai' => $sachkhuyenmai
        ];
    }

        public static function GetPTKM(){
            $dskh = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT t7.MASACH, MAX(COALESCE(t7.PTKM, 0)) AS PTKM
                    FROM tbkhuyenmai t6
                    JOIN tbkhuyenmai_ct t7 ON t7.MAKM = t6.MAKM
                    WHERE NOW() BETWEEN t6.NGAYBD AND t6.NGAYKT
                    GROUP BY t7.MASACH";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dskh[] = new Khuyenmai(null,null,null,null,$row["MASACH"],$row["PTKM"],null,null,null,null);
            }
            $conn->close();
            return $dskh;
        }

        public static function GetPTKMtheoMSACH($masach) {
            $conn = DBConnection::Connect();
            
            // Lấy thông tin khuyến mãi cho sách trong phạm vi thời gian hiện tại
            $sql = "SELECT MAX(COALESCE(t7.PTKM, 0)) AS PTKM
                    FROM tbkhuyenmai t6
                    JOIN tbkhuyenmai_ct t7 ON t7.MAKM = t6.MAKM
                    WHERE t7.MASACH = ? AND NOW() BETWEEN t6.NGAYBD AND t6.NGAYKT";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $masach);
            
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row['PTKM']; // Trả về giá trị khuyến mãi (phần trăm)
                } else {
                    return 0; // Nếu không có khuyến mãi, trả về 0
                }
            } else {
                return 0; // Nếu có lỗi trong việc thực hiện truy vấn
            }
        }

        public static function GetSachKM(){
            $dskh = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT t7.MASACH, t2.TENSACH, t2.HINHANH, t2.LOAISACH, t2.GIABAN, MAX(t7.PTKM) AS PTKM
                    FROM tbkhuyenmai t6
                    JOIN tbkhuyenmai_ct t7 ON t7.MAKM = t6.MAKM
                    JOIN tbsach t2 ON t2.MASACH = t7.MASACH
                    WHERE NOW() BETWEEN t6.NGAYBD AND t6.NGAYKT
                    GROUP BY t7.MASACH, t2.TENSACH, t2.HINHANH, t2.LOAISACH, t2.GIABAN;";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dskh[] = new Khuyenmai(null,null,null,null,$row["MASACH"],$row["PTKM"],$row["TENSACH"],$row["HINHANH"],$row["LOAISACH"],$row["GIABAN"]);
            }
            $conn->close();
            return $dskh;
        }

        public static function GetTinKhuyenMai(){
            $dskh = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT t6.TENSK,t6.NGAYBD,t6.NGAYKT
                FROM tbkhuyenmai t6
                WHERE NOW() BETWEEN t6.NGAYBD AND t6.NGAYKT";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dskh[] = new Khuyenmai(
                    null,$row["TENSK"],$row["NGAYBD"],$row["NGAYKT"],null, null, null, null, null, null
                );
            }
            $conn->close();
            return $dskh;
        }
        
    }

?>