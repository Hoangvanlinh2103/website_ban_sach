<?php
    require_once("connection.php");
    class Giohang{
        public $id;
        public $makh;
        public $masach;
        public $soluong;
        public $tinhtrang;
        public function __construct($id,$makh,$masach,$soluong,$tinhtrang){
            $this->id = $id;
            $this->makh = $makh;
            $this->masach = $masach;
            $this->soluong = $soluong;
            $this->tinhtrang = $tinhtrang;
        }
        public function __destruct(){

        }


        public static function Countuserproduct(string $user) {
            $conn = DBConnection::Connect();
            $sql = "SELECT COUNT(MASACH) AS SL FROM `tbgiohang` WHERE MAKH = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cart = $row["SL"];
                }
            }
            $stmt->close();
            $conn->close();
            return $cart;
        }

        public static function Getusercart(string $user) {
            $conn = DBConnection::Connect();
            $sql = "SELECT * FROM tbgiohang WHERE makh = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cart[] = new Giohang($row["ID"], $row["MAKH"], $row["MASACH"], $row["SOLUONG"], $row["TINHTRANG"]);
                }
            }
            $stmt->close();
            $conn->close();
            return $cart;
        }

        public static function Addtocart(string $id, string $makh, string $masach, int $soluong, int $tinhtrang) {
            $conn = DBConnection::Connect();
        
            // Check if there are items in the cart for the given customer
            $sql = "SELECT * FROM `tbgiohang` WHERE MAKH = ? AND MASACH = ?"; // Ensure you check for specific book
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $makh, $masach); // Bind both MAKH and MASACH
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // If the cart item exists, update the quantity
                $row = $result->fetch_assoc();
                $current_sl = (int)$row['SOLUONG']; // Get the current quantity
                $new_sl = $current_sl + $soluong; // Calculate the new quantity
        
                $stmt->close();
                $sql = "UPDATE `tbgiohang` SET SOLUONG = ? WHERE MAKH = ? AND MASACH = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $new_sl, $makh, $masach); // Update based on both MAKH and MASACH
                $success = $stmt->execute();
            } else {
                // If the item does not exist, insert a new cart item
                $stmt->close();
                $sql = "INSERT INTO `tbgiohang` (`ID`, `MAKH`, `MASACH`, `SOLUONG`, `TINHTRANG`) VALUES (?, ?, ?, ?, ?);";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssii", $id, $makh, $masach, $soluong, $tinhtrang); // Ensure the types are correct
                $success = $stmt->execute();
            }
        
            $stmt->close();
            $conn->close();
            return $success;
        }
        
        public static function removeproductfromcart(string $masach, string $user) {
            $conn = DBConnection::Connect();
            $sql = "DELETE FROM `tbgiohang` WHERE masach = ? AND makh = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss",$masach, $user);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $conn->close();
        }
        

        public static function Getlistusercart(string $user) {
            $conn = DBConnection::Connect();
            $sql = "SELECT s.MASACH, s.TENSACH, s.HINHANH, s.GIABAN, gh.SOLUONG
                    FROM tbgiohang gh
                    JOIN tbsach s ON gh.MASACH = s.MASACH
                    WHERE gh.MAKH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $cart = []; // Initialize the cart array
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cart[] = [
                        "masach" => $row["MASACH"],
                        "tensach" => $row["TENSACH"],
                        "hinhanh" => $row["HINHANH"],
                        "giaban" => $row["GIABAN"],
                        "soluong" => $row["SOLUONG"]
                    ];
                }
            }
            $stmt->close();
            $conn->close();
            return $cart;
        }

        public static function UpdateQuantity($makh, $masach, $soluong) {
            $db = DBConnection::Connect();
            $stmt = $db->prepare("UPDATE tbgiohang SET SOLUONG = ? WHERE MAKH = ? AND MASACH = ?");
            return $stmt->execute([$soluong, $makh, $masach]);
        }
        
    }
?>