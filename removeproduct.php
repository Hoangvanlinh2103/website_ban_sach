<?php
session_start();
require_once("classgiohang.php");
require_once("classsach.php");

$user = $_SESSION["makh"];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tensach = isset($_POST['tensach']) ? $_POST['tensach'] : '';
    $masachList = sach::GetByName($tensach);
    $masach = $masachList[0];
    $remove = giohang::removeproductfromcart($masach->masach,$user);
    header("Location: giaodienkh.php");
}
?>
