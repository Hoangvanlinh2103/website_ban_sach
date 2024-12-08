<?php
    require_once("connection.php");
    class sach{
        public $masach;
        public $tensach;
        public $img;
        public $loaisach;
        public $tacgia;
        public $nxb;
        public $soluong;
        public $gianhap;
        public $giaban;
        public $mota;
        public function __construct($msp,$tsp,$img,$lsp,$tg,$nxb,$sl,$gn,$gb,$nd){
            $this->masach = $msp;
            $this->tensach = $tsp;
            $this->img = $img;
            $this->loaisach = $lsp;
            $this->tacgia = $tg;
            $this->nxb = $nxb;
            $this->soluong = $sl;
            $this->gianhap = $gn;
            $this->giaban = $gb;
            $this->mota = $nd;
        }
        public function __destruct(){

        }

        // Lấy 3 hàng dữ liệu trong sách nổi bật
        public static function Getnoibat() {
            $dssp = []; // Khởi tạo mảng rỗng để chứa kết quả
            $conn = DBConnection::Connect();
            
            $sql = "SELECT t1.MASACH,t2.TENSACH,t2.HINHANH,SUM(t1.SLXUAT) AS 'Tổng SL Xuất',t2.GIABAN,SUM(t1.SLXUAT * t2.GIABAN) AS 'Thành Tiền'
                FROM 
                    tbdonhangxuat_ct t1
                JOIN 
                    tbsach t2 ON t1.MASACH = t2.MASACH
                JOIN 
                    tbdonhangxuat t3 ON t3.MADHXUAT = t1.MADHXUAT
                WHERE 
                    MONTH(t3.NGAYXUAT) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
                    AND YEAR(t3.NGAYXUAT) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
                GROUP BY 
                    t1.MASACH, t2.TENSACH, t2.HINHANH, t2.GIABAN
                ORDER BY 
                    SUM(t1.SLXUAT) DESC
                LIMIT 3 ";
            
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dssp[] = new sach(
                    $row["MASACH"], 
                    $row["TENSACH"], 
                    $row["HINHANH"], 
                    null, // Không dùng loaisach
                    null, // Không dùng tác giả
                    null, // Không dùng NXB
                    null, // Không dùng số lượng
                    null, // Không dùng giá nhập
                    $row["GIABAN"], 
                    null  // Không dùng mô tả
                );
            }
        
            $conn->close();
            return $dssp;
        }
        
        public static function Getbanchay(){
            $dssp = []; // Khởi tạo mảng rỗng để chứa kết quả
            $conn = DBConnection::Connect();
            
            $sql = "SELECT t1.MASACH,t2.TENSACH,t2.HINHANH,SUM(t1.SLXUAT) AS 'Tổng SL Xuất',t2.GIABAN,SUM(t1.SLXUAT * t2.GIABAN) AS 'Thành Tiền'
                FROM 
                    tbdonhangxuat_ct t1
                JOIN 
                    tbsach t2 ON t1.MASACH = t2.MASACH
                JOIN 
                    tbdonhangxuat t3 ON t3.MADHXUAT = t1.MADHXUAT
                WHERE 
                    MONTH(t3.NGAYXUAT) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
                    AND YEAR(t3.NGAYXUAT) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
                GROUP BY 
                    t1.MASACH, t2.TENSACH, t2.HINHANH, t2.GIABAN
                HAVING 
                    SUM(t1.SLXUAT) > 10
                ORDER BY 
                    SUM(t1.SLXUAT) DESC ";
            
            $result = $conn->query($sql);
            
            // Lặp qua kết quả và khởi tạo đối tượng sachbanchay
            while($row = $result->fetch_assoc()){
                // Tạo đối tượng sachbanchay với các giá trị phù hợp
                $dssp[] = new sach(
                    $row["MASACH"], 
                    $row["TENSACH"], 
                    $row["HINHANH"], 
                    null, 
                    null, 
                    null, 
                    $row["Tổng SL Xuất"], 
                    $row["Thành Tiền"], 
                    $row["GIABAN"], 
                    null
                );
            }
        
            $conn->close();
            return $dssp;
        }


        // Đếm số lượng sách trong hệ thống
        public static function soluongsach(){
            $conn = DBConnection::Connect();
            $sql = "SELECT COUNT(MASACH) AS tongsp FROM tbsach";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tongsp = $row['tongsp'];
            } else {
                $tongsp = 0; // Nếu không có kết quả trả về, đặt tổng số sản phẩm là 0
            }
        
            $conn->close();
            return $tongsp;
        }


        // Cập nhật tăng số lượng 
        public static function tangsoluongsp(string $masp,int $soluong){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbsach SET SLSACH = SLSACH + ? WHERE MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is",$soluong,$masp);
            $success = $stmt->execute();
            $stmt->close();
            $conn->close();
            return $success;
        }


        // Cập nhật giảm số lượng
        public static function giamsoluongsp(string $masp,int $soluong){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbsach SET SLSACH = SLSACH - ? WHERE MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is",$soluong,$masp);
            $success = $stmt->execute();
            $stmt->close();
            $conn->close();
            return $success;
        }
      
        // Tăng mã sản phẩm tự động
        public static function TangMasp($conn) {
            $sql = "SELECT MASACH FROM tbsach ORDER BY LPAD(SUBSTRING(MASACH, 5), 10, '0') DESC LIMIT 1;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $lastId = $row["MASACH"];  
                $number = intval(substr($lastId, 4)) + 1;  // substr($lastId, 4) cắt bỏ phần SACH giữ lại phần số, intval chuyển đổi phần số thành số nguyên sau đó tăng 1
                $newId = "SACH" . sprintf("%03d", $number);
            }
            return $newId;
        }

        // Thêm dữ liệu vào bảng sách
        public static function Add(sach $sp){
            $success = false;
            $conn = DBConnection::Connect();
            $sp->masach = self::TangMasp($conn);
            $sql = "INSERT INTO tbsach(MASACH,TENSACH,HINHANH,LOAISACH,TACGIA,NXB,SLSACH,GIANHAP,GIABAN,MOTA) VALUES(?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssidds",$sp->masach,$sp->tensach,$sp->img,$sp->loaisach,$sp->tacgia,$sp->nxb,$sp->soluong,$sp->gianhap,$sp->giaban,$sp->mota);
            if($success = $stmt->execute()){
                echo "<script> alert('Thêm sản phẩm thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }

        // Cập nhật lại thông tin sách
        public static function Edit(sach $sp){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "UPDATE tbsach SET TENSACH = ?, HINHANH = ?, LOAISACH = ?, TACGIA = ?, NXB = ?, SLSACH = ?, GIANHAP = ?, GIABAN = ?, MOTA = ? WHERE MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssiddss",$sp->tensach,$sp->img,$sp->loaisach,$sp->tacgia,$sp->nxb,$sp->soluong,$sp->gianhap,$sp->giaban,$sp->mota,$sp->masach);
            if($success = $stmt->execute()){
                echo "<script> alert('Thay đổi thông tin sản phẩm thành công!');</script>";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }

        // Xóa dữ liệu sách
        public static function Delete(string $masp){
            $success = false;
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM tbsach WHERE MASACH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$masp);
            if($success = $stmt->execute()){
                echo "<script> alert('Xóa sản phẩm thành công'); </script> ";
            }
            $stmt->close();
            $conn->close();
            return $success;
        }

        // Lấy toàn bộ dữ liệu trong bảng
        public static function GetAll(){
            $dssp = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dssp[] = new sach($row["MASACH"],$row["TENSACH"],$row["HINHANH"],$row["LOAISACH"],$row["TACGIA"],$row["NXB"],$row["SLSACH"],$row["GIANHAP"],$row["GIABAN"],$row["MOTA"]);
            }
            $conn->close();
            return $dssp;
        }

        // Lấy 1 dữ liệu trong bảng theo mã
        public static function Get(string $tim){
            $dssp = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach WHERE MASACH = '$tim' ";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dssp[] = new sach($row["MASACH"],$row["TENSACH"],$row["HINHANH"],$row["LOAISACH"],$row["TACGIA"],$row["NXB"],$row["SLSACH"],$row["GIANHAP"],$row["GIABAN"],$row["MOTA"]);
            }
            $conn->close();
            return $dssp;
        }

        // Tìm kiếm dữ liệu theo yêu cầu
        public static function GetElement(string $tim){
            $dssp = null;
            $conn = DBConnection::Connect();
            if($tim){
                $sql = "SELECT * FROM tbsach WHERE MASACH LIKE '%$tim%' OR TENSACH LIKE '%$tim%' OR LOAISACH LIKE '%$tim%' ";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $dssp[] = new sach($row["MASACH"],$row["TENSACH"],$row["HINHANH"],$row["LOAISACH"],$row["TACGIA"],$row["NXB"],$row["SLSACH"],$row["GIANHAP"],$row["GIABAN"],$row["MOTA"]);
                }
            }
            else{
                $dssp = self::GetAll();
            }
            $conn->close();
            return $dssp;
        }

        // Thống kê sách sắp hết
        public static function GetSapHet(){
            $dssp = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach WHERE SLSACH < 30";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $dssp[] = new sach($row["MASACH"],$row["TENSACH"],$row["HINHANH"],$row["LOAISACH"],$row["TACGIA"],$row["NXB"],$row["SLSACH"],$row["GIANHAP"],$row["GIABAN"],$row["MOTA"]);
            }
            $conn->close();
            return $dssp;
        }

        // Lấy thể loại sách
        public static function GetTheloai(){
            $conn = DBConnection::Connect();
            $sql = "SELECT DISTINCT(LOAISACH) FROM tbsach";
            $result = $conn->query($sql);
            $loaisachList = []; // Mảng để lưu các thể loại
    
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $loaisachList[] = $row['LOAISACH']; // Thêm từng thể loại vào mảng
                }
            }
            
            $conn->close();
            return $loaisachList; // Trả về mảng các thể loại
        }

        public static function GetSachTheoTacGia($tacgia){
            $dssp = null;
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach where TACGIA = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$tacgia);
            if($stmt->execute()){
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $dssp[] = new sach($row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["LOAISACH"], $row["TACGIA"], $row["NXB"], $row["SLSACH"], $row["GIANHAP"], $row["GIABAN"], $row["MOTA"]);
                    }
                } else {
                    echo "Không có sách nào cho tác giả này.";
                }
            }
            $stmt->close();
            $conn->close();
            return $dssp;
        }


        public static function GetByName(string $tensach) {
            $dssp = [];
            $conn = DBConnection::Connect();
            $conn->set_charset("utf8mb4"); // Đặt bộ ký tự là utf8mb4
        
            $sql = "SELECT * FROM tbsach WHERE TENSACH = ?";
            $stmt = $conn->prepare($sql);
            
            // Ràng buộc tham số một cách an toàn
            $stmt->bind_param("s", $tensach);

            // Thực thi câu lệnh
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $dssp[] = new sach($row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["LOAISACH"], $row["TACGIA"], $row["NXB"], $row["SLSACH"], $row["GIANHAP"], $row["GIABAN"], $row["MOTA"]);
                }
            }
        
            $stmt->close();
            $conn->close();
            return $dssp;
        }


        public static function Getsachfromloaisach(String $loaisach) {
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach WHERE LOAISACH = ?";
            $stmt = $conn->prepare($sql); // Prepare the statement
            $stmt->bind_param("s", $loaisach); // Bind the parameter
            $stmt->execute(); // Execute the statement
            $result = $stmt->get_result(); // Get the result
    
            $books = []; // Initialize the array
            while ($row = $result->fetch_assoc()) {
                $books[] = new sach($row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["LOAISACH"], $row["TACGIA"], $row["NXB"], $row["SLSACH"], $row["GIANHAP"], $row["GIABAN"], $row["MOTA"]);
            }
            $stmt->close();
            $conn->close();
            
            return $books;
        }


        public static function Get_less_price(int $lessnumber) {
            $books = []; // Initialize an array to store books
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach WHERE GIABAN >= ?"; 
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("d", $lessnumber); // Bind the parameter
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $books[] = new sach($row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["LOAISACH"], $row["TACGIA"], $row["NXB"], $row["SLSACH"], $row["GIANHAP"], $row["GIABAN"], $row["MOTA"]);
            }
            
            $stmt->close();
            $conn->close();
            return $books; // Return the array of books
        }
        
        public static function Get_over_price(int $overnumber) {
            $books = []; // Initialize an array to store books
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach WHERE GIABAN <= ?"; 
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("d", $overnumber); // Bind the parameter
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $books[] = new sach($row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["LOAISACH"], $row["TACGIA"], $row["NXB"], $row["SLSACH"], $row["GIANHAP"], $row["GIABAN"], $row["MOTA"]);
            }
            
            $stmt->close();
            $conn->close();
            return $books; // Return the array of books
        }
        
        public static function Get_between_price(int $lessnumber, int $overnumber) {
            $books = []; // Initialize an array to store books
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach WHERE GIABAN BETWEEN ? AND ?"; 
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("dd", $lessnumber, $overnumber); // Bind the parameters
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $books[] = new sach($row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["LOAISACH"], $row["TACGIA"], $row["NXB"], $row["SLSACH"], $row["GIANHAP"], $row["GIABAN"], $row["MOTA"]);
            }
            
            $stmt->close();
            $conn->close();
            return $books; // Return the array of books
        }
        public static function Get_less_price_and_loaisach(int $lessnumber,String $loaisach) {
            $books = []; // Initialize an array to store books
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach WHERE GIABAN >= ? AND LOAISACH = ?"; 
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ds", $lessnumber,$loaisach); // Bind the parameter
$stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $books[] = new sach($row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["LOAISACH"], $row["TACGIA"], $row["NXB"], $row["SLSACH"], $row["GIANHAP"], $row["GIABAN"], $row["MOTA"]);
            }
            
            $stmt->close();
            $conn->close();
            return $books; // Return the array of books
        }
        
        public static function Get_over_price_and_loaisach(int $overnumber,String $loaisach) {
            $books = []; // Initialize an array to store books
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach WHERE GIABAN <= ? AND LOAISACH = ?"; 
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ds", $overnumber,$loaisach); // Bind the parameter
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $books[] = new sach($row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["LOAISACH"], $row["TACGIA"], $row["NXB"], $row["SLSACH"], $row["GIANHAP"], $row["GIABAN"], $row["MOTA"]);
            }
            
            $stmt->close();
            $conn->close();
            return $books; // Return the array of books
        }
        
        public static function Get_between_price_and_loaisach(int $lessnumber, int $overnumber, string $loaisach) {
            $books = []; // Initialize an array to store books
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbsach WHERE GIABAN BETWEEN ? AND ? AND LOAISACH = ?"; 
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("dds", $lessnumber, $overnumber,$loaisach); // Bind the parameters
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $books[] = new sach($row["MASACH"], $row["TENSACH"], $row["HINHANH"], $row["LOAISACH"], $row["TACGIA"], $row["NXB"], $row["SLSACH"], $row["GIANHAP"], $row["GIABAN"], $row["MOTA"]);
            }
            
            $stmt->close();
            $conn->close();
            return $books; // Return the array of books
        }
    }

?>