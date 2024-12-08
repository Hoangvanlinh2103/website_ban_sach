<?php
    require_once("connection.php");
    class Chamcong{
        public $manv;
        public $ngay;
        public $tgbd;
        public $tgkt;
        public $giolamtc;
        public $tgtc;
        public function __construct($mnv,$n,$bd,$kt,$lamtc,$tc){
            $this->manv = $mnv;
            $this->ngay = $n;
            $this->tgbd = $bd;
            $this->tgkt = $kt;
            $this->giolamtc = $lamtc;
            $this->tgtc = $tc;
        }
        public function __destruct(){

        }

        public static function Add(Chamcong $nv) {
            $success = false;
            $conn = DBConnection::Connect();
        
        
            // Kiểm tra xem đã có chấm công cho nhân viên này trong ngày hôm nay chưa
            $checkSql = "SELECT * FROM tbchamcong WHERE MANV = ? AND NGAY = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("ss", $nv->manv, $nv->ngay);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
        
            // Tính toán giờ làm việc
            $tgbd = $nv->tgbd; // Thời gian bắt đầu từ đối tượng Chamcong
            $tgkt = $nv->tgkt; // Thời gian kết thúc từ đối tượng Chamcong
        
            // Định dạng lại thời gian
            $tgbdFormatted = date("H:i:s", strtotime($tgbd));
            $tgktFormatted = date("H:i:s", strtotime($tgkt));
        
            // Tính toán thời gian làm việc
            $diff = strtotime($tgktFormatted) - strtotime($tgbdFormatted);
            if ($diff < 0) { // Nếu giờ kết thúc nhỏ hơn giờ bắt đầu, tính toán cho ngày tiếp theo
                $diff += 86400; // Thêm 24 giờ
            }
            $giolamtc = $diff / 3600; // Giờ làm việc tính bằng giờ
        
            // Tính toán thời gian làm việc tiêu chuẩn
            $gioLamTC = 8; // Giờ làm việc tiêu chuẩn
        
            // Giới hạn GIOLAMTC tối đa là 8 giờ
            $giolamtc = min($giolamtc, $gioLamTC);
        
            // Tính thời gian tăng ca
            $timeOvertime = 0;
            if ($diff / 3600 > $gioLamTC) {
                $timeOvertime = ($diff / 3600) - $gioLamTC; // Tính thời gian tăng ca
            }
        
            // Gán TGTC là thời gian tăng ca
            $tgtc = $timeOvertime;
        
            if ($result->num_rows > 0) {
                // Nếu đã có chấm công, cập nhật TGKT, GIOLAMTC, TGTC và thời gian tăng ca
                $updateSql = "UPDATE tbchamcong SET TGKT = ?, GIOLAMTC = ?, TGTC = ?  WHERE MANV = ? AND NGAY = ?";
                $updateStmt = $conn->prepare($updateSql);
        
                $updateStmt->bind_param("sddss", $tgktFormatted, $giolamtc, $tgtc, $nv->manv, $nv->ngay);
                $success = $updateStmt->execute();
        
                if (!$success) {
                    echo "Error updating record: " . $conn->error; // Thông báo lỗi
                }
        
                $updateStmt->close();
            } else {
                // Nếu chưa có chấm công, thêm mới
                $sql = "INSERT INTO tbchamcong (MANV, NGAY, TGBD, TGKT, GIOLAMTC, TGTC) VALUES (?, ?, ?, ?, ?, ? )";
                $stmt = $conn->prepare($sql);
        
                $stmt->bind_param("ssdddd", $nv->manv, $nv->ngay, $tgbdFormatted, $tgktFormatted, $giolamtc, $tgtc);
                $success = $stmt->execute();
        
                if (!$success) {
                    echo "Error inserting record: " . $conn->error; // Thông báo lỗi
                }
        
                $stmt->close();
            }
        
            $checkStmt->close();
            $conn->close();
            return $success;
        }
        
        // Lấy danh sách dữ liệu chấm công
        public static function GetAll(){
            $dscc = array();
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbchamcong ORDER BY NGAY DESC";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dscc[] = new Chamcong($row["MANV"],$row["NGAY"],$row["TGBD"],$row["TGKT"],$row["GIOLAMTC"],$row["TGTC"]);
            }
            $conn->close();
            return $dscc;
        }

        // Tìm kiếm chấm công theo yêu cầu
        public static function GetElement(string $tim){
            $dscc = array();
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbchamcong WHERE MANV LIKE '%$tim%' OR NGAY LIKE '%$tim%' ORDER BY NGAY DESC ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dscc[] = new Chamcong($row["MANV"],$row["NGAY"],$row["TGBD"],$row["TGKT"],$row["GIOLAMTC"],$row["TGTC"]);
                }
            }
            else{
                $dscc = self::GetAll();
            }
            $conn->close();
            return $dscc;
        }   

    }

?>