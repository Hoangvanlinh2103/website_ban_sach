<?php
     session_start();
     $username = "";
     if(isset($_SESSION["ma"])){
         $username = $_SESSION["ma"];
     }
     $isAdmin = $username == "Admin";  // Kiểm tra xem user có phải là Admin không
    $madangnhap = "";
    if(isset($_SESSION["manv"])){
        $madangnhap = $_SESSION["manv"];
    }
    $name = isset($_GET["name"]) ? $_GET["name"] : "";
    $madhx = isset($_GET["madhx"]) ? $_GET["madhx"] : "";
    $madhn = isset($_GET["madhn"]) ? $_GET["madhn"] : "";
    $makm = isset($_GET["makm"]) ? $_GET["makm"] : "";
    if($name == "donhang"){
        $action = isset($_GET["action"]) ? $_GET["action"] :"0";
        $madhxuat = isset($_GET["madhxuat"]) ? $_GET["madhxuat"] : "";
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');
        if($action == "1"){
            // Lấy danh sách mã sản phẩm và số lượng từ form
            $masList = isset($_POST['mas']) ? $_POST['mas'] : [];
            $soluongList = isset($_POST['soluong']) ? $_POST['soluong'] : [];
            
            require_once("classdonhangxuat.php");
            $tinhtrang = Donhangxuat::GetTinhTrangDH($madhxuat);
            // Thêm chi tiết đơn hàng
            for ($i = 0; $i < count($masList); $i++) {
                $mas = $masList[$i];
                $soluong = $soluongList[$i];
                
                // Nếu tình trạng là "Đang xử lý", giảm số lượng sách
                if ($tinhtrang == "Đang xử lý" || $tinhtrang == "Đã hoàn thành") {
                    require_once("classsach.php");
                    $result = sach::giamsoluongsp($mas, $soluong);
                }
                
                // Gọi phương thức Add để thêm chi tiết đơn hàng
                if (Donhangxuat::Adddonhang_chitiet($madhxuat, $mas, $soluong)) {
                    $tongtien = Donhangxuat::updateTongTien($madhxuat);
                    require_once("classthanhtoan.php");
                    $thanhtoan = Thanhtoanxuat::update_thanhtoanxuat($madhxuat);
                    echo "<script>window.location.href = 'donhangchitiet.php?name=donhang&madhx=$madhxuat';</script>";
                } else {
                    echo "<script>alert('Thêm chi tiết đơn hàng thất bại cho mã sách: $mas');window.location.href = 'donhangchitiet.php?name=donhang&madhx=$madhxuat';</script>";
                }
            }
        }elseif($action == "3"){
            $madhxt = isset($_GET["madhxt"]) ? $_GET["madhxt"] : "";
            $masach = isset($_GET["masach"]) ? $_GET["masach"] : "";
            require_once("classdonhangxuat.php");
            $result = Donhangxuat::DeleteDHXCT($madhxt,$masach);
            $tongtien = Donhangxuat::updateTongTien($madhxt);
            require_once("classthanhtoan.php");
            $thanhtoan = Thanhtoanxuat::update_thanhtoanxuat($madhxt);
            echo "<script>window.location.href = 'donhangchitiet.php?name=donhang&madhx=$madhxt';</script>";
        }
    }
    elseif($name =="donhangnhap"){
        $action = isset($_GET["action"]) ? $_GET["action"] :"0";
        $madhnhap = isset($_GET["madhnhap"]) ? $_GET["madhnhap"] : "";
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');
        if ($action == "1") {
            // Lấy danh sách mã sản phẩm và số lượng từ form
            $masList = isset($_POST['mas']) ? $_POST['mas'] : [];
            $soluongList = isset($_POST['soluong']) ? $_POST['soluong'] : [];
            $gianhapList = isset($_POST['gianhap']) ? $_POST['gianhap'] : [];
            $ghichuList = isset($_POST['ghichu']) ? $_POST['ghichu'] : [];

            require_once("classdonhangnhap.php");
                // Thêm chi tiết đơn hàng
                for ($i = 0; $i < count($masList); $i++) {
                    $mas = $masList[$i];
                    $soluong = $soluongList[$i];
                    $gianhap = $gianhapList[$i];
                    $ghichu = $ghichuList[$i];
                    
                    require_once("classsach.php");
                    $result = sach::tangsoluongsp($mas, $soluong);

                    $thanhtien = $soluong * $gianhap;
                    // Gọi phương thức Add để thêm chi tiết đơn hàng
                    if (Donhangnhap::Adddonhang_chitiet($madhnhap, $mas, $soluong,$gianhap,$thanhtien,$ghichu)) {
                        $tongtien = Donhangnhap::EditTongtien($madhnhap); // Cập nhật tổng tiền
                        require_once("classthanhtoan.php");
                        $thanhtoan = ThanhToanNhap::update_thanhtoannhap($madhnhap);
                        echo "<script>window.location.href = 'donhangchitiet.php?name=donhangnhap&madhn=$madhnhap';</script>";
                    } else {
                        echo "<script>alert('Thêm chi tiết đơn hàng thất bại cho mã sách: $mas');window.location.href = 'admin.php?name=donhangnhap&madhn=$$madhnhap';</script>";
                    }
                }
        }elseif($action == "3"){
            $madhng = isset($_GET["madhng"]) ? $_GET["madhng"] : "";
            $masach = isset($_GET["masach"]) ? $_GET["masach"] : "";
            require_once("classdonhangnhap.php");
            $result = Donhangnhap::DeleteDHXCT($madhng,$masach);
            $tongtien = Donhangnhap::EditTongtien($madhng);
            require_once("classthanhtoan.php");
            $thanhtoan = ThanhToanNhap::update_thanhtoannhap($madhng);
            echo "<script>window.location.href = 'donhangchitiet.php?name=donhangnhap&madhn=$madhng';</script>";
        }
    }
    elseif ($name == "khuyenmai") {
        require_once("classkhuyenmai.php");
        // Lấy chi tiết khuyến mãi 
        $khuyenmai_detail = Khuyenmai::getKhuyenMaiDetail($makm);
    
        // Nếu tìm thấy khuyến mãi
        if ($khuyenmai_detail) {
            $khuyenmai = $khuyenmai_detail['khuyenmai'];
            $sachkhuyenmai = $khuyenmai_detail['sachkhuyenmai'];
        } else {
            echo "Không tìm thấy khuyến mãi.";
            exit;
        }
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
    <link rel="stylesheet" href = "admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href = "donhangchitiet.css?v=<?php echo time(); ?>">
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
                            <small class="text-muted"><?php echo $madangnhap; ?></small>
                        </div>
                        <div class="profile-photo">
                            <img src="./anh/anh1.jpg">
                        </div>
                    </div>
                </div>
            </div>
            <div class="insights" id="dsdonhang">
                <a href="them.php?name=themDHCT&madhx=<?php echo $madhx ?>" class="left-btn">Thêm sách</a>
                <a href="admin.php?name=donhangxuat" class="right-btn">Quay lại</a>
                <?php 
                    require_once("classdonhangxuat.php");
                    $dsdh = Donhangxuat::GetDHXuat($madhx);
                    if (!empty($dsdh)) {
                        $firstOrder = $dsdh[0];
                ?>
                <h1 class="h1madh">Mã đơn hàng: <?php echo $firstOrder->madh ?></h1>
                <div class="order-info">
                    <span>Mã nhân viên: <?php echo $firstOrder->manv ?></span>
                    <span>Tên nhân viên: <?php echo $firstOrder->tennv ?></span>
                    <span>Mã khách hàng: <?php echo $firstOrder->makh ?></span>
                    <span>Tên khách hàng: <?php echo $firstOrder->tenkh ?></span>
                    <span>Địa chỉ khách hàng: <?php echo $firstOrder->diachikh ?></span>
                    <span>SĐT: <?php echo $firstOrder->sdt ?></span>
                    <span>Đơn hàng ngày: <?php echo $firstOrder->ngay ?></span>
                    <span>Tổng tiền đơn hàng: <?php echo $firstOrder->tongtien ?></span>
                    <span>Tình trạng đơn hàng: <?php echo $firstOrder->ttdh ?></span>
                    <span>Tình trạng thanh toán: <?php echo $firstOrder->tttt ?></span>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5px;">Xóa</th>
                                <th>Mã Sách</th>
                                <th>Tên Sách</th>
                                <th>Hình Ảnh</th>
                                <th>Số Lượng</th>
                                <th>Giá Bán</th>
                                <th>Giá Chính</th>
                                <th>Giá Khuyến Mãi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($dsdh as $itemdh) {
                            ?>
                            <tr>
                                <td style="text-align: center;">
                                    <a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa sách không?');" 
                                    href="donhangchitiet.php?name=donhang&action=3&madhxt=<?php echo $itemdh->madh ?>&masach=<?php echo $itemdh->masach ?>"></a>
                                </td>
                                <td><?php echo $itemdh->masach ?></td>
                                <td><?php echo $itemdh->tensach ?></td>
                                <td><img style="width: 100px;" src="./img/<?php echo $itemdh->img ?>"></td>
                                <td><?php echo $itemdh->slxuat ?></td>
                                <td><?php echo $itemdh->giaban ?></td>
                                <td><?php echo $itemdh->ptkm ?></td>
                                <td><?php echo $itemdh->thanhtien ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php 
                    } else {
                        echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                    }
                ?>
            </div>
            <!----------------------------------END OF dsdonhang----------------------------------------->
            <div class="insights" id="dsdonhangnhap">
                <a href="them.php?name=themNhapDHCT&madhn=<?php echo $madhn ?>" class="left-btn">Thêm sách</a>
                <a href="admin.php?name=donhangnhap" class="right-btn">Quay lại</a>
                <?php 
                    require_once("classdonhangnhap.php");
                    $dsdh = Donhangnhap::GetDHNhap($madhn);
                    if (!empty($dsdh)) {
                        $firstOrder = $dsdh[0];
                ?>
                <h1 class="h1madh">Mã đơn hàng: <?php echo $firstOrder->madh ?></h1>
                <div class="order-info">
                    <span>Mã nhân viên: <?php echo $firstOrder->manv ?></span>
                    <span>Tên nhân viên: <?php echo $firstOrder->tennv ?></span>
                    <span>Mã khách hàng: <?php echo $firstOrder->manxb ?></span>
                    <span>Tên khách hàng: <?php echo $firstOrder->tennxb ?></span>
                    <span>Địa chỉ khách hàng: <?php echo $firstOrder->diachinxb ?></span>
                    <span>SĐT: <?php echo $firstOrder->sdt ?></span>
                    <span>Đơn hàng ngày: <?php echo $firstOrder->ngay ?></span>
                    <span>Tổng tiền đơn hàng: <?php echo $firstOrder->tongtien ?></span>
                    <span>Tình trạng thanh toán: <?php echo $firstOrder->tttt ?></span>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 25px;">Xóa</th>
                                <th>Mã Sách</th>
                                <th>Tên Sách</th>
                                <th>Hình Ảnh</th>
                                <th>Số Lượng</th>
                                <th>Giá Nhập</th>
                                <th>Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($dsdh as $itemdh) {
                            ?>
                            <tr>
                                <td style="text-align: center;">
                                    <a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa sách không?');" 
                                    href="donhangchitiet.php?name=donhangnhap&action=3&madhng=<?php echo $itemdh->madh ?>&masach=<?php echo $itemdh->masach ?>"></a>
                                </td>
                                <td><?php echo $itemdh->masach ?></td>
                                <td><?php echo $itemdh->tensach ?></td>
                                <td><img style="width: 100px;" src="./img/<?php echo $itemdh->img ?>"></td>
                                <td><?php echo $itemdh->slnhap ?></td>
                                <td><?php echo $itemdh->gianhap ?></td>
                                <td><?php echo $itemdh->thanhtien ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php 
                    } else {
                        echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                    }
                ?>
            </div>
            <!----------------------------------END OF dsdonhangnhap----------------------------------------->
            
            <div class="insights" id="dskhuyenmai">
                <a href="admin.php?name=khuyenmai" class="right-btn">Quay lại</a>
                <h1 class="h1madh">Mã Khuyến Mãi:
                    <?php echo $khuyenmai['MAKM']; ?>
                </h1>
                <div class="order-info">
                    <span>Tên Sự Kiện:
                        <?php echo $khuyenmai['TENSK']; ?>
                    </span>
                    <span>Ngày Bắt Đầu:
                        <?php echo $khuyenmai['NGAYBD']; ?>
                    </span>
                    <span>Ngày Kết Thúc:
                        <?php echo $khuyenmai['NGAYKT']; ?>
                    </span>
                </div>

                <div class="table-container">
                    <h2>Danh Sách Sách Áp Dụng Khuyến Mãi</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Sách</th>
                                <th>Tên Sách</th>
                                <th>Khuyến Mãi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($sachkhuyenmai as $item) {
                                ?>
                            <tr>
                                <td>
                                    <?php echo $item['MASACH']; ?>
                                </td>
                                <td>
                                    <?php echo $item['TENSACH']; ?>
                                </td>
                                <td>
                                    <?php echo $item['PTKM']; ?>%
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </main>
         <!-------END OF MAIN--------->
    </div>
</body>
<script src="admin.js?v=<?php echo time(); ?>"></script>
<script src="donhangchitiet.js?v=<?php echo time(); ?>"></script>
</html>