<?php
    require_once("connection.php");
    class Luong{
        public $manv;
        public $thang;
        public $nam;
        public $tonggiolam;
        public $giotangca;
        public $luonglamviec;
        public $luongtangca;
        public $tongluong;
        public $tinhtrang;
        public function __construct($manv,$thang,$nam,$tonggiolam,$giotangca,$luonglamviec,$luongtangca,$tongluong,$tinhtrang){
            $this->manv = $manv;
            $this->thang = $thang;
            $this->nam = $nam;
            $this->tonggiolam = $tonggiolam;
            $this->giotangca = $giotangca;
            $this->luonglamviec = $luonglamviec;
            $this->luongtangca = $luongtangca;
            $this->tongluong = $tongluong;
            $this->tinhtrang = $tinhtrang;
        }
        public function __destruct(){

        }

        public static function Add($manv) {
            $success = false;
            $conn = DBConnection::Connect();
        
            $thangHienTai = date('m'); // Tháng hiện tại
            $namHienTai = date('Y');   // Năm hiện tại
        
            // Tính toán tổng giờ làm và giờ tăng ca từ bảng tbchamcong
            $calcSql = "SELECT SUM(GIOLAMTC) as TONGGIOLAM, SUM(TGTC) as GIOTANGCA FROM tbchamcong WHERE MANV = ? AND MONTH(NGAY) = ? AND YEAR(NGAY) = ?";
            $calcStmt = $conn->prepare($calcSql);
            $calcStmt->bind_param("sii", $manv, $thangHienTai, $namHienTai);
            $calcStmt->execute();
            $calcResult = $calcStmt->get_result()->fetch_assoc();
            $tongGioLam = $calcResult['TONGGIOLAM'] ?? 0;
            $gioTangCa = $calcResult['GIOTANGCA'] ?? 0;
            $calcStmt->close();
        
            // Lấy lương cơ bản của nhân viên từ bảng tbnhanvien
            $salarySql = "SELECT LUONG FROM tbnhanvien WHERE MANV = ?";
            $salaryStmt = $conn->prepare($salarySql);
            $salaryStmt->bind_param("s", $manv);
            $salaryStmt->execute();
            $salaryResult = $salaryStmt->get_result()->fetch_assoc();
            $luongCoBan = $salaryResult['LUONG'] ?? 0;
            $salaryStmt->close();
        
            // Tính lương
            $luongLamViec = $luongCoBan * $tongGioLam;
            $luongTangCa = 1.5 * $luongCoBan * $gioTangCa;
            $tongLuong = $luongLamViec + $luongTangCa;
        
            // Kiểm tra xem đã có dữ liệu cho mã nhân viên trong tháng và năm hiện tại chưa
            $checkSql = "SELECT * FROM tbluong WHERE MANV = ? AND THANG = ? AND NAM = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("sii", $manv, $thangHienTai, $namHienTai);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
        
            if ($result->num_rows > 0) {
                // Nếu đã có dữ liệu, cập nhật lại các giá trị
                $updateSql = "UPDATE tbluong SET TONGGIOLAM = ?, GIOTANGCA = ?, LUONGLAMVIEC = ?, LUONGTANGCA = ?, TONGLUONG = ? WHERE MANV = ? AND THANG = ? AND NAM = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("iidddsii", $tongGioLam, $gioTangCa, $luongLamViec, $luongTangCa, $tongLuong, $manv, $thangHienTai, $namHienTai);
                $success = $updateStmt->execute();
                $updateStmt->close();
            } else {
                // Nếu chưa có dữ liệu, thêm mới vào bảng tbluong
                $insertSql = "INSERT INTO tbluong (MANV, THANG, NAM, TONGGIOLAM, GIOTANGCA, LUONGLAMVIEC, LUONGTANGCA, TONGLUONG) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bind_param("siiiiddd", $manv, $thangHienTai, $namHienTai, $tongGioLam, $gioTangCa, $luongLamViec, $luongTangCa, $tongLuong);
                $success = $insertStmt->execute();
                $insertStmt->close();
            }
        
            $checkStmt->close();
            $conn->close();
            return $success;
        }

         // Cập nhật lại tình trạng bảng lương
         public static function Edit(string $manv,string $thang,string $nam){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbluong SET TINHTRANG = 'Đã trả' WHERE MANV = ? AND THANG = ? AND NAM = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii",$manv,$thang,$nam);
            if($success = $stmt->execute()){
                
            }
            $stmt->close();
            $conn->close();
            return $success;
        }
        
        // Lấy danh sách dữ liệu lương
        public static function GetAll(){
            $dsl = array();
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbluong ORDER BY THANG DESC, NAM DESC";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dsl[] = new Luong($row["MANV"],$row["THANG"],$row["NAM"],$row["TONGGIOLAM"],$row["GIOTANGCA"],$row["LUONGLAMVIEC"],$row["LUONGTANGCA"],$row["TONGLUONG"],$row["TINHTRANG"]);
            }
            $conn->close();
            return $dsl;
        }

        // Tìm kiếm lương theo yêu cầu
        public static function GetElement(string $tim){
            $dsl = array();
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbluong WHERE MANV LIKE '%$tim%' OR THANG LIKE '%$tim%' OR NAM LIKE '%$tim%' OR TINHTRANG LIKE '%$tim%' ORDER BY THANG DESC, NAM DESC ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dsl[] = new Luong($row["MANV"],$row["THANG"],$row["NAM"],$row["TONGGIOLAM"],$row["GIOTANGCA"],$row["LUONGLAMVIEC"],$row["LUONGTANGCA"],$row["TONGLUONG"],$row["TINHTRANG"]);
                }
            }
            else{
                $dsl = self::GetAll();
            }
            $conn->close();
            return $dsl;
        }   

    }

?>