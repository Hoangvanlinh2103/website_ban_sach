<?php
session_start();
require_once("classsach.php");
require_once("classdanhgia.php");

// Lấy ngày hiện tại
$time = date("Y-m-d");

// Lấy các tham số từ URL, nếu có
$tensach = isset($_GET['tensach']) ? $_GET['tensach'] : '';
$diemdanhgia = isset($_GET['diemdanhgia']) ? intval($_GET['diemdanhgia']) : '';
$noidung = isset($_GET['noidung']) ? ($_GET['noidung']) : '';
$masachList = sach::GetByName($tensach); // Lấy mã sách dựa trên tên sách
$masach = $masachList[0];
// Thêm đánh giá
$review = Danhgia::AddReview($masach->masach, $_SESSION["makh"], $diemdanhgia, $noidung, $time);

// Quay lại trang trước đó
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
