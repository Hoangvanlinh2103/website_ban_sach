<?php
session_start(); // Khởi động phiên

$_SESSION["ma"] = null; // Đặt phiên 'ma' thành null
$_SESSION["manv"] = null; // Đặt phiên 'manv' thành null

session_destroy(); 
$action = $_GET['action'] ?? "";
if($action == 1){
    // Chuyển hướng về trang đăng nhập
    header("Location: giaodienkh.php");
    exit(); // Đảm bảo không có mã nào khác được thực thi sau khi điều hướng
}
elseif($action == 2){
    // Chuyển hướng về trang đăng nhập
    header("Location: dangnhap.php");
    exit(); // Đảm bảo không có mã nào khác được thực thi sau khi điều hướng
}


?>
