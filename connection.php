<?php
    class DBConnection{
        static function Connect() {
            ini_set("display_errors",1);
            $servername = "localhost:3306";
            $username = "root";
            $password = "";
            $dbname = "dbbansachma";
            // Khởi tạo kết nối
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Kiểm tra kết nối
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }else{
                return $conn;
            }
        }
    }
?>