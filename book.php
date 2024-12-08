<?php
session_start();
require_once("classtaikhoan.php");
$booktitle = isset($_GET['name']) ? $_GET['name'] : '';
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
            } else {
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
require_once("classsach.php");
?>
<html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Shop</title>
    <link href='./assets/img/iconlogo.jpg' rel='icon' type='image/x-icon' />
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="book.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="giaodienkh.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="./assets/css/home-responsive.css">
    <link rel="stylesheet" href="./assets/css/admin-responsive.css">
    <link rel="stylesheet" href="./assets/css/toast-message.css">
    <link rel="stylesheet" href="./assets/css/gioithieu.css">
    <link rel="stylesheet" href="./assets/font/font-awesome-pro-v6-6.2.0/css/all.min.css"/>



</style>
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
    <main class="main-wrapper">
        <div class="container" id="trangchu">
        <?php
            // Lấy tên sách từ URL
            if (isset($_GET['tensach'])) {
                $tensach = urldecode($_GET['tensach']);

                // Tìm thông tin sách trong cơ sở dữ liệu
                $sachList = sach::GetByName($tensach);
                $sach = $sachList[0];
                require_once("classdanhgia.php");
                $reviews = Danhgia::Getdanhgiasach($sach->masach);
                require_once("classkhuyenmai.php");
                // Lấy khuyến mãi
                $khuyenMai = Khuyenmai::GetPTKMtheoMSACH($sach->masach);
                // Tính giá sau khuyến mãi
                $priceWithDiscount = $sach->giaban * (1 - $khuyenMai / 100);
                if ($sach) { // Kiểm tra xem $sach có khác null không
                    echo "<div class='book-details'>";
                    echo "<div class='book-image'>";
                    echo "<img src='img/" . htmlspecialchars($sach->img) . "' alt='" . htmlspecialchars($sach->tensach) . "'>";
                    echo "</div>";
                    echo "<div class='book-info'>";
                    echo "<h1 id='tensach'>" . htmlspecialchars($sach->tensach) . "</h1>";
                    echo "<p>Tác giả: " . htmlspecialchars($sach->tacgia) . "</p>";
                    echo "<p>Loại sách: " . htmlspecialchars($sach->loaisach) . "</p>";
                    
                    // Hiển thị giá bán ban đầu và giá sau khuyến mãi
                    if ($khuyenMai > 0) { 
                        // Nếu có khuyến mãi
                        echo "<h2 class='old-price'>" . number_format($sach->giaban, 0, ',', '.') . " VNĐ</h2>";
                        echo "<span class='discount-info'> -" . $khuyenMai . "%</span>";
                        echo "<h2>Giá sau khuyến mãi: " . number_format($priceWithDiscount, 0, ',', '.') . " VNĐ</h2>";
                    } else { 
                        // Nếu không có khuyến mãi, chỉ hiển thị giá bán bình thường
                        echo "<h2>" . number_format($sach->giaban, 0, ',', '.') . " VNĐ</h2>";
                    }

                    echo "<p>Mô tả: " . htmlspecialchars($sach->mota) . "</p>";
                    
                    // Thêm input cho số lượng
                    echo "<label for='soluong'>Số lượng:</label>";
                    echo "<input type='number' id='soluong' name='quantity' value='1' min='1' max='" . htmlspecialchars($sach->soluong) . "' class='quantity-input'>";

                    // Thêm hai nút
                    echo "<div class='button-group'>";
                    // Kiểm tra nếu người dùng đã đăng nhập
                    if (isset($_SESSION["makh"])) {
                        // Kiểm tra số lượng sách
                        if ($sach->soluong == 0) {
                            echo "<button class='btn' disabled>Hết hàng</button>"; // Nút bị vô hiệu hóa nếu số lượng là 0
                        } else {
                            // Nếu có đủ số lượng, hiển thị nút "Thêm vào giỏ hàng"
                            echo "<button class='btn' onclick='addToCart(\"" . $sach->masach . "\")'>Thêm vào giỏ hàng</button>";
                        }

                        // Nút trở về
                        echo "<button class='btn' onclick='window.location.href=\"giaodienkh.php\"'>Quay lại</button>";

                        // Hiển thị nút đánh giá sách
                        echo "<button class='btn' id='toggle-rating-btn'>Đánh giá sách</button>";

                    } else {
                        // Nếu người dùng chưa đăng nhập, yêu cầu đăng nhập để đánh giá sách và thêm vào giỏ hàng
                        echo "<h3 class='warning' style='color:red;'>Bạn cần đăng nhập để đánh giá sách hoặc thêm vào giỏ hàng.</h3>";
                        // Hiển thị nút "Quay lại" nếu chưa đăng nhập
                        echo "<button class='btn' onclick='window.location.href=\"giaodienkh.php\"'>Quay lại</button>";
                    }
                    echo "</div>";
                    echo "</div>";
                }
            }
        ?>
        </div>
        <div>
                <!-- Rating and Review Section (initially hidden) -->
                <div id="rating-section" style="display: none;">
                    <div class="star-rating">
                        <!-- Create 5 stars using Unicode star character -->
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>
                    
                    <!-- Textbox for review content -->
                    <textarea id="review-content" placeholder="Viết nội dung đánh giá của bạn ở đây..."></textarea>
                    
                    <!-- Submit button for the review -->
                    <button class='btn-review' onclick="submitReview()">Gửi đánh giá</button>
                </div>
                <div class="filter-container">
    <label for="star-filter">Lọc theo số sao:</label>
    <select id="star-filter" name="star-filter">
        <option value="">Tất cả</option>
        <option value="1">1 Sao</option>
        <option value="2">2 Sao</option>
        <option value="3">3 Sao</option>
        <option value="4">4 Sao</option>
        <option value="5">5 Sao</option>
    </select>
</div>

    <div id="reviews-container">
    <?php
    if (is_array($reviews) || is_object($reviews)) {
        if (count($reviews) > 0) {
            foreach ($reviews as $review) {
                echo "<div class='review' data-star='" . htmlspecialchars($review->diemdanhgia) . "'>";
                echo "<div class='review-info'>";
                echo "<span class='date'>" . htmlspecialchars($review->ngay) . "</span>";
                echo "<span class='customer-id'>" . htmlspecialchars($review->makh) . "</span>";
                echo "<span class='rating'>Đánh giá: " . htmlspecialchars($review->diemdanhgia) . "/5</span>";
                echo "</div>";
                echo "<p>Nội dung: " . htmlspecialchars($review->noidung) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Chưa có đánh giá nào cho sách này.</p>";
        }
    }
    ?>
</div>
        </div>

    </main>    <div class="modal product-detail">
        <button class="modal-close close-popup"><i class="fa-thin fa-xmark"></i></button>
        <div class="modal-container mdl-cnt" id="product-detail-content">
        </div>
    </div>
  
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
    
    <script src="./js/initialization.js"></script>
    <script src="./js/main.js"></script>
    <script src="./js/checkout.js"></script>
    <script src="./js/checkorder.js"></script>
    <script src="./js/toast-message.js"></script>
    <script src="giaodienkh.js?v=<?php echo time() ?>"></script>

</body>
<script>
function addToCart(masach) {

const soluong = document.getElementById("soluong").value; // Lấy số lượng từ input
const makh = "KH001"; // Giả sử mã khách hàng là KH001 (thay bằng mã khách hàng thật sự)
<?php
    $sachList = sach::GetByName($tensach);
    $sach = $sachList[0];
?>
const tensach ="<?php echo urlencode($sach->tensach); ?>";

// Start constructing the URL with the base URL
let url = "addtocart.php?";

url += `masach=${masach}`;
url += `&tensach=${tensach}`;
url += `&makh=${makh}`;
url += `&soluong=${soluong}`;

    // Redirect to the constructed URL
window.location.href = url;
}

document.getElementById("soluong").addEventListener("change", function() {
    var quantityInput = document.getElementById("soluong");
    var maxQuantity = parseInt(quantityInput.max);
    var minQuantity = parseInt(quantityInput.min);
    var lastValidValue = minQuantity; // Lưu giá trị hợp lệ cuối cùng

    if (quantityInput.value < minQuantity || quantityInput.value > maxQuantity) {
        alert("Giá trị nhập không hợp lệ! Số lượng phải từ " + minQuantity + " đến " + maxQuantity + ".");
        quantityInput.value = lastValidValue; // Đặt lại giá trị hợp lệ cuối
    } else {
        lastValidValue = currentValue; // Cập nhật giá trị hợp lệ cuối cùng
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var quantityInput = document.getElementById("soluong");
    var addToCartButton = document.querySelector(".btn[onclick^='addToCart']");

    // Hàm kiểm tra và cập nhật trạng thái của nút
    function updateButtonState() {
        addToCartButton.disabled = quantityInput.value == 0;
    }

    // Kiểm tra khi trang tải xong và khi thay đổi số lượng
    updateButtonState();
    quantityInput.addEventListener("input", updateButtonState);
});

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
</html>
