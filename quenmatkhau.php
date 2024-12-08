<?php
    session_start();  // Đảm bảo session đã được bắt đầu
    // Gửi email chứa mã xác minh
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
    require_once("connection.php");
    require_once("classtaikhoan.php");
    $donhangtitle = $_GET['title'] ?? null;
    $minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : '';
    $maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : '';
    require_once("classsach.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $conn = DBConnection::Connect();
    // Giả sử bạn có bảng `users` với trường `email`
    $stmt = $conn->prepare("SELECT * FROM tbtaikhoan WHERE USERNAME = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Gửi email xác minh và chuyển hướng đến trang nhập mã xác minh
        $_SESSION['reset_email'] = $email; // Lưu email vào session

        // Mã xác minh (có thể sử dụng một mã ngẫu nhiên)
        $verificationCode = rand(100000, 999999);
        $_SESSION['verification_code'] = $verificationCode;

    

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nhasachminhanh12@gmail.com';
            $mail->Password = 'exnv rkxs uciw hskv';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('nhasachminhanh12@gmail.com', 'Nhà sách Minh Anh');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Mã xác minh đặt lại mật khẩu';
            $mail->Body = "Mã xác minh của bạn là: <b>$verificationCode</b>";
            $mail->send();

            // Chuyển hướng đến trang nhập mã xác minh
            header("Location: nhapmaxacminh.php");
        } catch (Exception $e) {
            echo "Không thể gửi email: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Email không tồn tại!');</script>";
    }
}
?>

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
    <link rel="stylesheet" href="khquanlydonhang.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="./assets/css/home-responsive.css">
    <link rel="stylesheet" href="./assets/css/admin-responsive.css">
    <link rel="stylesheet" href="./assets/css/toast-message.css">
    <link rel="stylesheet" href="./assets/css/gioithieu.css">
    <link rel="stylesheet" href="./assets/font/font-awesome-pro-v6-6.2.0/css/all.min.css"/>
<style>


.main-wrapper {
    max-width: 500px;
    margin: 100px auto 30px auto; /* Căn giữa phần tử */
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Thêm bóng đổ để phần tử nổi bật */
    border-radius: 10px; /* Góc bo tròn */
    text-align: center; /* Căn giữa các phần tử bên trong */
}

.main-wrapper h1 {
    font-size: 28px;
    color: red;
    margin-bottom: 20px;
    font-weight: bold; /* Làm đậm tiêu đề */
}

.main-wrapper form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.main-wrapper input[type="password"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
}

.main-wrapper input[type="submit"] {
    padding: 10px;
    font-size: 16px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.main-wrapper input[type="submit"]:hover {
    background-color: #0056b3;
}


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
        <div>
            <h1>Nhập Email để đặt lại mật khẩu</h1>
            <form action="quenmatkhau.php" method="POST">
                <label for="email">Email của bạn:</label>
                <input type="email" id="email" name="email" placeholder="Nhập email" required>
                <input type="submit" value="Gửi mã xác minh">
            </form>
        </div>
    </main>

    <div class="modal product-detail">
        <button class="modal-close close-popup"><i class="fa-thin fa-xmark"></i></button>
        <div class="modal-container mdl-cnt" id="product-detail-content">
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
    
    <script src="./js/initialization.js"></script>
    <script src="./js/main.js"></script>
    <script src="./js/checkout.js"></script>
    <script src="./js/checkorder.js"></script>
    <script src="./js/toast-message.js"></script>
    <script src="giaodienkh.js?v=<?php echo time() ?>"></script>

</body>
</html>

