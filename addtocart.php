<?php
session_start();
require_once("connection.php");
require_once("classsach.php");
require_once("classgiohang.php");
    if ($_SESSION["makh"]) {

    $masach = $_GET["masach"];
    $tensach = $_GET["tensach"];
    $makh = $_SESSION["makh"];
    $soluong = (int)$_GET["soluong"];
    $tinhtrang = 0; // Đặt tình trạng mặc định là 0

    // Tạo ID tự động cho giỏ hàng
    // Gọi phương thức Addtocart
    $result = giohang::Addtocart("", $makh, $masach, $soluong, $tinhtrang);
    $sach = sach::GetByName($tensach);

    if ($result) {
        header("Location: book.php?tensach=".$tensach);
    } else {
    }
    }
?>
