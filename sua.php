<?php
     session_start();
     $username = "";
     if(isset($_SESSION["ma"])){
         $username = $_SESSION["ma"];
     }
     $isAdmin = $username == "Admin";  // Kiểm tra xem user có phải là Admin không
    $name = isset($_GET["name"]) ? $_GET["name"] :"";
    $user = ""; $manv = ""; $makh = ""; $masach = "";  $madhx = ""; $manxb = "";
    
    if ($name == "taikhoan") {
        $user = $_GET["user"];
    } elseif ($name == "nxb") {
        $manxb = $_GET["manxb"];
    }
    elseif ($name == "nhanvien") {
        $manv = $_GET["manv"];
    }elseif ($name == "khachhang") {
        $makh = $_GET["makh"]; 
    }
    elseif ($name == "sach") {
        $masach = $_GET["masach"]; 
    }
    elseif ($name == "donhangxuat") {
        $madhx = $_GET["madhx"]; 
        $masach = $_GET["masach"];
    }
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
                <h2>Sửa Tài Khoản</h2>
                <?php
                    require_once("classtaikhoan.php");
                    $dstk = Taikhoan::Get($user);
                    foreach($dstk as $itemtk){
                ?>
                <form action="admin.php?tieude=taikhoan&action=2" method="POST">
                    <div class="form-group">
                        <label for="username">User</label>
                        <input type="text" name="user" placeholder="Nhập tên tài khoản" value="<?php echo $itemtk->user ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text"  name="password" placeholder="Nhập mật khẩu" value="<?php echo $itemtk->password ?>" required>
                    </div>
                   
                    <div class="form-group">
                        <input type="submit" value="Sửa">
                    </div>
                    <a href="admin.php?name=taikhoan" class="quaylai">Quay Lại</a>
                </form>
                <?php
                        }
                    ?>
            </div>
            <!-------------------------------END OF TAI KHOAN------------------------------>
            <div id="dsnxb">
                <h2>Sửa Nhà Xuất Bản</h2>
                <?php
                    require_once("classnxb.php");
                    $dstk = NXB::Get($manxb);
                    foreach($dstk as $itemnxb){
                ?>
                <form action="admin.php?tieude=nxb&action=2" method="POST">
                    <div class="form-group">
                        <label for="username">Mã NXB</label>
                        <input type="text" id="user" name="manxb" value="<?php echo $itemnxb->manxb ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="username">Tên NXB</label>
                        <input type="text" id="user" name="tennxb" placeholder="Nhập tên NXB" value="<?php echo $itemnxb->tennxb ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Địa Chỉ</label>
                        <input type="text" id="dcnxb" name="dcnxb" placeholder="Nhập địa chỉ NXB" value="<?php echo $itemnxb->diachinxb ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="manv">SĐT</label>
                        <input type="text" id="sdt" name="sdt" placeholder="Nhập số điện thoại NXB" value="<?php echo $itemnxb->sdt ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="manv">Email</label>
                        <input type="text" id="email" name="email" placeholder="Nhập email NXB" value="<?php echo $itemnxb->email ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Sửa">
                    </div>
                    <a href="admin.php?name=nxb" class="quaylai">Quay Lại</a>
                </form>
                <?php
                        }
                    ?>
            </div>
            <!-------------------------------END OF TAI KHOAN------------------------------>
            <div id="dsnhanvien">
                <h2>Sửa Nhân Viên</h2>
                <?php
                    require_once("classnhanvien.php");
                    $dsnv = Nhanvien::Get($manv);
                    foreach($dsnv as $itemnv) {
                ?>
                <form action="admin.php?tieude=nhanvien&action=2" method="POST">
                    <div class="form-group">
                        <label >Mã Nhân Viên</label>
                        <input type="text" name="manv" value="<?php echo $itemnv->manv ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label >Họ Và Tên</label>
                        <input type="text" name="tennv" placeholder="Nhập họ và tên" value="<?php echo $itemnv->tennv ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text"  name="dcnv" placeholder="Nhập địa chỉ" value="<?php echo $itemnv->diachinv ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Số Điện Thoại</label>
                        <input type="text"  name="sdtnv" placeholder="Nhập số điện thoại" value="<?php echo $itemnv->sdt ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Chức Vụ</label>
                        <input type="text"  name="cvnv" placeholder="Nhập chức vụ" value="<?php echo $itemnv->chucvu ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Lương</label>
                        <input type="text"  name="luongnv" placeholder="Nhập lương" value="<?php echo $itemnv->luong ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Sửa">
                    </div>
                    <a href="admin.php?name=nhanvien" class="quaylai">Quay Lại</a>
                </form>
                <?php
                        }
                    ?>
            </div>
            <!-------------------------------END OF NHAN VIEN------------------------------>
            <div id="dskhachhang">
                <h2>Sửa Khách Hàng</h2>
                <?php
                    require_once("classkhachhang.php");
                    $dskh = Khachhang::Get($makh);
                    foreach($dskh as $itemkh){
                ?>
                <form action="admin.php?tieude=khachhang&action=2" method="POST">
                    <div class="form-group">
                        <label >Mã Khách Hàng</label>
                        <input type="text" name="makh" value="<?php echo$itemkh->makh ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label >Họ Và Tên</label>
                        <input type="text" name="tenkh" value="<?php echo$itemkh->tenkh ?>" placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text"  name="dckh" value="<?php echo$itemkh->diachikh ?>" placeholder="Nhập địa chỉ" required>
                    </div>
                    <div class="form-group">
                        <label>Số Điện Thoại</label>
                        <input type="text"  name="sdtkh" value="<?php echo$itemkh->sdt ?>" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Sửa">
                    </div>
                    <a href="admin.php?name=khachhang" class="quaylai">Quay Lại</a>
                </form>
                <?php
                    }
                ?>
            </div>
            <!-------------------------------END OF KHACH HANG------------------------------>
            <div id="dssach">
                <h2>Sửa Sách</h2>
                <?php
                    require_once("classsach.php");
                    $dss = sach::Get($masach);
                    foreach($dss as $items){
                ?>
                <form action="admin.php?tieude=sach&action=2" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label >Mã Sách</label>
                        <input type="text" name="mas" value="<?php echo$items->masach ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label >Tên Sách</label>
                        <input type="text" name="tens" value="<?php echo$items->tensach ?>" placeholder="Nhập tên sách" required>
                    </div>
                    <div class="form-group">
                        <label style="top:-20px;">Ảnh</label>
                        <input type="file"  name="img">
                        <span><img style="width: 100px;" src="img/<?php echo $items->img ?>"></span>
                        <input type="hidden" name="old_img" value="<?php echo$items->img ?>">
                    </div>
                    <div class="form-group">
                        <label>Loại Sách</label>
                        <input type="text"  name="loais" value="<?php echo$items->loaisach ?>" placeholder="Nhập loại sách" required>
                    </div>
                    <div class="form-group">
                        <label>Tác Giả</label>
                        <input type="text"  name="tg" value="<?php echo$items->tacgia ?>" placeholder="Nhập tên tác giả" required>
                    </div>
                    <div class="form-group">
                        <label>NXB</label>
                        <input type="text"  name="nxb" value="<?php echo$items->nxb ?>" placeholder="Nhập mã nxb" required>
                    </div>
                    <div class="form-group">
                        <label >Số Lượng</label>
                        <input type="text" name="soluong" value="<?php echo$items->soluong ?>" placeholder="Nhập số lượng sản phẩm đang có" required>
                    </div>
                    <div class="form-group">
                        <label>Giá Nhập</label>
                        <input type="text"  name="gianhap" value="<?php echo$items->gianhap ?>" placeholder="Nhập giá sản phẩm nhập về" required>
                    </div>
                    <div class="form-group">
                        <label>Giá Bán</label>
                        <input type="text"  name="giaban" value="<?php echo$items->giaban ?>" placeholder="Nhập giá sản phẩm bán ra" required>
                    </div>
                    <div class="form-group">
                        <textarea style="height: 150px; width:100%;"  name="mota" placeholder="Nhập mô tả sách" required><?php echo htmlspecialchars($items->mota); ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Sửa">
                    </div>
                    <a href="admin.php?name=sach" class="quaylai">Quay Lại</a>
                </form>
                <?php
                    }
                ?>
            </div>
            <!-------------------------------END OF SAN PHAM------------------------------>
           
        </main>
         <!-------END OF MAIN--------->
    </div>
</body>
<script src="them.js?v=<?php echo time(); ?>"></script>
</html>