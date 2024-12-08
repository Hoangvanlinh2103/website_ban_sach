<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once("./config.php");

// Lấy thông tin từ POST
$listbookname = $_POST['tensach']; // Mảng tên sách
$soluong = $_POST['soluong']; // Mảng số lượng sách
$giaban = $_POST['giaban']; // Mảng giá sách
$vnp_Amount = $_POST['amount']; // Số tiền thanh toán
$vnp_Locale = $_POST['language']; // Ngôn ngữ thanh toán
$vnp_BankCode = $_POST['bankCode']; // Phương thức thanh toán
$vnp_TxnRef = rand(1, 10000); // Mã tham chiếu giao dịch
$vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // Địa chỉ IP khách hàng

// Chuẩn bị các tham số thanh toán cho GET
$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount * 100, // Chuyển đổi thành tiền VND
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" =>  "Thanh toan GD: " . $vnp_TxnRef,  // Thông tin đơn hàng đã mã hóa
    "vnp_OrderType" => "other",
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
    "vnp_ExpireDate" => $expire
);

// Thêm Mã Ngân hàng nếu có
if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

// Sắp xếp tham số theo thứ tự bảng chữ cái
ksort($inputData);

// Tạo chuỗi query
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

// Xây dựng URL VNPAY và tính toán chữ ký
$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    // Tính toán mã băm an toàn (Secure Hash)
    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash; // Gửi chữ ký bảo mật đi cùng URL
}

// Chuyển hướng đến cổng thanh toán VNPAY
header('Location: ' . $vnp_Url);
die();
?>
