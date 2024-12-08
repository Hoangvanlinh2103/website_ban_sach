<?php

session_start();
$username = "";
if(isset($_SESSION["ma"])){
    $username = $_SESSION["ma"];
}
$isAdmin = $username == "Admin";  // Kiểm tra xem user có phải là Admin không
require_once("classchamcong.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy mã nhân viên từ form
    $manv = $_POST['manv']; // Mảng chứa mã nhân viên
    $date = $_POST['date']; // Ngày chấm công
    $start_hour = (int)$_POST['start-hour']; // Giờ bắt đầu
    $start_minute = (int)$_POST['start-minute']; // Phút bắt đầu
    $end_hour = (int)$_POST['end-hour']; // Giờ kết thúc
    $end_minute = (int)$_POST['end-minute']; // Phút kết thúc

    // Tạo thời gian bắt đầu và kết thúc
    // Đảm bảo thời gian được định dạng chính xác
    $start_time = sprintf("%02d:%02d:%02d", $start_hour, $start_minute, 0); // Giờ bắt đầu
    $end_time = sprintf("%02d:%02d:%02d", $end_hour, $end_minute, 0); // Giờ kết thúc
    // Lặp qua từng mã nhân viên để thêm chấm công
    foreach ($manv as $nv) {
        // Tạo đối tượng Chamcong với các thông tin cần thiết
        $cc = new Chamcong($nv, $date, $start_time, $end_time, 0, 0);
        
        // Thêm chấm công vào cơ sở dữ liệu
        Chamcong::Add($cc);

        require_once("classluong.php");
        Luong::Add($nv);
    }

    // Chuyển hướng về trang chấm công sau khi thực hiện
    header('Location: admin.php?name=chamcong');
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="chamcong.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
    <aside>
            <div class="top">
                <div class="logo">
                    <img src="./anh/logo.png">
                    <h2>Nhà sách <span class="danger">Minh Anh</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="admin.php?name=trangchu" class="active" id="trangchu" style="margin-top: 20px;">
                    <span class="material-icons">home</span>
                    <h3>Trang Chủ</h3>
                </a>
                <a href="admin.php?name=taikhoan" id="taikhoan" <?php echo !$isAdmin ? 'style="display:none;"' : ''; ?>>
                    <span class="material-icons">manage_accounts</span>
                    <h3>Tài Khoản</h3>
                    <?php
                        require_once("classtaikhoan.php");
                        $sltk = Taikhoan::soluongtaikhoan();
                    ?>
                    <span class="tongsoluong"><?php echo$sltk ?></span>
                </a>
                <a href="admin.php?name=nxb" id="nxb" <?php echo !$isAdmin ? 'style="display:none;"' : ''; ?>>
                    <span class="material-icons"><i class="bi bi-building-fill-check"></i></span>
                    <h3>Nhà Xuất Bản</h3>
                    <?php
                        require_once("classnxb.php");
                        $sltk = NXB::soluongnxb();
                    ?>
                    <span class="tongsoluong"><?php echo$sltk ?></span>
                </a>
                <a class="menu-item" id="nhanvien" onclick="toggleSubmenu(this)" <?php echo !$isAdmin ? 'style="display:none;"' : ''; ?>>
                    <span class="material-icons">groups</span>
                    <h3>Quản Lý Nhân Viên</h3>
                </a>
                <div class="submenu">
                    <a class="submenu-item" href="chamcong.php"><span class="material-icons">check_circle</span>Chấm Công</a>
                    <a class="submenu-item" href="admin.php?name=chamcong"><span class="material-icons">view_list</span>Bảng Chấm Công</a>
                    <a class="submenu-item" href="admin.php?name=luong"><span class="material-icons">attach_money</span>Bảng Lương</a>
                    <a class="submenu-item" href="admin.php?name=nhanvien" id="nhanvien">
                        <span class="material-icons">person</span>
                        <h3>Nhân Viên</h3>
                        <?php
                            require_once("classnhanvien.php");
                            $slnv = Nhanvien::soluongnhanvien();
                        ?>
                        <span class="tongsoluong"><?php echo$slnv ?></span>
                    </a>
                </div>
                <a href="admin.php?name=khachhang" id="khachhang">
                    <span class="material-icons">person_outline</span>
                    <h3>Khách Hàng</h3>
                    <?php
                        require_once("classkhachhang.php");
                        $slkh = Khachhang::soluongkhachhang();
                    ?>
                    <span class="tongsoluong"><?php echo$slkh ?></span>
                </a>
                <a href="admin.php?name=sach" id="sach" <?php echo !$isAdmin ? 'style="display:none;"' : ''; ?>>
                    <span class="material-icons"><i class="bi bi-book"></i></span>
                    <h3>Sách</h3>
                    <?php
                        require_once("classsach.php");
                        $slsp = sach::soluongsach();
                    ?>
                    <span class="tongsoluong"><?php echo$slsp ?></span>
                </a>
                <a class="menu-item" id="donhang" onclick="toggleSubmenu(this)">
                    <span class="material-icons">rate_review</span>
                    <h3>Đơn Hàng</h3>
                </a>
                <div class="submenu">
                    <a class="submenu-item" href="admin.php?name=dathang"><span class="material-icons">shopping_cart</span>Đơn đặt hàng</a>
                    <a class="submenu-item" href="admin.php?name=donhangxuat"><span class="material-icons">local_shipping</span>Đơn hàng xuất</a>
                    <a class="submenu-item" href="admin.php?name=donhangnhap"><span class="material-icons">inventory</span>Đơn hàng nhập</a>
                </div>
                <a href="admin.php?name=khuyenmai" id="khuyenmai" <?php echo !$isAdmin ? 'style="display:none;"' : ''; ?>>
                    <span class="material-icons">insights</span>
                    <h3>Khuyến mãi</h3>
                </a>
                <a  class="menu-item" id="thanhtoan" onclick="toggleSubmenu(this)">
                    <span class="material-icons"><i class="bi bi-credit-card-2-back"></i></span>
                    <h3>Lịch sử giao dịch</h3>
                </a>
                <div class="submenu">
                    <a class="submenu-item" href="admin.php?name=gdbanhang"><span class="material-icons">sell</span>Giao dịch bán hàng</a>
                    <a class="submenu-item" href="admin.php?name=gdnhaphang"><span class="material-icons">inventory_2</span>Giao dịch nhập hàng</a>
                </div>
                <a  class="menu-item" id="thongke" onclick="toggleSubmenu(this)">
                    <span class="material-icons">receipt_long</span>
                    <h3>Thống Kê</h3>
                </a>
                <div class="submenu">
                    <a class="submenu-item" id="tkdoanhthu" href="admin.php?name=tktienbieudo" <?php echo !$isAdmin ? 'style="display:none;"' : ''; ?>>
                        <span class="material-icons">bar_chart</span>Thống kê doanh thu
                    </a>
                    <a class="submenu-item" href="admin.php?name=tkbanchay"><span class="material-icons">trending_up</span>Thống kê sách bán chạy</a>
                    <a class="submenu-item" href="admin.php?name=tksachsaphet"><span class="material-icons">alarm</span>Thống kê sách sắp hết    </a>
                    <a class="submenu-item" href="admin.php?name=tksachkhuyenmai"><span class="material-icons">local_offer</span>Thống kê sách khuyến mãi</a>
                </div>
                <a href="dangxuat.php?action=2">
                    <span class="material-icons">logout</span>
                    <h3>Đăng Xuất</h3>
                </a>
            </div>
        </aside>
        <!-------------END OF ASIDE------------>
        
        <div id="dschamcong">
            <h1>Chấm Công Nhân Viên</h1>
            <form id="chamcong-form" action="chamcong.php" method="POST">
                <?php 
                require_once("classnhanvien.php");
                $dsmanv = Nhanvien::GetManv();
                foreach($dsmanv as $itemnv){
                ?>
                <div class="form-group">
                    <label for="manv">Nhân Viên</label>
                    <label>
                        <input type="checkbox" name="manv[]" value="<?php echo $itemnv['MANV']; ?>"> 
                        <?php echo $itemnv['TENNV']; ?> (<?php echo $itemnv['MANV']; ?>)
                    </label>
                </div>
                <?php } ?>
                
                <div class="form-group">
                    <label for="date">Chọn Ngày</label>
                    <input type="date" name="date" id="date" required>
                </div>
                
                <div class="form-group">
                    <label for="tgbd">Thời Gian Bắt Đầu</label>
                    <select name="start-hour" required>
                        <option value="" disabled selected>Giờ</option>
                        <script>
                            for (let i = 0; i < 24; i++) {
                                document.write(`<option value="${i}">${i < 10 ? '0' + i : i}</option>`);
                            }
                        </script>
                    </select>
                    <select name="start-minute" required>
                        <option value="" disabled selected>Phút</option>
                        <script>
                            for (let i = 0; i < 60; i++) {
                                document.write(`<option value="${i}">${i < 10 ? '0' + i : i}</option>`);
                            }
                        </script>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tgkt">Thời Gian Kết Thúc</label>
                    <select name="end-hour" required>
                        <option value="" disabled selected>Giờ</option>
                        <script>
                            for (let i = 0; i < 24; i++) {
                                document.write(`<option value="${i}">${i < 10 ? '0' + i : i}</option>`);
                            }
                        </script>
                    </select>
                    <select name="end-minute" required>
                        <option value="" disabled selected>Phút</option>
                        <script>
                            for (let i = 0; i < 60; i++) {
                                document.write(`<option value="${i}">${i < 10 ? '0' + i : i}</option>`);
                            }
                        </script>
                    </select>
                </div>
                
                <button type="submit">Chấm Công</button>
            </form>
        </div>
    </div>
</body>
<script src="admin.js?v=<?php echo time(); ?>"></script>
</html>
