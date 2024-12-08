<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
  
$vnp_TmnCode = "I550V866"; //Mã định danh merchant kết nối (Terminal Id)
$vnp_HashSecret = "9AT9BR4I1606Z4LJY12AHJOE0V1UOHHI"; //Secret key
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/sachminhanh/payment.php";
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
