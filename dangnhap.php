<?php
// Bắt đầu phiên làm việc (session) để lưu trữ thông tin người dùng
session_start();

// Import lớp xử lý tài khoản
require_once("classtaikhoan.php");

// Lấy tham số 'action' từ URL, dùng để phân biệt đăng nhập (1) hoặc đăng ký (2)
$action = isset($_GET["action"]) ? $_GET["action"] : 0;

// ========================== XỬ LÝ FORM ==========================
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Kiểm tra nếu phương thức gửi dữ liệu là POST
    // Nhánh xử lý đăng nhập
    if ($action == 1) {
        $user = $_POST['user'];          // Lấy tên đăng nhập từ form
        $password = $_POST['password']; // Lấy mật khẩu từ form

        // Gọi hàm kiểm tra tài khoản trong lớp Taikhoan
        $taikhoan = Taikhoan::dangnhap($user, $password);

        if ($taikhoan) { // Nếu tài khoản tồn tại
            if ($taikhoan->thanphan == "admin") {
                // Nếu là Admin
                $_SESSION["ma"] = "Admin";                    // Lưu quyền là Admin
                $_SESSION["manv"] = Taikhoan::GetManv($user); // Lấy mã nhân viên
                header("Location: admin.php");               // Chuyển hướng đến trang Admin
            } elseif ($taikhoan->thanphan == "Nhân Viên") {
                // Nếu là Nhân Viên
                $_SESSION["ma"] = "Nhân Viên";                // Lưu quyền là Nhân Viên
                $_SESSION["manv"] = Taikhoan::GetManv($user); // Lấy mã nhân viên
                header("Location: admin.php");               // Chuyển hướng đến trang Admin
            } else {
                // Nếu là Khách Hàng
                $_SESSION["makh"] = Taikhoan::GetMakh($user); // Lưu mã khách hàng
                header("Location: giaodienkh.php");          // Chuyển hướng đến giao diện khách hàng
            }
        } else {
            // Hiển thị thông báo nếu đăng nhập thất bại
            echo "<script>alert('Tên đăng nhập hoặc mật khẩu không chính xác!');</script>";
        }
    }

    // Nhánh xử lý đăng ký
    if ($action == 2) {
        $user = $_POST['user'];             // Lấy tên đăng nhập từ form
        $password = $_POST['password'];     // Lấy mật khẩu từ form
        $repassword = $_POST['rePassword']; // Lấy xác nhận mật khẩu
        $tenkh = $_POST['tenkh'];           // Lấy tên khách hàng
        $dckh = $_POST['dckh'];             // Lấy địa chỉ khách hàng
        $sdt = $_POST['sdt'];               // Lấy số điện thoại khách hàng

        if ($password !== $repassword) {
            // Kiểm tra nếu mật khẩu và xác nhận không khớp
            echo "<script>alert('Hai mật khẩu không giống nhau!');</script>";
        } else {
            // Gọi hàm đăng ký để thêm tài khoản mới vào hệ thống
            $result = Taikhoan::dangky($user, $password, $tenkh, $dckh, $sdt);
            if ($result) {
                echo "<script>alert('Đăng ký thành công!');</script>";
            } else {
                echo "<script>alert('Đăng ký thất bại! Vui lòng thử lại.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập/Đăng ký tài khoản</title>

    <!-- Liên kết FontAwesome để sử dụng icon -->
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.css">
    <!-- Liên kết file CSS với tham số thời gian để tránh lỗi cache -->
    <link rel="stylesheet" href="dangnhap.css?v=<?php echo time(); ?>">
</head>
<body>
    <section class="page">
        <!-- Phần hình ảnh -->
        <section class="image-container"></section>
        
        <!-- Phần nội dung -->
        <section class="content">
            <!-- Form đăng nhập -->
            <section id="login-form" class="auth">
                <section class="auth__header">
                    <h2>Đăng nhập</h2>
                    <!-- Nút chuyển sang form đăng ký -->
                    <span id="switch-btn1" class="switch-btn">Đăng ký</span>
                </section>
                <form class="auth__form" action="dangnhap.php?action=1" method="post">
                    <section class="form-control">
                        <label for="usernameL">Tên đăng nhập</label>
                        <input type="text" id="usernameL" name="user" placeholder="Nhập tên đăng nhập" required>
                    </section>
                    <section class="form-control">
                        <label for="passwordL">Mật khẩu</label>
                        <input type="password" id="passwordL" name="password" placeholder="Nhập mật khẩu" required>
                    </section>
                    <input type="submit" value="Đăng nhập">
                    <a href="quenmatkhau.php">Quên mật khẩu?</a>
                </form>
            </section>

            <!-- Form đăng ký -->
            <section id="reg-form" class="auth">
                <section class="auth__header">
                    <h2>Đăng ký</h2>
                    <!-- Nút chuyển sang form đăng nhập -->
                    <span id="switch-btn2" class="switch-btn">Đăng nhập</span>
                </section>
                <form class="auth__form" action="dangnhap.php?action=2" method="post">
                    <section class="form-control">
                        <label for="usernameR">Tên đăng nhập</label>
                        <input type="text" id="usernameR" name="user" placeholder="Nhập email" required>
                    </section>
                    <section class="form-control">
                        <label for="passwordR">Mật khẩu</label>
                        <input type="password" id="passwordR" name="password" placeholder="Nhập mật khẩu" required>
                    </section>
                    <section class="form-control">
                        <label for="re-password">Xác nhận mật khẩu</label>
                        <input type="password" id="re-password" name="rePassword" placeholder="Nhập lại mật khẩu" required>
                    </section>
                    <section class="form-control">
                        <label for="tenkh">Tên khách hàng</label>
                        <input type="text" id="tenkh" name="tenkh" placeholder="Nhập tên của bạn" required>
                    </section>
                    <section class="form-control">
                        <label for="dckh">Địa chỉ</label>
                        <input type="text" id="diachi" name="dckh" placeholder="Nhập địa chỉ" required>
                    </section>
                    <section class="form-control">
                        <label for="sdt">Số điện thoại</label>
                        <input type="text" id="sdt" name="sdt" placeholder="Nhập số điện thoại" required>
                    </section>
                    <button class="auth_btn" type="submit">Đăng ký</button>
                </form>
            </section>
        </section>
    </section>
    <!-- Liên kết file JavaScript -->
    <script src="dangnhap.js?v=<?php echo time(); ?>"></script>
</body>
</html>
