<?php
session_start();

$bookname = isset($_GET['book_name']) ? $_GET['book_name'] : '';
$booktitle = isset($_GET['title']) ? $_GET['title'] : '';
$minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : '';
$maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : '';
$action = isset($_GET["action"]) ? $_GET["action"] : 0;


function removeAccents($str) {
    $accents = [
        'a' => ['á', 'à', 'ả', 'ã', 'ạ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ','Á', 'À', 'Ả', 'Ã', 'Ạ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ'],
        'e' => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ','É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ'],
        'i' => ['í', 'ì', 'ỉ', 'ĩ', 'ị','Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'],
        'o' => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ','Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ'],
        'u' => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự','Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự'],
        'y' => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ','Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ'],
        'd' => ['đ','Đ']
    ];
    
    foreach ($accents as $nonAccent => $accentedChars) {
        $str = str_replace($accentedChars, $nonAccent, $str);
    }
    
    return $str;
}


$keywordNoAccent = removeAccents($bookname);
$keywords = explode(" ", $keywordNoAccent);

?>



<!DOCTYPE html>
<html lang="en">
<style>
        .main-container {
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin: 100px auto;
        }
        .main-container>* {
            margin: 0 10px;
        }

        /* Form Container Styling */
        .form-container {
            width: 50%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .form-container h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin: 25px 0; /* Adds space below each form group */
        }

        .form-group label {
            margin-bottom: 5px; /* Optional: Adds space between label and input */
        }

        .form-group input[readonly] {
            background-color: #f0f0f0; /* Light gray background color */
            color: #333; /* Darker text color for readability */
            border: 1px solid #ccc; /* Optional: subtle border to match the design */
        }


        .form-group label {
            display: block;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        /* Payment Method Section */

        .form-group input[type="radio"] {
            margin-right: 5px;
        }


        .submit-btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        div>h2 {
        text-align: center;
        }


        /* Product List Styling */
        .product-list {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
        }

        .product {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .product img {
            width: 80px;
            height: 80px;
            margin-right: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .product-details {
            flex-grow: 1;
        }

        .product-details p {
            margin: 0;
            color: #555;
        }

        .product-price {
            font-weight: bold;
            color: #333;
        }

        .product-list {
        max-height: 400px; /* Adjust this value as needed */
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ccc; /* Optional styling */
        margin-bottom: 20px;
    }
    .product-total {
        text-align: right; /* Aligns content inside product-total to the right */
        margin-top: 10px;
        font-weight: bold; /* Optional: makes the total stand out */
    }

/* Định dạng cho tiêu đề h2 */
.payment-heading {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

/* Định dạng cho các thẻ p hiển thị thông tin thanh toán */
.payment-info {
    font-size: 18px;
    color: #555;
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    background-color: #f9f9f9;
}

/* Định dạng cho thông báo lỗi */
.error-message {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 15px;
    margin-top: 20px;
    border-radius: 8px;
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.error-message p {
    margin: 0;
}

/* Cấu trúc của khối thông tin đơn hàng */
.order-summary {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 15px; /* Khoảng cách giữa các phần tử */
    width: 100%;
}

/* Định dạng cho các đoạn văn thông tin */
.order-summary p {
    font-size: 18px;
    margin: 10px 0;
}

/* Định dạng tiêu đề */
.order-summary h3 {
    font-size: 22px;
    margin: 10px 0;
}

/* Cải thiện bảng thông tin đơn hàng */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

/* Cải thiện các ô trong bảng */
table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

/* Màu sắc cho tiêu đề của bảng */
table th {
    background-color: #4CAF50;
    color: white;
    font-size: 16px;
}

/* Màu sắc của các hàng trong bảng */
table tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Màu sắc khi hover trên các hàng trong bảng */
table tr:hover {
    background-color: #ddd;
}

/* Định dạng số tiền */
.money {
    font-weight: bold;
    color: #4CAF50;
}

/* Định dạng bảng tổng tiền */
.total-amount {
    font-size: 18px;
    font-weight: bold;
    color: #e74c3c;
}


</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Shop</title>
    <link href='./assets/img/iconlogo.jpg' rel='icon' type='image/x-icon' />
    <link rel="stylesheet" href="./assets/css/main.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="giaodienkh.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="./assets/font/font-awesome-pro-v6-6.2.0/css/all.min.css"/>
</head>
<body>
    <header>
        <div class="header-middle">
            <div class="container">
                <div class="header-middle-left">
                    <div class="header-logo">
                        <a href="">
                            <img src="./assets/img/iconlogos.jpg" alt="" class="header-logo-img">
                        </a>
                    </div>
                </div>
                <div class="header-middle-center">
                    <div  class="form-search">
                        <span class="search-btn" onclick="redirectToUrl()"><i class="fa-light fa-magnifying-glass"></i></span>
                        <input type="text" id="find-book" class="form-search-input" placeholder="Tìm kiếm sách...">
                        <button class="filter-btn" onclick="toggleAdvancedSearch(event)"><i class="fa-light fa-filter-list"></i><span>Lọc</span></button>
                    </div>                    
                </div>
                
                <div class="header-middle-right">
                    <ul class="header-middle-right-list">
                        <li class="header-middle-right-item dnone open" onclick="openSearchMb()">
                            <div class="cart-icon-menu">
                                <i class="fa-light fa-magnifying-glass"></i>
                            </div>
                        </li>
                        <li class="header-middle-right-item close" onclick="closeSearchMb()">
                            <div class="cart-icon-menu">
                                <i class="fa-light fa-circle-xmark"></i>
                            </div>
                        </li>
                        <li class="header-middle-right-item dropdown open">
                            <i class="fa-light fa-user"></i>
                            <div class="auth-container">
                            <?php if (empty($_SESSION["makh"])) { ?>
                                <span class="text-dndk">Đăng nhập / Đăng ký</span>
                                <span class="text-tk">Tài khoản<i class="fa-sharp fa-solid fa-caret-down"></i></span>
                            <?php } else { ?>
                                <span class="text-tk"><?php echo $_SESSION["makh"]; ?> <i class="fa-sharp fa-solid fa-caret-down"></i></span>
                            <?php } ?>
                            </div>
                            <ul class="header-middle-right-menu">
                                <?php if (empty($_SESSION["makh"])) { ?>
                                    <!-- Nếu chưa đăng nhập -->
                                    <li><a id="login" href="#"><i class="fa-light fa-right-to-bracket"></i> Đăng nhập</a></li>
                                    <li><a id="signup" href="javascript:;"><i class="fa-light fa-user-plus"></i> Đăng ký</a></li>
                                <?php } else { ?>
                                    <!-- Nếu đã đăng nhập -->
                                    <li><a onclick="openModal('updateInfoModal')"><i class="fa-light fa-user-edit"></i> Cập nhật thông tin</a></li>
                                    <li><a href="donhang.php"><i class="fa-light fa-box"></i> Đơn hàng</a></li>
                                    <li><a onclick="openModal('changePasswordModal')"><i class="fa-light fa-key"></i> Đổi mật khẩu</a></li>
                                    <li><a href="dangxuat.php?action=1"><i class="fa-light fa-sign-out-alt"></i> Đăng xuất</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="header-middle-right-item open" onclick="openCart()">
                            <div class="cart-icon-menu">
                                <i class="fa-light fa-basket-shopping"></i>
                                <?php
                                require_once("classgiohang.php");
                                if(empty($_SESSION["makh"])){
                                    ?>
                                    <span class="count-product-cart"><?php echo 0 ?></span>
                                    <?php
                                }
                                else{
                                    $sl = Giohang::Countuserproduct($_SESSION["makh"]);
                                    ?>
                                    <span class="count-product-cart"><?php echo $sl ?></span>
                                    <?php
                                } 
                                ?>
                            </div>
                            <span>Giỏ hàng</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <nav  class="header-bottom">
        <div aligen="center" class="container">
            <ul class="menu-list">
                <pre>    </pre>          
                <li class="menu-list-item"><a href="giaodienkh.php" class="menu-link">Trang Chủ</a></li>
            <li class="menu-list-item"><a href="javascript:;" class="menu-link">Tin Sách</a></li>
            <li class="menu-list-item"><a href="giaodienkh.php?title=sách khuyến mãi" class="menu-link">Sách Khuyến Mãi</a></li>
            <li class="menu-list-item"><a href="giaodienkh.php?title=sách bán chạy" class="menu-link">Sách Bán Chạy</a></li>
            <li class="menu-list-item"><a href="javascript:;" class="menu-link">Tác Giả</a></li>
            <li class="menu-list-item"><a href="javascript:;" class="menu-link">Liên Hệ</a></li>
            </ul>
        </div>
    </nav>
    <div class="advanced-search">
        <div class="container">
            <div class="advanced-search-category">
                <span>Phân loại </span>
                    <?php
                    require_once("classsach.php");
                    $dss = sach::GetTheloai();
                    ?>
                <select name="loaisach" id="advanced-search-category-select">
                    <option value="">Tất cả</option>
                    <?php foreach ($dss as $loaisach): ?>
                        <option value="<?php echo urlencode($loaisach); ?>"><?php echo htmlspecialchars($loaisach); ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
                <div class="advanced-search-price">
                    <span>Giá từ</span>
                    <input type="number" placeholder="tối thiểu" id="min-price">
                    <span>đến</span>
                    <input type="number" placeholder="tối đa" id="max-price">
                    <button id="advanced-search-price-btn" onclick="redirectToUrl()"><i class="fa-light fa-magnifying-glass-dollar"></i></button>
                </div>
        </div>
    </div>

    <div class="modal-cart">
        <div class="cart-container">
            <div class="cart-header">
                <h3 class="cart-header-title"><i class="fa-regular fa-basket-shopping-simple"></i> Giỏ hàng</h3>
                <button class="cart-close" onclick="closeCart()"><i class="fa-sharp fa-solid fa-xmark"></i></button>
            </div>
            <div class="cart-body">
                <?php
                require_once("classgiohang.php");
                if(empty($_SESSION["makh"])){    
                }
                else{
                $cart = Giohang::Getlistusercart($_SESSION["makh"]);
                ?>
                 <form method="post" action="process_cart.php">
                    <div class="gio-hang-trong">
                    <?php foreach ($cart as $item):
                        // Kiểm tra xem có khuyến mãi cho sách này không
                        $khuyenMai = isset($khuyenMaiMap[$item['masach']]) ? $khuyenMaiMap[$item['masach']] : 0;  // Nếu có khuyến mãi thì lấy, nếu không thì để 0
                    ?>
                        <div class="product_cart">  
                            <img style="width: 25%; height: auto;" src="img/<?php echo htmlspecialchars($item['hinhanh']); ?>" alt="<?php echo htmlspecialchars($item['tensach']); ?>">
                            <div class="product-detail">
                                <p>Tên sách: <?php echo htmlspecialchars($item['tensach']); ?></p>
                                <p>Giá: <?php echo number_format($item['giaban'] * (1- $khuyenMai/100) ); ?> VNĐ</p>
                                <p>Số lượng: 
                                    <input type="number" class="quantity-input" value="<?php echo htmlspecialchars($item['soluong']); ?>" min="1" data-masach="<?php echo htmlspecialchars($item['masach']); ?>" />
                                </p>
                                <p>Tổng: <span class="item-total"><?php echo number_format(($item['giaban'] * (1- $khuyenMai/100) ) * $item['soluong']); ?> VNĐ</span></p> <!-- Display total price for the item -->
                            </div>
                            <div>
                            <button type="button" class=" delete-button" onclick="deleteItem(this, '<?php echo htmlspecialchars($item['tensach'], ENT_QUOTES, 'UTF-8'); ?>')">Xóa</button>
                            <button type="button" class=" select-button" onclick="selectItem(this, <?php echo htmlspecialchars($item['giaban']); ?>)">O</button>
                            <button type="button" class=" save-button" onclick="saveQuantity(this)">Lưu</button>
                            </div>                       
                        </div>
                        <?php endforeach; 
                    }
                    ?>
                    </div>
                </form>
            </div>
            <div class="cart-footer">
                <div class="cart-total-price">
                    <p class="text-tt">Tổng tiền:</p>
                    <p class="text-price" id="totalPrice">0đ</p>
                </div>
                <div class="cart-footer-payment">
                    <button class="them-sach "><i class="fa-regular fa-plus"></i> Thêm sách</button>
                    <button class="thanh-toan" onclick="payment()">Thanh toán</button>
                </div>
            </div>
        </div>
    </div>
                
    
    <div class="main-container">
    <?php
    require_once("classkhachhang.php");
    require_once("classsach.php");
    require_once("./config.php");
    require_once("classthanhtoan.php");
    require_once("classdonhangxuat.php");
    require_once("classkhuyenmai.php");
    // Lấy tất cả khuyến mãi
    $dsKhuyenMai = Khuyenmai::GetPTKM();
    $khuyenMaiMap = [];
    if (!empty($dsKhuyenMai)) { // Kiểm tra $dsKhuyenMai có hợp lệ trước khi lặp
        foreach ($dsKhuyenMai as $km) {
            $khuyenMaiMap[$km->masach] = $km->ptkm;
        }
    }
    

    $tensach = isset($_POST['tensach']) ? $_POST['tensach'] : null; // Mảng tên sách
    $soluong = isset($_POST['soluong']) ? $_POST['soluong'] : null; // Mảng số lượng
    $giaban = isset($_POST['giaban']) ? $_POST['giaban'] : null; // Mảng tổng tiền

    // Kiểm tra nếu tensach là mảng
    if (is_array($tensach)) {
        $dsmasach = [];
        foreach ($tensach as $tensach_item) {
            $dssp = sach::GetByName($tensach_item);
            foreach ($dssp as $sach) {
                $dsmasach[] = $sach->masach;
            }
        }
    }

    if (isset($_POST['soluong'], $_POST['giaban'], $_POST['tensach'])) {
        $_SESSION["soluong"] = $_POST["soluong"];
        $_SESSION["masach"] = $dsmasach;
    }
    
    
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : null;
    $book_names = isset($_POST['book_names']) ? $_POST['book_names'] : null;
    
    if (isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] == '00') {
        // Payment was successful
        $payment_online_sucess = TRUE;
    } else {
        // Payment failed
        $payment_online_sucess = FALSE;
    }
        

    $khach = khachhang::Get($_SESSION['makh']);
    if (isset($khach[0])) {
        $customer = $khach[0]; // Use the first element of the array (since Get() returns an array)
    } else {
        $customer = null;
    }
    if($tensach){
        $tong = 0; // Khởi tạo tổng tiền đơn hàng
                // Tính tổng tiền của đơn hàng
        foreach ($tensach as $index => $name) {
            $tong += $giaban[$index];
        }
    }

    if($payment_online_sucess){
        $vnp_Amount = isset($_GET['vnp_Amount']) ? $_GET['vnp_Amount'] : null;
        if ($vnp_Amount !== null) {
            // Chuyển đổi từ hào sang đồng
            $amountInVND = $vnp_Amount / 100;
            if (isset($_SESSION['masach'], $_SESSION['soluong'])) {
                $ds_masach = $_SESSION['masach'];
                $ds_soluong = $_SESSION['soluong'];
    
                $madh = Donhangxuat::TangMadonhang();
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $today = date('Y-m-d');
                Donhangxuat::Adddonhang_online($madh,$today,null,$_SESSION["makh"],$amountInVND,"Chưa xử lý","Đã thanh toán");
                $thanhtoan = new Thanhtoanxuat($madh,$today,$amountInVND);
                Thanhtoanxuat::AddThanhToanXuat($thanhtoan);
    
                // Lưu từng sách vào bảng đơn hàng
                foreach ($ds_masach as $index => $masach) {
                    $soluong = $ds_soluong[$index];
                    $remove = giohang::removeproductfromcart($masach, $_SESSION["makh"]); // Xóa sản phẩm khỏi giỏ hàng
                    Donhangxuat::Adddonhang_chitiet($madh,$masach,$soluong);
                }
                 // Hiển thị thông tin đơn hàng
            echo "<div class='order-summary'>";
            echo "<p><strong>Thanh toán thành công!</strong></p>";
            echo "<p><strong>Mã đơn hàng:</strong> $madh</p>";
            echo "<p><strong>Ngày đặt:</strong> $today</p>";
            echo "<p><strong>Tổng số tiền thanh toán:</strong> " . number_format($amountInVND, 0, ',', '.') . " VND</p>";
            
            // Hiển thị thông tin chi tiết đơn hàng
            echo "<h3>Thông tin chi tiết đơn hàng:</h3>";
            echo "<table border='1' cellpadding='5' cellspacing='0'>
                    <tr>
                        <th>Tên sách</th>
                        <th>Số lượng</th>
                        <th>Giá bán (VND)</th>
                        <th>Tổng tiền (VND)</th>
                    </tr>";

            $tong = 0; // Khởi tạo tổng tiền cho các sách trong đơn hàng
            foreach ($ds_masach as $index => $masach) {
                $khuyenMai = isset($khuyenMaiMap[$masach]) ? $khuyenMaiMap[$masach] : 0;  // Nếu có khuyến mãi thì lấy, nếu không thì để 0
                // Lấy thông tin sách từ cơ sở dữ liệu
                $sachList = sach::Get($masach); 
                if ($sach = $sachList[0]) {
                    $tensach = $sach->tensach; // Lấy tên sách
                    $giaban = $sach->giaban * (1 - $khuyenMai / 100);
                    $soluong = $ds_soluong[$index];
                    $tongtien = $giaban * $soluong;
                    $tong += $tongtien;

                    // In ra chi tiết từng sách trong đơn hàng
                    echo "<tr>
                            <td>$tensach</td>
                            <td>$soluong</td>
                            <td>" . number_format($giaban, 0, ',', '.') . " VND</td>
                            <td>" . number_format($tongtien, 0, ',', '.') . " VND</td>
                          </tr>";
                }
            }

            echo "</table>";

            // Hiển thị tổng tiền
            echo "<p><strong>Tổng tiền tất cả sách:</strong> " . number_format($tong, 0, ',', '.') . " VND</p>";
            echo "<p>Trạng thái đơn hàng: Đã thanh toán, Chưa xử lý</p>";
            echo "</div>";
            }
        }
    ?>
    </div>
    <?php
    }else{
    ?>
    <!-- Payment Form on the Left -->
    <div class="form-container">
    <?php
    // Kiểm tra nếu các mảng tên sách, số lượng và giá bán có giá trị
    if (empty($payment_method)) {
    ?>
        <h2>Thông Tin Thanh Toán</h2>
        <form action="payment.php" method="post" id="payment-form">

            <!-- Customer Information Fields -->
            <div class="form-group">
                <label for="name">Khách hàng:</label>
                <input type="text" id="name" name="name" required readonly value="<?php echo isset($customer) ? htmlspecialchars($customer->makh) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="name">Tên khách hàng:</label>
                <input type="text" id="name" name="name" required readonly value="<?php echo isset($customer) ? htmlspecialchars($customer->tenkh) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="phone">Số Điện Thoại:</label>
                <input type="tel" id="phone" name="phone" required pattern="[0-9]{10,11}" readonly value="<?php echo isset($customer) ? htmlspecialchars($customer->sdt) : ''; ?>">        
            </div>
            <div class="form-group">
                <label for="address">Địa Chỉ Giao Hàng:</label>
                <input type="text" id="address" name="address" required readonly value="<?php echo isset($customer) ? htmlspecialchars($customer->diachikh) : ''; ?>">
            </div>
            <!-- Các trường ẩn để lưu thông tin sản phẩm -->
            <?php foreach ($tensach as $index => $name) { ?>
                <input type="hidden" name="tensach[]" value="<?php echo htmlspecialchars($name); ?>">
                <input type="hidden" name="soluong[]" value="<?php echo htmlspecialchars($soluong[$index]); ?>">
                <input type="hidden" name="giaban[]" value="<?php echo htmlspecialchars($giaban[$index]); ?>">                
                <input type="hidden" name="amount" value="<?php echo htmlspecialchars($tong); ?>">
                <input type="hidden" name="language" value="<?php echo htmlspecialchars('vn'); ?>">
            <?php } ?>

            <!-- Payment Method Selection -->
            <div class="form-group payment-method">
                <label for="payment-method">Phương Thức Thanh Toán:</label><br>
                <input type="radio" id="cash" name="payment_method" value="cash">
                <label for="cash">Thanh toán khi giao hàng</label>
                <input type="radio" id="bank" name="payment_method" value="bank">
                <label for="bank">Chuyển Khoản qua ngân hàng</label>
            </div>

            <!-- Hidden Input to store book names -->
            <input type="hidden" id="book_names" name="book_names" value="">

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Thanh Toán</button>
        </form>
    <?php
    }
    if ($payment_method == "bank") {
        ?>
            <div class="table-responsive">
                <form action="vnpay_create_payment.php" id="frmCreateOrder" method="post">        
                    <div class="form-group">
                        <label for="amount">Số tiền</label>
                        <input class="form-control" data-val="true" data-val-number="The field Amount must be a number." data-val-required="The Amount field is required." id="amount" max="100000000" min="1" name="amount" type="number" value="<?php echo $tong?>" />
                    </div>
                     <h4>Chọn phương thức thanh toán</h4>
                    <div class="form-group">
                    <input type="radio" id="vnpayqr_gateway" name="bankCode" value="">
                    <label for="vnpayqr_gateway">Cổng thanh toán VNPAYQR</label><br>

                    <input type="radio" id="vnpayqr_app" name="bankCode" value="VNPAYQR">
                    <label for="vnpayqr_app">Thanh toán bằng ứng dụng hỗ trợ VNPAYQR</label><br>

                    <input type="radio" id="atm_domestic" name="bankCode" value="VNBANK">
                    <label for="atm_domestic">Thanh toán qua thẻ ATM/Tài khoản nội địa</label><br>

                    <input type="radio" id="international_card" name="bankCode" value="INTCARD">
                    <label for="international_card">Thanh toán qua thẻ quốc tế</label><br>

                    </div>
                    <div class="form-group">
                        <h5>Chọn ngôn ngữ giao diện thanh toán:</h5>
                        <input type="radio" id="language_vn" name="language" value="vn">
                    <label for="language_vn">Tiếng Việt</label><br>

                    <input type="radio" id="language_en" name="language" value="en">
                    <label for="language_en">Tiếng Anh</label><br>
                         
                    </div>
                    <button type="submit" class="btn btn-default" href>Thanh toán</button>

                    <?php foreach ($tensach as $index => $name) {?>                        
                        <input type="hidden" name="tensach[]" value="<?php echo htmlspecialchars($name); ?>">
                        <input type="hidden" name="soluong[]" value="<?php echo htmlspecialchars($soluong[$index]); ?>">
                        <input type="hidden" name="giaban[]" value="<?php echo htmlspecialchars($giaban[$index]); ?>">                
                    <?php } ?>

                </form>
            </div>
     <?php
    }
    elseif($payment_method == "cash" ) {
        echo "<h2>Thanh Toán thành công</h2>";
        // Kiểm tra xem các thông tin thanh toán đã được gửi đầy đủ chưa
        if ($name && $phone && $address && $payment_method && $book_names) {
            // Xử lý thanh toán (có thể lưu vào cơ sở dữ liệu, gửi email, v.v...)
            
            // Hiển thị thông tin thanh toán
            echo "<p class='payment-info'>Khách hàng: $name</p>";
            echo "<p class='payment-info'>Số Điện Thoại: $phone</p>";
            echo "<p class='payment-info'>Địa Chỉ: $address</p>";
            echo "<p class='payment-info'>Phương Thức Thanh Toán: " . ($payment_method == 'cash' ? 'Thanh toán khi giao hàng' : 'Chuyển Khoản qua ngân hàng') . "</p>";
            echo "<p class='payment-info'>Sách Đặt Mua: $book_names</p>";
            require_once("classgiohang.php");
            require_once("classdonhangxuat.php");
            require_once("classsach.php");            
            if ($tensach && $soluong && $giaban) {
            
                // Tạo mã đơn hàng mới
                $madh = Donhangxuat::TangMadonhang();
                $time = date("Y-m-d H:i:s"); // Lấy thời gian hiện tại
                $user = $_SESSION['makh']; // Lấy mã khách hàng từ session (giả định mã khách hàng đã được lưu trong session)
                       
                // Thêm đơn hàng mới
                $donhang = Donhangxuat::Adddonhang($madh, $time, null, $user, $tong, 'Chưa xử lý');
            
                // Thêm chi tiết cho từng sản phẩm trong đơn hàng
                foreach ($tensach as $index => $name) {
                    $masachList = sach::GetByName($name); // Lấy mã sách dựa trên tên sách
                    $masach = $masachList[0];
            
                    if ($masach) { // Nếu tìm thấy mã sách, thực hiện các thao tác thêm vào chi tiết đơn hàng và xóa khỏi giỏ hàng
                        $remove = giohang::removeproductfromcart($masach->masach, $user); // Xóa sản phẩm khỏi giỏ hàng
                        $donhangct = Donhangxuat::Adddonhang_chitiet($madh, $masach->masach, $soluong[$index]); // Thêm chi tiết đơn hàng
                    }
                }      
            }
        }
    }
    
    ?>
    </div>
    
    <!-- Product List -->
    <div>
        <h2>Danh Sách Sản Phẩm</h2>
        <div class="product-list">
            <?php
            $tongCong = 0; // Biến để tính tổng cộng giá tiền

            foreach ($tensach as $index => $name) {
               
                $sachList = sach::GetByName($name);
                $sach = $sachList[0];
                if ($sach) { // Kiểm tra xem $sach có khác null không
                     // Tính khuyến mãi nếu có
                    $khuyenMai = isset($khuyenMaiMap[$sach->masach]) ? $khuyenMaiMap[$sach->masach] : 0;
                    $tongCong += htmlspecialchars($soluong[$index])*(htmlspecialchars($sach->giaban)* (1 - $khuyenMai/100));
            ?>
                <div class="product">
                    <img src="img/<?php echo htmlspecialchars($sach->img); ?>" alt="Product Image">
                    <div class="product-details">
                        <p>Tên Sản Phẩm: <?php echo htmlspecialchars($sach->tensach); ?></p>
                        <p>Số Lượng: <?php echo htmlspecialchars($soluong[$index]); ?></p>
                        <p class="product-price">Tổng: <?php echo number_format(htmlspecialchars($soluong[$index])*(htmlspecialchars($sach->giaban)* (1 - $khuyenMai/100)), 0, ',', '.') . ' VNĐ'; ?></p>
                    </div>
                </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="product-total">
            <p><strong>Tổng Cộng: <?php echo number_format($tongCong, 0, ',', '.') . ' VNĐ'; ?></strong></p>
        </div>
    </div>
    </div>
    <?php
    }
    ?>



    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-top-content">
                    <div class="footer-top-img">
                        <img src="./assets/img/iconlogos.jpg" alt="">
                    </div>
                    <div class="footer-top-subbox">
                        <div class="footer-top-subs">
                            <h2 class="footer-top-subs-title">Đăng ký nhận tin</h2>
                            <p class="footer-top-subs-text">Nhận thông tin mới nhất từ chúng tôi</p>
                        </div>
                        <form class="form-ground">
                            <input type="email" class="form-ground-input" placeholder="Nhập email của bạn">
                            <button class="form-ground-btn">
                                <span>ĐĂNG KÝ</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget-area">
            <div class="container">
                <div class="widget-row">
                    <div class="widget-row-col-1">
                        <h3 class="widget-title">Về chúng tôi</h3>
                        <div class="widget-row-col-content">
                            <p>MINH ANH BOOK là thương hiệu được thành lập vào năm 2024 với tiêu chí đặt chất lượng sản phẩm lên hàng đầu.</p>
                        </div>
                        <div class="widget-social">
                            <div class="widget-social-item">
                                <a href="">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </div>
                            <div class="widget-social-item">
                                <a href="">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                            <div class="widget-social-item">
                                <a href="">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                            <div class="widget-social-item">
                                <a href="">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="widget-row-col">
                        <h3 class="widget-title">Liên kết</h3>
                        <ul class="widget-contact">
                            <li class="widget-contact-item">
                                <a href="">
                                    <i class="fa-regular fa-arrow-right"></i>
                                    <span>Về chúng tôi</span>
                                </a>
                            </li>
                            <li class="widget-contact-item">
                                <a href="">
                                    <i class="fa-regular fa-arrow-right"></i>
                                    <span>Điều khoản</span>
                                </a>
                            </li>
                            <li class="widget-contact-item">
                                <a href="">
                                    <i class="fa-regular fa-arrow-right"></i>
                                    <span>Liên hệ</span>
                                </a>
                            </li>
                            <li class="widget-contact-item">
                                <a href="">
                                    <i class="fa-regular fa-arrow-right"></i>
                                    <span>Tin tức</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="widget-row-col">
                        <h3 class="widget-title">Sách giáo khoa</h3>
                        <ul class="widget-contact">
                            <li class="widget-contact-item">
                                <a href="">
                                    <i class="fa-regular fa-arrow-right"></i>
                                    <span>SÁCH 1</span>
                                </a>
                            </li>
                            <li class="widget-contact-item">
                                <a href="">
                                    <i class="fa-regular fa-arrow-right"></i>
                                    <span>SÁCH 2</span>
                                </a>
                            </li>
                            <li class="widget-contact-item">
                                <a href="">
                                    <i class="fa-regular fa-arrow-right"></i>
                                    <span>SÁCH 3</span>
                                </a>
                            </li>
                            <li class="widget-contact-item">
                                <a href="">
                                    <i class="fa-regular fa-arrow-right"></i>
                                    <span>Sách giáo khoa khác</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="widget-row-col-1">
                        <h3 class="widget-title">Liên hệ</h3>
                        <div class="contact">
                            <div class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fa-regular fa-location-dot"></i>
                                </div>
                                <div class="contact-content">
                                    <span>Hoài Đức, Hà Nội</span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fa-regular fa-phone"></i>
                                </div>
                                <div class="contact-content contact-item-phone">
                                    <span>0123 456 789</span>
                                    <br>
                                    <span>0123 456 789</span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-item-icon">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <div class="contact-content conatct-item-email">
                                    <span>abcd@eaut.edu.vn</span><br />
                                    <span>abcd@eaut.edu.vn</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyright-wrap">
        <div class="container">
            <div class="copyright-content">
                <p>Copyright 2024 Book Shop. All Rights Reserved.</p>
            </div>
        </div>
    </div>
    <div class="back-to-top">
        <a href="#"><i class="fa-regular fa-arrow-up"></i></a>
    </div>

    <div id="toast"></div>
    <script src="./js/main.js?v=<?php echo time() ?>"></script>
    <script>
// JavaScript to handle form submission
document.getElementById('payment-form').addEventListener('submit', function(e) {
    // Check if the "Thanh toán khi giao hàng" option is selected
    var paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    
    if (paymentMethod && paymentMethod.value == 'cash') {
        // Collect book names to send via POST
        var tensach = <?php echo json_encode($tensach); ?>;
        document.getElementById('book_names').value = tensach.join(','); // Convert array to a comma-separated string
    }
});

<?php foreach ($tensach as $index => $name) { ?>
// Lưu dữ liệu vào localStorage
localStorage.setItem('tensach', JSON.stringify(<?php echo json_encode($name); ?>));
localStorage.setItem('soluong', JSON.stringify(<?php echo json_encode($soluong[$index]); ?>));
localStorage.setItem('giaban', JSON.stringify(<?php echo json_encode($giaban[$index]); ?>));
<?php
}
?>
var tensach = JSON.parse(localStorage.getItem('tensach'));
var soluong = JSON.parse(localStorage.getItem('soluong'));
var giaban = JSON.parse(localStorage.getItem('giaban'));

// Hiển thị dữ liệu hoặc xử lý
console.log(tensach, soluong, giaban);

</script>
</body>
</html>