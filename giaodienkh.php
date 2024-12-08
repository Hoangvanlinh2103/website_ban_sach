<?php
session_start();
require_once("classtaikhoan.php");
$bookname = isset($_GET['book_name']) ? $_GET['book_name'] : '';
$booktitle = isset($_GET['title']) ? $_GET['title'] : '';
$minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : '';
$maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : '';
$action = isset($_GET["action"]) ? $_GET["action"] : 0;

if($action == 1){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST['user'];
        $password = $_POST['password'];
        $taikhoan = Taikhoan::dangnhap($user, $password);
        if ($taikhoan) {
            if ($taikhoan->thanphan == "admin") {
                $_SESSION["ma"] = "Admin";
                $_SESSION["manv"] = Taikhoan::GetManv($user);
                header("Location: admin.php");
                exit();
            } elseif($taikhoan->thanphan == "Nhân Viên"){
                $_SESSION["ma"] = "Nhân Viên";
                $_SESSION["manv"] = Taikhoan::GetManv($user);
                header("Location: admin.php");
            }else {
                $_SESSION["makh"] =Taikhoan::GetMakh($user);;
                header("Location: giaodienkh.php");
                exit();
            }
        } else {
            echo "<script>alert('Tên đăng nhập hoặc mật khẩu không chính xác!');</script>";
        }
    }
}
 elseif ($action == 2) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = htmlspecialchars($_POST['user']);
        $password = $_POST['password'];
        $repassword = $_POST['rePassword'];
        $tenkh = htmlspecialchars($_POST['tenkh']);
        $dckh = htmlspecialchars($_POST['dckh']);
        $sdt = htmlspecialchars($_POST['sdt']);

        if ($password !== $repassword) {
            echo "<script>alert('Hai mật khẩu không giống nhau!');</script>";
        } else {
            $result = Taikhoan::dangky($user, $password, $tenkh, $dckh, $sdt);
            if ($result) {
                echo "<script>alert('Đăng ký thành công!');</script>";
                // Redirect or show a success message
            } else {
                echo "<script>alert('Đăng ký thất bại!');</script>";
            }
        }
    }
   
}
elseif ($action == 3) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['masach']) && isset($_POST['soluong'])) {
            $masach = $_POST['masach'];  // Mã sách
            $soluong = $_POST['soluong'];  // Số lượng mới

            // Kiểm tra nếu số lượng hợp lệ (lớn hơn 0)
            if ($soluong > 0) {
                // Gọi phương thức để cập nhật số lượng trong giỏ hàng
                require_once("classgiohang.php");
                $result = Giohang::UpdateQuantity($_SESSION['makh'], $masach, $soluong);

                if ($result) {
                    echo "<script>alert('Thay đổi số lượng thành công!'); window.location.href = 'giaodienkh.php';</script>";
                } else {
                    echo "<script>alert('Thay đổi số lượng không thành công!'); window.location.href = 'giaodienkh.php';</script>";
                }
            } else {
                echo "<script>alert('Số lượng phải lớn hơn 0!'); window.location.href = 'giaodienkh.php';</script>";
            }
        }
    }
}

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
                                    <li><a href="khquanlydonhang.php"><i class="fa-light fa-box"></i> Đơn hàng</a></li>
                                    <li><a href="doimatkhau.php"><i class="fa-light fa-key"></i> Đổi mật khẩu</a></li>
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
                <li class="menu-list-item"><a href="giaodienkh.php?title=tinsach" class="menu-link">Tin Sách</a></li>
                <li class="menu-list-item"><a href="giaodienkh.php?title=sách khuyến mãi" class="menu-link">Sách Khuyến Mãi</a></li>
                <li class="menu-list-item"><a href="giaodienkh.php?title=sách bán chạy" class="menu-link">Sách Bán Chạy</a></li>
                <li class="menu-list-item"><a href="giaodienkh.php?title=tác giả" class="menu-link">Tác Giả</a></li>
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

    <main class="main-wrapper">
        <div class="container" id="trangchu">
            <div class="home-slider">
                <img src="./assets/img/banner-1.jpg" alt="">
                <img src="./assets/img/banner.png" alt="">
                <img src="./assets/img/book1.jpg" alt="">
                <img src="./assets/img/book2.jpg" alt="">
                <button class="prev-slide">&#10094;</button>
                <button class="next-slide">&#10095;</button>
            </div>
            <div class="home-service" id="home-service">
                <div class="home-service-item">
                    <div class="home-service-item-icon">
                        <i class="fa-light fa-person-carry-box"></i>
                    </div>
                    <div class="home-service-item-content">
                        <h4 class="home-service-item-content-h">GIAO HÀNG NHANH</h4>
                        <p class="home-service-item-content-desc">Cho tất cả đơn hàng</p>
                    </div>
                </div>
                <div class="home-service-item">
                    <div class="home-service-item-icon">
                        <i class="fa-light fa-shield-heart"></i>
                    </div>
                    <div class="home-service-item-content">
                        <h4 class="home-service-item-content-h">SẢN PHẨM CHÍNH HÃNG</h4>
                        <p class="home-service-item-content-desc">Cam kết chất lượng</p>
                    </div>
                </div>
                <div class="home-service-item">
                    <div class="home-service-item-icon">
                        <i class="fa-light fa-headset"></i>
                    </div>
                    <div class="home-service-item-content">
                        <h4 class="home-service-item-content-h">HỖ TRỢ 24/7</h4>
                        <p class="home-service-item-content-desc">Tất cả ngày trong tuần</p>
                    </div>
                </div>
                <div class="home-service-item">
                    <div class="home-service-item-icon">
                        <i class="fa-light fa-circle-dollar"></i>
                    </div>
                    <div class="home-service-item-content">
                        <h4 class="home-service-item-content-h">HOÀN LẠI TIỀN</h4>
                        <p class="home-service-item-content-desc">Nếu không hài lòng</p>
                    </div>
                </div>
            </div>
            <div class="home-title-block" id="home-title">
                <h2 class="home-title">Khám phá sách giáo khoa của chúng tôi</h2>
            </div>
        </div>   
        
        <div class="content">
                <?php
                require_once("classsach.php");
                require_once("classdanhgia.php");
                require_once("classkhuyenmai.php");
                // Lấy tất cả khuyến mãi
                $dsKhuyenMai = Khuyenmai::GetPTKM();
                $khuyenMaiMap = [];
                if (!empty($dsKhuyenMai)) { // Kiểm tra $dsKhuyenMai có hợp lệ trước khi lặp
                    foreach ($dsKhuyenMai as $km) {
                        $khuyenMaiMap[$km->masach] = $km->ptkm;
                    }
                }

                // Lấy sách bán chạy
                if ($booktitle == 'sách bán chạy') {
                    $dss = sach::Getbanchay();
                    if ($dss != NULL) {
                        foreach ($dss as $items) {
                            // Kiểm tra xem có khuyến mãi cho sách này không
                            $khuyenMai = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;  // Nếu có khuyến mãi thì lấy, nếu không thì để 0
                            // Tính giá sau khuyến mãi
                            $giabanSauKhuyenMai = $items->giaban * (1 - $khuyenMai / 100);
                            ?>
                            <div class="product" onclick="window.location.href='book.php?tensach=<?php echo urlencode($items->tensach); ?>';">
                                <div class="image-container">
                                    <img style="width: 300px; height: 300px;" src="./img/<?php echo $items->img ?>">
                                    <!-- Chỉ hiển thị nếu có khuyến mãi -->
                                    <?php if ($khuyenMai > 0): ?>
                                        <span class="ptkm"><?php echo $khuyenMai; ?>%</span>
                                    <?php endif; ?>
                                </div>
                                <h2><?php echo htmlspecialchars($items->loaisach); ?></h2>
                                <h2><?php echo htmlspecialchars($items->tensach); ?></h2>
                                <?php if ($khuyenMai > 0): ?>
                                    <!-- Hiển thị giá gốc với dấu gạch ngang và giá sau khuyến mãi -->
                                    <h2 class="old-price"><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                                    <h2>Giá sau khuyến mãi: <?php echo number_format($giabanSauKhuyenMai, 0, ',', '.'); ?> VNĐ</h2>
                                <?php else: ?>
                                    <!-- Nếu không có khuyến mãi, chỉ hiển thị giá bán bình thường -->
                                    <h2><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    }
                }
                elseif($booktitle == 'sách khuyến mãi'){
                    $dss = Khuyenmai::GetSachKM();
                    if($dss != NULL){
                        foreach ($dss as $items) {
                            // Kiểm tra xem có khuyến mãi cho sách này không
                            $khuyenMai = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;  // Nếu có khuyến mãi thì lấy, nếu không thì để 0
                            // Tính giá sau khuyến mãi
                            $giabanSauKhuyenMai = $items->giaban * (1 - $khuyenMai / 100);
                            ?>
                            <div class="product" onclick="window.location.href='book.php?tensach=<?php echo urlencode($items->tensach); ?>';">
                                <div class="image-container">
                                    <img style="width: 300px; height: 300px;" src="./img/<?php echo $items->img ?>">
                                    <!-- Chỉ hiển thị nếu có khuyến mãi -->
                                    <?php if ($khuyenMai > 0): ?>
                                        <span class="ptkm"><?php echo $khuyenMai; ?>%</span>
                                    <?php endif; ?>
                                </div>
                                <h2><?php echo htmlspecialchars($items->theloai); ?></h2>
                                <h2><?php echo htmlspecialchars($items->tensach); ?></h2>
                                <?php if ($khuyenMai > 0): ?>
                                    <!-- Hiển thị giá gốc với dấu gạch ngang và giá sau khuyến mãi -->
                                    <h2 class="old-price"><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                                    <h2>Giá sau khuyến mãi: <?php echo number_format($giabanSauKhuyenMai, 0, ',', '.'); ?> VNĐ</h2>
                                <?php else: ?>
                                    <!-- Nếu không có khuyến mãi, chỉ hiển thị giá bán bình thường -->
                                    <h2><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    }
                }
                elseif($booktitle == 'tác giả'){
                    $dss = sach::GetAll();
                    if($dss != NULL){
                        foreach ($dss as $items) {
                            ?>
                            <a href="giaodienkh.php?title=tentacgia&tentacgia=<?php echo $items->tacgia ?>"><?php echo $items->tacgia ?></a>
                            <?php
                        }
                    }
                }
                elseif($booktitle == 'tentacgia'){
                    $tacgia = $_GET["tentacgia"] ?? '';
                    $dss = sach::GetSachTheoTacGia($tacgia);
                    if($dss != NULL){
                        foreach ($dss as $items) {
                            // Kiểm tra xem có khuyến mãi cho sách này không
                            $khuyenMai = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;  // Nếu có khuyến mãi thì lấy, nếu không thì để 0
                            // Tính giá sau khuyến mãi
                            $giabanSauKhuyenMai = $items->giaban * (1 - $khuyenMai / 100);
                            ?>
                            <div class="product" onclick="window.location.href='book.php?tensach=<?php echo urlencode($items->tensach); ?>';">
                                <div class="image-container">
                                    <img style="width: 300px; height: 300px;" src="./img/<?php echo $items->img ?>">
                                    <!-- Chỉ hiển thị nếu có khuyến mãi -->
                                    <?php if ($khuyenMai > 0): ?>
                                        <span class="ptkm"><?php echo $khuyenMai; ?>%</span>
                                    <?php endif; ?>
                                </div>
                                <h2><?php echo htmlspecialchars($items->loaisach); ?></h2>
                                <h2><?php echo htmlspecialchars($items->tensach); ?></h2>
                                <h2><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                                <?php if ($khuyenMai > 0): ?>
                                    <!-- Hiển thị giá gốc với dấu gạch ngang và giá sau khuyến mãi -->
                                    <h2 class="old-price"><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                                    <h2>Giá sau khuyến mãi: <?php echo number_format($priceWithDiscount, 0, ',', '.'); ?> VNĐ</h2>
                                <?php else: ?>
                                    <!-- Nếu không có khuyến mãi, chỉ hiển thị giá bán bình thường -->
                                    <h2><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                    }
                }
                elseif($booktitle == 'tinsach'){
                    $dss = Khuyenmai::GetTinKhuyenMai();
                    if($dss != NULL){
                        echo '<div class="khuyenmai-container">'; // Bắt đầu div container
                        foreach ($dss as $items) {
                            ?>
                            <div class="khuyenmai-item">
                                <h1 class="tensk" style="color:red;">Tên Sự Kiện: <?php echo $items->tensk ?></h1>
                                <h1 class="tgbd">Thời Gian Bắt Đầu Từ: <?php echo $items->tgbd ?></h1>
                                <h1 class="tgkt">Đến: <?php echo $items->tgkt ?></h1>
                            </div>
                            <?php
                        }
                        echo '</div>'; // Kết thúc div container
                    }
                    else{ echo '<h1> Không có sự kiện diễn ra! </h1>';}
                }
                
                function renderProduct($items, $rate, $ptkm = 0) {
                    // Tính giá sau khuyến mãi
                    $giabanSauKhuyenMai = $items->giaban * (1 - $ptkm / 100);
                    ?>
                    <div class="product" onclick="window.location.href='book.php?tensach=<?php echo urlencode($items->tensach); ?>';">
                        <div class="image-container">
                                    <img style="width: 300px; height: 300px;" src="./img/<?php echo $items->img ?>">
                                    <!-- Chỉ hiển thị nếu có khuyến mãi -->
                                    <?php if ($ptkm > 0): ?>
                                        <span class="ptkm"><?php echo $ptkm; ?>%</span>
                                    <?php endif; ?>
                                </div>
                        <h2><?php echo htmlspecialchars($items->loaisach); ?></h2>
                        <h2><?php echo htmlspecialchars($items->tensach); ?></h2>
                        <?php if ($ptkm > 0): ?>
                            <!-- Hiển thị giá gốc với dấu gạch ngang và giá sau khuyến mãi -->
                            <h2 class="old-price"><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                            <h2>Giá sau khuyến mãi: <?php echo number_format($giabanSauKhuyenMai, 0, ',', '.'); ?> VNĐ</h2>
                        <?php else: ?>
                            <!-- Nếu không có khuyến mãi, chỉ hiển thị giá bán bình thường -->
                            <h2><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                        <?php endif; ?>
                        <h1><?php echo Danhgia::renderStarRating($rate); ?></h1>
                    </div>
                    <?php
                }
                
                // Kiểm tra các điều kiện tìm kiếm và hiển thị sản phẩm
                if ($bookname == NULL && $booktitle == NULL && $maxPrice == NULL && $minPrice == NULL) {
                    $dss = sach::GetAll();
                    foreach ($dss as $items) {
                        $ptkm = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;
                        $rate = Danhgia::starrate($items->masach);
                        renderProduct($items, $rate, $ptkm);
                    }
                } elseif ($bookname == NULL && $booktitle != NULL && $maxPrice == NULL && $minPrice == NULL) {
                    $dss = sach::Getsachfromloaisach($booktitle);
                    foreach ($dss as $items) {
                        $ptkm = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;
                        $rate = Danhgia::starrate($items->masach);
                        renderProduct($items, $rate, $ptkm);
                    }
                } elseif ($bookname == NULL && $booktitle == NULL && $maxPrice != NULL && $minPrice == NULL) {
                    $dss = sach::Get_over_price($maxPrice);
                    foreach ($dss as $items) {
                        $ptkm = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;
                        $rate = Danhgia::starrate($items->masach);
                        renderProduct($items, $rate, $ptkm);
                    }
                } elseif ($bookname == NULL && $booktitle == NULL && $maxPrice == NULL && $minPrice != NULL) {
                    $dss = sach::Get_less_price($minPrice);
                    foreach ($dss as $items) {
                        $ptkm = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;
                        $rate = Danhgia::starrate($items->masach);
                        renderProduct($items, $rate, $ptkm);
                    }
                } elseif ($bookname == NULL && $booktitle != NULL && $maxPrice != NULL && $minPrice == NULL) {
                    $dss = sach::Get_over_price($maxPrice, $booktitle);
                    foreach ($dss as $items) {
                        $ptkm = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;
                        $rate = Danhgia::starrate($items->masach);
                        renderProduct($items, $rate, $ptkm);
                    }
                } elseif ($bookname == NULL && $booktitle != NULL && $maxPrice == NULL && $minPrice != NULL) {
                    $dss = sach::Get_less_price_and_loaisach($minPrice, $booktitle);
                    foreach ($dss as $items) {
                        $ptkm = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;
                        $rate = Danhgia::starrate($items->masach);
                        renderProduct($items, $rate, $ptkm);
                    }
                } elseif ($bookname == NULL && $booktitle == NULL && $maxPrice != NULL && $minPrice != NULL) {
                    $dss = sach::Get_between_price($minPrice, $maxPrice);
                    foreach ($dss as $items) {
                        $ptkm = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;
                        $rate = Danhgia::starrate($items->masach);
                        renderProduct($items, $rate, $ptkm);
                    }
                } elseif ($bookname == NULL && $booktitle != NULL && $maxPrice != NULL && $minPrice != NULL) {
                    $dss = sach::Get_between_price_and_loaisach($minPrice, $maxPrice, $booktitle);
                    foreach ($dss as $items) {
                        $ptkm = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;
                        $rate = Danhgia::starrate($items->masach);
                        renderProduct($items, $rate, $ptkm);
                    }
                }
                ?>
                

                <?php
                    // Lấy danh sách khuyến mãi
                    $dsKhuyenMai = Khuyenmai::GetPTKM();
                    $khuyenMaiMap = [];
                    if (!empty($dsKhuyenMai)) { // Kiểm tra $dsKhuyenMai có hợp lệ trước khi lặp
                        foreach ($dsKhuyenMai as $km) {
                            $khuyenMaiMap[$km->masach] = $km->ptkm;
                        }
                    }

                    // Hàm hiển thị sản phẩm
                    function displayProduct($items, $rate, $keywords, $bookname) {
                        $titleNoAccent = removeAccents($items->tensach);
                        $name = strtolower($titleNoAccent);
                        $book = strtolower($bookname);
                        $match = true;

                        foreach ($keywords as $word) {
                            if (strpos($name, $word) === false) {
                                $match = false;
                                break;
                            }
                        }

                        if ($match) {
                            global $khuyenMaiMap; // Sử dụng mảng khuyến mãi
                            $discount = isset($khuyenMaiMap[$items->masach]) ? $khuyenMaiMap[$items->masach] : 0;
                            $priceWithDiscount = $items->giaban * (1 - $discount / 100); // Tính giá sau khuyến mãi

                            ?>
                            <div class="product" onclick="window.location.href='book.php?tensach=<?php echo urlencode($items->tensach); ?>';">
                                <div class="image-container">
                                    <img style="width: 300px; height: 300px;" src="./img/<?php echo $items->img ?>">
                                    <!-- Chỉ hiển thị nếu có khuyến mãi -->
                                    <?php if ($discount > 0): ?>
                                        <span class="ptkm"><?php echo $discount; ?>%</span>
                                    <?php endif; ?>
                                </div>
                                <h2><?php echo htmlspecialchars($items->loaisach); ?></h2>
                                <h2><?php echo htmlspecialchars($items->tensach); ?></h2>
                                <?php if ($discount > 0): ?>
                                    <!-- Hiển thị giá gốc với dấu gạch ngang và giá sau khuyến mãi -->
                                    <h2 class="old-price"><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                                    <h2>Giá sau khuyến mãi: <?php echo number_format($priceWithDiscount, 0, ',', '.'); ?> VNĐ</h2>
                                <?php else: ?>
                                    <!-- Nếu không có khuyến mãi, chỉ hiển thị giá bán bình thường -->
                                    <h2><?php echo number_format($items->giaban, 0, ',', '.'); ?> VNĐ</h2>
                                <?php endif; ?>
                                <h1><?php echo Danhgia::renderStarRating($rate); ?></h1>
                            </div>
                            <?php
                        }
                    }

                    // Phần xử lý lọc và hiển thị sản phẩm
                    if ($bookname != NULL) {
                        if ($booktitle == NULL && $maxPrice == NULL && $minPrice == NULL) {
                            $dss = sach::GetAll();
                        } elseif ($booktitle != NULL && $maxPrice == NULL && $minPrice == NULL) {
                            $dss = sach::Getsachfromloaisach($booktitle);
                        } elseif ($maxPrice == NULL && $minPrice != NULL) {
                            $dss = sach::Get_less_price($minPrice);
                        } elseif ($booktitle != NULL && $maxPrice != NULL && $minPrice == NULL) {
                            $dss = sach::Get_over_price($maxPrice, $booktitle);
                        } elseif ($booktitle != NULL && $minPrice != NULL) {
                            $dss = sach::Get_less_price_and_loaisach($minPrice, $booktitle);
                        } elseif ($maxPrice != NULL && $minPrice != NULL) {
                            $dss = sach::Get_between_price($minPrice, $maxPrice);
                        } elseif ($booktitle != NULL && $maxPrice != NULL && $minPrice != NULL) {
                            $dss = sach::Get_between_price_and_loaisach($minPrice, $maxPrice, $booktitle);
                        }

                        foreach ($dss as $items) {
                            $rate = Danhgia::starrate($items->masach);
                            displayProduct($items, $rate, $keywords, $bookname);
                        }
                    }
                ?>
            </div>
    </main>
    <div class="modal signup-login">
    <div class="modal-container">
        <button class="form-close" onclick="closeModal()"><i class="fa-regular fa-xmark"></i></button>
        <div class="forms mdl-cnt">
            <div class="form-content sign-up">
                <h3 class="form-title">Đăng ký tài khoản</h3>
                <form class="signup-form" action="giaodienkh.php?action=2" method="post">
                    <div class="form-group">
                        <label for="fullname" class="form-label">Email</label>
                        <input id="fullname" name="user" type="text" placeholder="Nhập Email" class="form-control">
                        <span class="form-message-name form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input id="passwordR" name="password" type="password" placeholder="Nhập mật khẩu" class="form-control">
                        <span class="form-message-password form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="re-password" class="form-label">Xác nhận mật khẩu</label>
                        <input id="re-password" name="rePassword" type="password" placeholder="Xác nhận mật khẩu" class="form-control">
                        <span class="form-message-password-confi form-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="tenkh" class="form-label">Tên khách hàng</label>
                        <input id="tenkh" name="tenkh" type="text" placeholder="Tên khách hàng" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="dckh" class="form-label">Địa chỉ</label>
                        <input id="dckh" name="dckh" type="text" placeholder="Địa chỉ" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="sdt" class="form-label">Số điện thoại</label>
                        <input id="sdt" name="sdt" type="text" placeholder="Số điện thoại" class="form-control">
                    </div>
                    <button class="form-submit" id="signup-button">Đăng ký</button>
                </form>
                <p class="change-login">Bạn đã có tài khoản? <a href="javascript:;" class="login-link">Đăng nhập ngay</a></p>
            </div>
            <div class="form-content login">
                <h3 class="form-title">Đăng nhập tài khoản</h3>
                <form class="login-form" action="giaodienkh.php?action=1" method="post">
                    <div class="form-group">
                        <label for="phone-login" class="form-label">Tên tài khoản</label>
                        <input id="phone-login" name="user" type="text" placeholder="Nhập username" class="form-control">
                        <span class="form-message phonelog"></span>
                    </div>
                    <div class="form-group">
                        <label for="password-login" class="form-label">Mật khẩu</label>
                        <input id="password-login" name="password" type="password" placeholder="Nhập mật khẩu" class="form-control">
                        <span class="form-message-check-login form-message"></span>
                    </div>
                    <button class="form-submit" id="login-button">Đăng nhập</button>
                </form>
                <p class="change-login">Bạn chưa có tài khoản? <a href="javascript:;" class="signup-link">Đăng ký ngay</a><br>
                <a href="quenmatkhau.php" class="">Quên mật khẩu</a></p>
            </div>
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
                require_once("classkhuyenmai.php");
                // Lấy tất cả khuyến mãi
                $dsKhuyenMai = Khuyenmai::GetPTKM();
                $khuyenMaiMap = [];
                if (!empty($dsKhuyenMai)) { // Kiểm tra $dsKhuyenMai có hợp lệ trước khi lặp
                    foreach ($dsKhuyenMai as $km) {
                        $khuyenMaiMap[$km->masach] = $km->ptkm;
                    }
                }
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
    <script src="giaodienkh.js?v=<?php echo time() ?>"></script>
    <script>  
        let currentSlide = 0;
        const slides = document.querySelectorAll('.home-slider img');

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            slides[index].classList.add('active');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        setInterval(nextSlide, 4000); 
        showSlide(currentSlide); 

        document.querySelector('.prev-slide').addEventListener('click', prevSlide);
        document.querySelector('.next-slide').addEventListener('click', nextSlide);

       // Hàm kiểm tra email hợp lệ
function validateEmail(email) {
    const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return regex.test(email);
}

// Hàm kiểm tra khi submit form đăng ký
document.querySelector("form[action='giaodienkh.php?action=2']").addEventListener("submit", function(event) {
    const email = document.getElementById("fullname").value;  // Đổi từ "usernameR" thành "fullname"

    if (!validateEmail(email)) {
        alert("Vui lòng nhập địa chỉ email hợp lệ.");
        event.preventDefault(); // Ngừng submit form nếu email không hợp lệ
    }
});


        </script>
</body>
</html>