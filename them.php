<?php
     session_start();
     $username = "";
     if(isset($_SESSION["ma"])){
         $username = $_SESSION["ma"];
     }
     $isAdmin = $username == "Admin";  // Kiểm tra xem user có phải là Admin không
    $madhx = isset($_GET["madhx"]) ? $_GET["madhx"] : "";
    $madhn = isset($_GET["madhn"]) ? $_GET["madhn"] : "";

    require_once("classsach.php");
    $dssach = sach::GetAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href = "them.css?v=<?php echo time(); ?>">
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
        <main>
            <h1>Ngày</h1>
            <div class="date">
                <input type="date" id="currentDate">
            </div>
            <div class="right">
                <div class="top">
                    <button id="menu-btn">
                        <span class="material-icons">menu</span>
                    </button>
                    <div class="theme-toggler">
                        <span class="material-icons active">light_mode</span>
                        <span class="material-icons">dark_mode</span>
                    </div>
                    <div class="profile">
                        <div class="info">
                            <p>Xin Chào</p>
                            <small class="text-muted"><?php echo $username; ?></small>
                        </div>
                        <div class="profile-photo">
                            <img src="./anh/anh1.jpg">
                        </div>
                    </div>
                </div>
            </div>
            <div id="dstaikhoan">
                <h2>Thêm Tài Khoản</h2>
                <form action="admin.php?tieude=taikhoan&action=1" method="POST">
                    <div class="form-group">
                        <label for="username">User</label>
                        <input type="text" id="user" name="user" placeholder="Nhập tên tài khoản" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                    </div>
                    <div class="form-group">
                        <label for="manv">Mã Nhân Viên</label>
                        <input type="text" id="manv" name="manv" placeholder="Nhập mã nhân viên" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Thêm">
                    </div>
                    <a href="admin.php?name=taikhoan" class="quaylai">Quay Lại</a>
                </form>
            </div>
            <!-------------------------------END OF TAI KHOAN------------------------------>
            <div id="dsnxb">
                <h2>Thêm Nhà Xuất Bản</h2>
                <form action="admin.php?tieude=nxb&action=1" method="POST">
                    <div class="form-group">
                        <label for="username">Tên NXB</label>
                        <input type="text" id="user" name="tennxb" placeholder="Nhập tên NXB" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Địa Chỉ</label>
                        <input type="text" id="dcnxb" name="dcnxb" placeholder="Nhập địa chỉ NXB" required>
                    </div>
                    <div class="form-group">
                        <label for="manv">SĐT</label>
                        <input type="text" id="sdt" name="sdt" placeholder="Nhập số điện thoại NXB" required>
                    </div>
                    <div class="form-group">
                        <label for="manv">Email</label>
                        <input type="text" id="email" name="email" placeholder="Nhập email NXB" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Thêm">
                    </div>
                    <a href="admin.php?name=nxb" class="quaylai">Quay Lại</a>
                </form>
            </div>
            <!-------------------------------END OF NXB------------------------------>
            <div id="dsnhanvien">
                <h2>Thêm Nhân Viên</h2>
                <form action="admin.php?tieude=nhanvien&action=1" method="POST">
                    <div class="form-group">
                        <label >Họ Và Tên</label>
                        <input type="text" name="tennv" placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text"  name="dcnv" placeholder="Nhập địa chỉ" required>
                    </div>
                    <div class="form-group">
                        <label>Số Điện Thoại</label>
                        <input type="text"  name="sdtnv" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <label>Chức Vụ</label>
                        <input type="text"  name="cvnv" placeholder="Nhập chức vụ" required>
                    </div>
                    <div class="form-group">
                        <label>Lương</label>
                        <input type="text"  name="luongnv" placeholder="Nhập lương" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Thêm">
                    </div>
                    <a href="admin.php?name=nhanvien" class="quaylai">Quay Lại</a>
                </form>
            </div>
            <!-------------------------------END OF NHAN VIEN------------------------------>
            <div id="dskhachhang">
                <h2>Thêm Khách Hàng</h2>
                <form action="admin.php?tieude=khachhang&action=1" method="POST">
                    <div class="form-group">
                        <label >Họ Và Tên</label>
                        <input type="text" name="tenkh" placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text"  name="dckh" placeholder="Nhập địa chỉ" required>
                    </div>
                    <div class="form-group">
                        <label>Số Điện Thoại</label>
                        <input type="text"  name="sdtkh" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Thêm">
                    </div>
                    <a href="admin.php?name=khachhang" class="quaylai">Quay Lại</a>
                </form>
            </div>
            <!-------------------------------END OF KHACH HANG------------------------------>
            <div id="dssach">
                <h2>Thêm Sách</h2>
                <form action="admin.php?tieude=sach&action=1" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label >Tên Sách</label>
                        <input type="text" name="tens" placeholder="Nhập tên sách" required>
                    </div>
                    <div class="form-group">
                        <label style="top:-20px;">Ảnh</label>
                        <input type="file"  name="img">
                    </div>
                    <div class="form-group">
                        <label>Loại Sách</label>
                        <input type="text"  name="loais" placeholder="Nhập loại sách" required>
                    </div>
                    <div class="form-group">
                        <label>Tác Giả</label>
                        <input type="text"  name="tg" placeholder="Nhập tên tác giả" required>
                    </div>
                    <div class="form-group">
                        <label>NXB</label>
                        <input type="text"  name="nxb" placeholder="Nhập mã NXB" required>
                    </div>
                    <div class="form-group">
                        <label >Số Lượng</label>
                        <input type="text" name="soluong" placeholder="Nhập số lượng sách đang có" required>
                    </div>
                    <div class="form-group">
                        <label>Giá Nhập</label>
                        <input type="text"  name="gianhap" placeholder="Nhập giá sách nhập về" required>
                    </div>
                    <div class="form-group">
                        <label>Giá Bán</label>
                        <input type="text"  name="giaban" placeholder="Nhập giá sách bán ra" required>
                    </div>
                    <div class="form-group">
                        <textarea style="height: 150px; width:100%;"  name="mota" placeholder="Nhập mô tả sách" required></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Thêm">
                    </div>
                    <a href="admin.php?name=sach" class="quaylai">Quay Lại</a>
                </form>
            </div>
            <!-------------------------------END OF SÁCH------------------------------>
            <div id="dsdonhangxuat">
                <h2>Thêm Đơn Hàng</h2>
                <form action="admin.php?tieude=donhangxuat&action=1" method="POST">
                    <div class="form-group">
                        <select name="tinhtrang" required>
                            <option value="">Chọn tình trạng</option>
                            <option value="Chưa xử lý">Chưa xử lý</option>
                            <option value="Đang xử lý">Đang xử lý</option>
                        </select>
                    </div>
                    <div id="product-container">
                        <div class="form-group product-item">
                            <label>Tên Sách</label>
                            <select name="mas[]" required>
                                <?php
                                            
                                foreach ($dssach as $sach): ?>
                                    <option value="<?php echo $sach->masach ?>"><?php echo $sach->tensach ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                           
                            <label>Số Lượng</label>
                            <input type="text" name="soluong[]" placeholder="Nhập số lượng" required>
                        </div>
                    </div>
                    <button type="button" id="add-product-btn">Thêm Sách</button>
                    <div class="form-group">
                        <input type="submit" value="Thêm">
                    </div>
                    <a href="admin.php?name=donhangxuat" class="quaylai">Quay Lại</a>
                </form>
            </div>
            <!-------------------------------END OF DON HÀNG------------------------------>
            <div id="dsthemDHCT">
                <h2>Thêm Đơn Hàng</h2>
                <form action="donhangchitiet.php?name=donhang&action=1&madhxuat=<?php echo $madhx ?>" method="POST">
                    <div class="form-group">
                        <label >Mã Đơn Hàng</label>
                        <input type="text" name="madhx" value="<?php echo $madhx ?>" readonly>
                    </div>
                    <div id="product-container">
                        <div class="form-group product-item">
                        <label>Tên Sách</label>
                            <select name="mas[]" required>
                                <?php
                                            
                                foreach ($dssach as $sach): ?>
                                    <option value="<?php echo $sach->masach ?>"><?php echo $sach->tensach ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <label>Số Lượng</label>
                            <input type="text" name="soluong[]" placeholder="Nhập số lượng" required>
                        </div>
                    </div>
                    <button type="button" id="add-product-btn">Thêm Sách</button>
                    <div class="form-group">
                        <input type="submit" value="Thêm">
                    </div>
                    <a href="donhangchitiet.php?name=donhang&madhx=<?php echo $madhx ?>" class="quaylai">Quay Lại</a>
                </form>
            </div>
            <!-------------------------------END OF DON HÀNG Xuất Chi Tiết------------------------------>
            <div id="dsdonhangnhap">
                <h2>Thêm Đơn Hàng Nhập</h2>
                <form action="admin.php?tieude=donhangnhap&action=1" method="POST">
                    <div class="form-group">
                        <label >Mã Nhà Cung Cấp</label>
                        <input type="text" name="manxb" placeholder="Nhập mã nhà cung cấp (Nếu có)">
                    </div>
                    <div class="form-group">
                        <select name="tinhtrang" required>
                            <option value="Chưa thanh toán">Chưa thanh toán</option>
                            <option value="Đã thanh toán">Đã thanh toán</option>
                        </select>
                    </div>
                    <div id="donhang_nhap-container">
                        <div class="form-group donhang_nhap-item">
                        <label>Tên Sách</label>
                            <select name="mas[]" required>
                                <?php
                                            
                                foreach ($dssach as $sach): ?>
                                    <option value="<?php echo $sach->masach ?>"><?php echo $sach->tensach ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <label>Số Lượng</label>
                            <input type="text" name="soluong[]" placeholder="Nhập số lượng" required>
                            <label>Giá Nhập</label>
                            <input type="text"  name="gianhap[]" placeholder="Giá mà cửa hàng nhập về" required>
                            <label>Ghi Chú</label>
                            <input type="text"  name="ghichu[]" placeholder="Nhập ghi chú về sách" value="Nhập hàng" required>
                        </div>
                    </div>
                    <button type="button" id="add-donhang_nhap-btn">Thêm Sách</button>
                    <div class="form-group">
                        <input type="submit" value="Thêm">
                    </div>
                    <a href="admin.php?name=donhangnhap" class="quaylai">Quay Lại</a>
                </form>
            </div>
            <!-------------------------------END OF HÓA ĐƠN NHẬP------------------------------>
            <div id="dsthemNhapDHCT">
                <h2>Thêm Đơn Hàng</h2>
                <form action="donhangchitiet.php?name=donhangnhap&action=1&madhnhap=<?php echo $madhn ?>" method="POST">
                    <div class="form-group">
                        <label >Mã Đơn Hàng</label>
                        <input type="text" name="madhn" value="<?php echo $madhn ?>" readonly>
                    </div>
                    <div id="donhang_nhap-container">
                        <div class="form-group donhang_nhap-item">
                        <label>Tên Sách</label>
                            <select name="mas[]" required>
                                <?php
                                            
                                foreach ($dssach as $sach): ?>
                                    <option value="<?php echo $sach->masach ?>"><?php echo $sach->tensach ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <label>Số Lượng</label>
                            <input type="text" name="soluong[]" placeholder="Nhập số lượng" required>
                            <label>Giá Nhập</label>
                            <input type="text"  name="gianhap[]" placeholder="Giá mà cửa hàng nhập về" required>
                            <label>Ghi Chú</label>
                            <input type="text"  name="ghichu[]" placeholder="Nhập ghi chú về sách" value="Nhập hàng" required>
                        </div>
                    </div>
                    <button type="button" id="add-donhang_nhap-btn">Thêm Sách</button>
                    <div class="form-group">
                        <input type="submit" value="Thêm">
                    </div>
                    <a href="donhangchitiet.php?name=donhangnhap&madhn=<?php echo $madhn ?>" class="quaylai">Quay Lại</a>
                </form>
            </div>
            <!-------------------------------END OF DON HÀNG Nhập Chi Tiết------------------------------>

            <div id="dskhuyenmai">
                <h2>Thêm Khuyến Mãi</h2>
                <form action="admin.php?tieude=khuyenmai&action=1" method="POST">
                    <div id="product-container">
                        <div class="form-group product-item">
                            <label>Tên Sự Kiện</label>
                            <input type="text" name="tensk" placeholder="Nhập tên sự kiện" required>
                            <label>Ngày Bắt Đầu</label>
                            <input type="date" name="ngaybatdau" required>
                            <label>Ngày Kết Thúc</label>
                            <input type="date" name="ngayketthuc" required>

                            <!-- Khuyến mãi tuỳ chọn -->
                            <div id="tuychonkhuyenmai">
                                <div id="product-tuychon-container">
                                    <div class="form-group product-item">
                                        <label for="">Chọn sách:</label>
                                        <select name="sachtuychon[]" required>
                                            <?php
                                            
                                            foreach ($dssach as $sach): ?>
                                                <option value="<?php echo $sach->masach ?>"><?php echo $sach->tensach ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                        <label for="">Phần trăm khuyến mãi:</label>
                                        <input type="number" name="ptkm_tuychon[]" min="0" max="100" required>
                                    </div>
                                </div>
                                <button type="button" id="add-sach-btn">Thêm sách</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Thêm">
                        </div>
                        <a href="admin.php?name=khuyenmai" class="quaylai">Quay Lại</a>
                </form>
            </div>
             <!-------------------------------END OF KHUYEN MAI------------------------------>
        </main>
         <!-------END OF MAIN--------->
    </div>
</body>
<script src="them.js?v=<?php echo time(); ?>"></script>
<script>
    // Mảng sách được tạo từ PHP
    const dssach = <?php echo json_encode($dssach); ?>;
</script>
</html>