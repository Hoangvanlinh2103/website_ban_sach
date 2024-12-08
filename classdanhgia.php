<?php
    require_once("connection.php");
    class Danhgia{
        public $id;
        public $masach;
        public $makh;
        public $diemdanhgia;
        public $noidung;
        public $ngay;
        public function __construct($id,$masach,$makh,$diemdanhgia,$noidung,$ngay){
            $this->id = $id;
            $this->masach = $masach;
            $this->makh = $makh;
            $this->diemdanhgia = $diemdanhgia;
            $this->noidung = $noidung;
            $this->ngay = $ngay;
        }
        public function __destruct(){

        }
        public static function Getdanhgiasach(string $masach){
            $dsdg = NULL;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbdanhgia WHERE MASACH = ? ORDER BY NGAY DESC"; // Order by date (newest first)
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $masach);
            $stmt->execute();
            // Execute the query
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $dsdg[] = new Danhgia($row["ID"],$row["MASACH"],$row["MAKH"],$row["DIEMDANHGIA"],$row["NOIDUNG"],$row["NGAY"]);
            }
            $conn->close();
            return $dsdg;
        }
        
        public static function AddReview($masach, $makh, $diemdanhgia, $noidung, $ngay) {
            $conn = DBConnection::Connect();
            $sql = "INSERT INTO tbdanhgia (MASACH, MAKH, DIEMDANHGIA, NOIDUNG, NGAY) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiss", $masach, $makh, $diemdanhgia, $noidung, $ngay);
            $result = $stmt->execute();
            $conn->close();
            return $result;
        }
        
        public static function starrate($masach) {
            $conn = DBConnection::Connect();
            $sql = "SELECT SUM(DIEMDANHGIA) / COUNT(MASACH) AS RATE FROM tbdanhgia WHERE MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $masach);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $rate = null; // Variable to store the calculated rate
            if ($row = $result->fetch_assoc()) {
                $rate = $row['RATE']; // Get the calculated average rate
            }
        
            $stmt->close();
            $conn->close();
            
            return $rate; // Return the average rating
        }
        // Phương thức để tính số sao và hiển thị HTML cho đánh giá sao
        public static function renderStarRating($rating) {
            if ($rating !== null) {
                // Số sao đầy
                $fullStars = floor($rating); 
                // Số sao nửa
                $halfStars = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                // Số sao rỗng
                $emptyStars = 5 - $fullStars - $halfStars;
                
                // Khởi tạo chuỗi HTML cho đánh giá sao
                $output = '';
                
                // Hiển thị sao đầy
                for ($i = 0; $i < $fullStars; $i++) {
                    $output .= '<span class="star filled">&#9733;</span>';
                }
                // Hiển thị sao nửa
                if ($halfStars) {
                    $output .= '<span class="star half">&#9733;</span>';
                }
                // Hiển thị sao rỗng
                for ($i = 0; $i < $emptyStars; $i++) {
                    $output .= '<span class="star empty">&#9734;</span>';
                }
                
                return $output;
            } else {
                // Trả về 5 sao rỗng nếu chưa có đánh giá
                return str_repeat('<span class="star empty">&#9734;</span>', 5);
            }
        }
    }
?>
