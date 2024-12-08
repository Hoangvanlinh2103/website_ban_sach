<?php
    session_start();
    // Gửi email chứa mã xác minh
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';
    $username = "";
    if(isset($_SESSION["ma"])){
       echo $username = $_SESSION["ma"];
    }
    else{
       echo header("Location:dangnhap.php");
    }
    $isAdmin = $username == "Admin";  // Kiểm tra xem user có phải là Admin không
    $madangnhap = "";
    if(isset($_SESSION["manv"])){
      echo $madangnhap = $_SESSION["manv"];
    }
    $tieude = isset($_GET["tieude"]) ? $_GET["tieude"] :"";
    $action = isset($_GET["action"]) ? $_GET["action"] :"0";
    if($tieude == "taikhoan"){
        require_once("classtaikhoan.php");
        $user = $_POST["user"] ?? '';
        $password = $_POST["password"] ?? '';
        $manv = $_POST["manv"] ?? '';
        $role = "Nhân Viên";
        if($action == "1"){
            $result = Taikhoan::Add($user,$password,$role,$manv);
            echo "<script>window.location.href = 'admin.php?name=taikhoan';</script>";
        }
        if($action == "2"){
            $result = Taikhoan::Edit($user,$password);
            echo "<script>window.location.href = 'admin.php?name=taikhoan';</script>";
        }
        if($action == "3"){
            $us = $_GET["user"];
            $result = Taikhoan::Delete($us);
            echo "<script>window.location.href = 'admin.php?name=taikhoan';</script>";
        }
    }
    if($tieude == "nxb"){
        require_once("classnxb.php");
        $tennxb = $_POST["tennxb"] ?? '';
        $dcnxb = $_POST["dcnxb"] ?? '';
        $sdt = $_POST["sdt"] ?? '';
        $email = $_POST["email"] ?? '';
        if($action == "1"){
            $nxb = new NXB("",$tennxb,$dcnxb,$sdt,$email);
            $result = NXB::Add($nxb);
            echo "<script>window.location.href = 'admin.php?name=nxb';</script>";
        }
        if($action == "2"){
            $manxb = $_POST["manxb"];
            $nxb = new NXB($manxb,$tennxb,$dcnxb,$sdt,$email);
            $result = NXB::Edit($nxb);
            echo "<script>window.location.href = 'admin.php?name=nxb';</script>";
        }
        if($action == "3"){
            $mnxb = $_GET["manxb"];
            $result = NXB::Delete($mnxb);
            echo "<script>window.location.href = 'admin.php?name=nxb';</script>";
        }
    }
    if($tieude == "nhanvien"){
        require_once("classnhanvien.php");
        $tennv = $_POST["tennv"] ?? '';
        $dcnv = $_POST["dcnv"] ?? '';
        $sdt = $_POST["sdtnv"] ?? '';
        $chucvu = $_POST["cvnv"] ?? '';
        $luongnv = $_POST["luongnv"] ?? '';
        if($action == "1"){
            $nv = new Nhanvien("",$tennv,$dcnv,$sdt,$chucvu,$luongnv);
            $result = Nhanvien::Add($nv);
            echo "<script>window.location.href = 'admin.php?name=nhanvien';</script>";
        }
        if($action == "2"){
            $manv = $_POST["manv"];
            $nv = new Nhanvien($manv,$tennv,$dcnv,$sdt,$chucvu,$luongnv);
            $result = Nhanvien::Edit($nv);
            echo "<script>window.location.href = 'admin.php?name=nhanvien';</script>";
        }
        if($action == "3"){
            $man = $_GET["manv"];
            $result = Nhanvien::Delete($man);
            echo "<script>window.location.href = 'admin.php?name=nhanvien';</script>";
        }
    }
    if($tieude == "khachhang"){
        require_once("classkhachhang.php");
        $tenkh = $_POST["tenkh"] ?? '';
        $dckh = $_POST["dckh"] ?? '';
        $sdt = $_POST["sdtkh"] ?? '';
        if($action == "1"){
            $kh = new Khachhang("",$tenkh,$dckh,$sdt);
            $result = Khachhang::Add($kh);
            echo "<script>window.location.href = 'admin.php?name=khachhang';</script>";
        }
        if($action == "2"){
            $makh = $_POST["makh"];
            $kh = new Khachhang($makh,$tenkh,$dckh,$sdt);
            $result = Khachhang::Edit($kh);
            echo "<script>window.location.href = 'admin.php?name=khachhang';</script>";
        }
        if($action == "3"){
            $mak = $_GET["makh"];
            $result = Khachhang::Delete($mak);
            echo "<script>window.location.href = 'admin.php?name=khachhang';</script>";
        }
    }
    if($tieude == "sach"){
        require_once("classsach.php");
        $tensach = $_POST["tens"] ?? '';
        $img = $_FILES["img"]["name"] ?? '';
        $img_tmp = $_FILES["img"]["tmp_name"] ?? '';
        $loaisach = $_POST["loais"] ?? '';
        $tacgia = $_POST["tg"] ?? '';
        $nxb = $_POST["nxb"] ?? '';
        $soluong = $_POST["soluong"] ?? '';
        $gianhap = $_POST["gianhap"] ?? '';
        $giaban = $_POST["giaban"] ?? '';
        $mota = $_POST["mota"] ?? '';
        if($action == "1"){
            $sp = new sach("",$tensach,$img,$loaisach,$tacgia,$nxb,$soluong,$gianhap,$giaban,$mota);
            move_uploaded_file($img_tmp,'img/'.$sp->img);
            $result = sach::Add($sp);
            echo "<script>window.location.href = 'admin.php?name=sach';</script>";
        }
        if($action == "2"){
            $masp = $_POST["mas"];
            $old_img = $_POST["old_img"] ?? '';
            if ($img) {
                $img_to_save = $img;
                move_uploaded_file($img_tmp, 'img/' . $img_to_save);
                if ($old_img && file_exists('img/' . $old_img)) {   // xóa ảnh cũ 
                    unlink('img/' . $old_img);
                }
            } else {
                $img_to_save = $old_img;
            }
            $sp = new sach($masp, $tensach, $img_to_save, $loaisach,$tacgia, $nxb, $soluong, $gianhap, $giaban, $mota);
            $result = sach::Edit($sp);
            echo "<script>window.location.href = 'admin.php?name=sach';</script>";
        }
        if($action == "3"){
            $mas = $_GET["masach"];
            $result = sach::Delete($mas);
            echo "<script>window.location.href = 'admin.php?name=sach';</script>";
        }
    }
    if ($tieude == "donhangxuat") {
        require_once("classdonhangxuat.php");
        $madh = Donhangxuat::TangMadonhang(); // Tăng mã đơn hàng tự động
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');
        $manv = $_POST['manv'] ?? '';
        $tinhtrang = $_POST['tinhtrang'] ?? '';

        // Lấy danh sách mã sản phẩm và số lượng từ form
        $masList = isset($_POST['mas']) ? $_POST['mas'] : [];
        $soluongList = isset($_POST['soluong']) ? $_POST['soluong'] : [];
        
        if ($action == "1") {
            // Gọi phương thức Add để thêm đơn hàng
            if (Donhangxuat::Adddonhang($madh, $today, $madangnhap, null, 0, $tinhtrang)) {
                // Thêm chi tiết đơn hàng
                for ($i = 0; $i < count($masList); $i++) {
                    $mas = $masList[$i];
                    $soluong = $soluongList[$i];
                    
                    // Nếu tình trạng là "Đang xử lý", giảm số lượng sách
                    if ($tinhtrang == "Đang xử lý") {
                        require_once("classsach.php");
                        $result = sach::giamsoluongsp($mas, $soluong);
                    }
                    
                    // Gọi phương thức Add để thêm chi tiết đơn hàng
                    if (Donhangxuat::Adddonhang_chitiet($madh, $mas, $soluong)) {
                        $tongtien = Donhangxuat::updateTongTien($madh); // Cập nhật tổng tiền
                    } else {
                        echo "<script>alert('Thêm chi tiết đơn hàng thất bại cho mã sách: $mas');window.location.href = 'admin.php?name=donhangxuat';</script>";
                    }
                }
                echo "<script>alert('Thêm đơn hàng thành công!'); window.location.href = 'admin.php?name=donhangxuat';</script>";
            } else {
                echo "<script>alert('Thêm đơn hàng thất bại!');window.location.href = 'admin.php?name=donhangxuat';</script>";
            }
        }
        elseif ($action == "2") {
            $madh = $_GET["madh"];
            $tongtien = Donhangxuat::gettongtien($madh);
            $result = Donhangxuat::EditDonhang_hoanthanh($madh);
            require_once("classthanhtoan.php");
            $ttx = new Thanhtoanxuat($madh,$today,$tongtien);
            $result_tt = Thanhtoanxuat::AddThanhToanXuat($ttx);  
            echo "<script>window.location.href = 'admin.php?name=donhangxuat';</script>";
        }   
        elseif($action == "3"){
            $madh = $_GET["madh"];
            $result = Donhangxuat::EditDonhang_huy($madh);
            echo "<script>window.location.href = 'admin.php?name=donhangxuat';</script>";
        }elseif($action == "5"){
            $mad = $_GET["madhx"];
            $result = Donhangxuat::Delete($mad);
            echo "<script>window.location.href = 'admin.php?name=donhangxuat';</script>";
        }
    }
    if ($tieude == "dathang") {
        require_once("classdonhangxuat.php");
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');
        if ($action == "2") {
            $madh = $_GET["madh"];
            $makh = $_GET["makh"];
            $result = Donhangxuat::EditDathang($madangnhap,$madh);
            require_once("classtaikhoan.php");
            $email = Taikhoan::GetEmail($makh);
            $mail = new PHPMailer(true);
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
            $mail->Subject = 'Xác nhận đơn hàng';
            $mail->Body = "Đơn hàng: <b>$madh</b> của bạn đã được nhân viên xác nhận";
            $mail->send();
            echo "<script>window.location.href = 'admin.php?name=dathang';</script>";
        }   
       elseif($action == "5"){
            $mad = $_GET["madhx"];
            $result = Donhangxuat::Delete($mad);
            echo "<script>window.location.href = 'admin.php?name=dathang';</script>";
        }
    }
    if ($tieude == "donhangnhap") {
        require_once("classdonhangnhap.php");
        $madh = Donhangnhap::TangMadonhang(); // Tăng mã đơn hàng tự động
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date('Y-m-d');
        $manxb = !empty($_POST['manxb']) ? $_POST['manxb'] : null;
        $tinhtrang = $_POST['tinhtrang'] ?? '';

        // Lấy danh sách mã sản phẩm và số lượng từ form
        $masList = isset($_POST['mas']) ? $_POST['mas'] : [];
        $soluongList = isset($_POST['soluong']) ? $_POST['soluong'] : [];
        $gianhapList = isset($_POST['gianhap']) ? $_POST['gianhap'] : [];
        $ghichuList = isset($_POST['ghichu']) ? $_POST['ghichu'] : [];
        
        if ($action == "1") {
            // Gọi phương thức Add để thêm đơn hàng
            if (Donhangnhap::Adddonhang($madh, $today, $madangnhap, $manxb, 0, $tinhtrang)) {
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
                    if (Donhangnhap::Adddonhang_chitiet($madh, $mas, $soluong,$gianhap,$thanhtien,$ghichu)) {
                        $tongtien = Donhangnhap::EditTongtien($madh); // Cập nhật tổng tiền

                    } else {
                        echo "<script>alert('Thêm chi tiết đơn hàng thất bại cho mã sách: $mas');window.location.href = 'admin.php?name=donhangnhap';</script>";
                    }
                }
                if($tinhtrang == "Đã thanh toán"){
                    $tongtien = Donhangnhap::gettongtien($madh);
                    require_once("classthanhtoan.php");
                    $ttn = new ThanhToanNhap($madh,$today,$tongtien);
                    $result_tt = ThanhToanNhap::AddThanhToanNhap($ttn);  
                }
                echo "<script>alert('Thêm đơn hàng thành công!'); window.location.href = 'admin.php?name=donhangnhap';</script>";
            } else {
                echo "<script>alert('Thêm đơn hàng thất bại!');window.location.href = 'admin.php?name=donhangnhap';</script>";
            }
        }
        elseif ($action == "2") {
            $madh = $_GET["madh"];
            $tongtien = Donhangnhap::gettongtien($madh);
            $result = Donhangnhap::EditDonhang($madh);
            require_once("classthanhtoan.php");
            $ttn = new ThanhToanNhap($madh,$today,$tongtien);
            $result_tt = ThanhToanNhap::AddThanhToanNhap($ttn);  
            echo "<script>window.location.href = 'admin.php?name=donhangnhap';</script>";
        }   
        elseif($action == "5"){
            $mad = $_GET["madhn"];
            $result = Donhangnhap::Delete($mad);
            echo "<script>window.location.href = 'admin.php?name=donhangnhap';</script>";
        }
    }

    if($tieude == "luong"){
        require_once("classluong.php");
        $manv = $_GET["manv"] ?? '';
        $thang = $_GET["thang"] ?? '';
        $nam = $_GET["nam"] ?? '';
        if($action == "2"){
            Luong::Edit($manv,$thang,$nam);
            echo "<script>window.location.href = 'admin.php?name=luong';</script>";
        }
    }
    if ($tieude == "khuyenmai") {
        require_once("classsach.php");
        require_once("classkhuyenmai.php");
        $makm = KhuyenMai::tangMaKhuyenMai();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    
        // Lấy thông tin từ form
        $tensk = $_POST['tensk'];
        $ngaybatdau = $_POST['ngaybatdau'];
        $ngayketthuc = $_POST['ngayketthuc'];
    
        if ($action == "1") {
            // Lấy danh sách sách và phần trăm khuyến mãi
            $sachList = $_POST['sachtuychon'];  // Danh sách mã sách (mảng)
            $ptkmList = $_POST['ptkm_tuychon']; // Danh sách phần trăm khuyến mãi tương ứng (mảng)
    
            // Kiểm tra xem danh sách sách và phần trăm khuyến mãi có hợp lệ không
            if (!empty($sachList) && !empty($ptkmList) && count($sachList) === count($ptkmList)) {
                // Gọi phương thức thêm khuyến mãi với kiểu "tùy chọn"
                $result = KhuyenMai::addKhuyenMai($makm, $tensk, $ngaybatdau, $ngayketthuc, $sachList, $ptkmList);
    
                if ($result) {
                    // Chuyển hướng sau khi thêm khuyến mãi thành công
                    echo "<script>window.location.href = 'admin.php?name=khuyenmai';</script>";
                    exit();  // Đảm bảo ngắt kết nối sau khi chuyển hướng
                } else {
                    echo "Lỗi: Không thể thêm khuyến mãi.";
                }
            } else {
                echo "Lỗi: Danh sách sách và phần trăm khuyến mãi không hợp lệ.";
            }
        }
    }   
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="300">  <!-- Làm mới trang sau mỗi 300 giây (5 phút) -->
    <title>Admin</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href = "admin.css?v=<?php echo time(); ?>">
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
                            <small class="text-muted"><?php echo $madangnhap; ?></small>
                        </div>
                        <div class="profile-photo">
                            <img src="./anh/anh1.jpg">
                        </div>
                    </div>
                </div>
            </div>

             <!-------------------------------start OF sách bán chạy------------------------------>
            <div class="insights" id="trangchuSection">
                <h1>Sách nổi bật trong tháng</h1>
                <div class="sachnoibat">
                    <?php
                        require_once("classsach.php");
                        $dss = sach::Getnoibat();
                        foreach ($dss as $items){
                    ?>
                        <div class="product">
                            <img style="width: 300px; height: 300px;" src="img/<?php echo $items->img ?>">
                            <h2><?php echo $items->tensach ?></h2>
                            <h2><?php echo $items->giaban ?></h2>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <!-------------------------------END OF sách bán chạy------------------------------>

            <!-------------------------------Start OF TAI KHOAN------------------------------>
            <div id="dstaikhoan">
                <h2>Danh Sách Tài Khoản</h2>
                <div class="form-container">
                    <a href="them.php?name=taikhoan">Thêm</a>
                    <form action="admin.php?name=taikhoan&action=4" method="POST">
                        <input type="text" id="tktk" name="tktk" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 25px;">Xóa</th>
                                <th>User</th>
                                <th>Password</th>
                                <th>Thân Phận</th>
                                <th>Mã Nhân Viên</th>
                                <th>Mã Khách Hàng</th>
                                <th>Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classtaikhoan.php");
                                $timtk = $_POST["tktk"] ?? "";
                                if($action == "4"){
                                    $dstk = Taikhoan::GetElement($timtk);
                                }
                                else{
                                    $dstk = Taikhoan::GetAll();}
                                foreach ($dstk as $itemtk){
                            ?>
                            <tr>
                                <td style="text-align: center;"><a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa tài khoản?');"
                                href="admin.php?action=3&tieude=taikhoan&user=<?php echo $itemtk->user ?>"></a></td>
                                <td><?php echo $itemtk->user ?></td>
                                <td><?php echo $itemtk->password ?></td>
                                <td><?php echo $itemtk->thanphan ?></td>
                                <td><?php echo $itemtk->manv ?></td>
                                <td><?php echo $itemtk->makh ?></td>
                                <td>
                                    <a class="a1" href="sua.php?name=taikhoan&user=<?php echo $itemtk->user ?>">Edit</a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF TAI KHOAN------------------------------>

                 <!-------------------------------Start OF NXB------------------------------>
                 <div id="dsnxb">
                <h2>Danh Sách Nhà Xuất Bản</h2>
                <div class="form-container">
                    <a href="them.php?name=nxb">Thêm</a>
                    <form action="admin.php?name=nxb&action=4" method="POST">
                        <input type="text" id="tktk" name="tknxb" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 25px;">Xóa</th>
                                <th>Mã Nhà Xuất Bản</th>
                                <th>Tên Nhà Xuất Bản</th>
                                <th>Địa Chỉ</th>
                                <th>SĐT</th>
                                <th>Email</th>
                                <th>Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classnxb.php");
                                $timtk = $_POST["tknxb"] ?? "";
                                if($action == "4"){
                                    $dstk = NXB::GetElement($timtk);
                                }
                                else{
                                    $dstk = NXB::GetAll();}
                                foreach ($dstk as $itemtk){
                            ?>
                            <tr>
                                <td style="text-align: center;"><a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa Nhà xuất bản không?');"
                                href="admin.php?action=3&tieude=nxb&manxb=<?php echo $itemtk->manxb ?>"></a></td>
                                <td><?php echo $itemtk->manxb ?></td>
                                <td><?php echo $itemtk->tennxb ?></td>
                                <td><?php echo $itemtk->diachinxb ?></td>
                                <td><?php echo $itemtk->sdt ?></td>
                                <td><?php echo $itemtk->email ?></td>
                                <td>
                                    <a class="a1" href="sua.php?name=nxb&manxb=<?php echo $itemtk->manxb ?>">Edit</a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF TAI KHOAN------------------------------>

             <!-------------------------------start OF nhân viên------------------------------>
            <div id="dsnhanvien">
                <h2>Danh Sách Nhân Viên</h2>
                <div class="form-container">
                    <a href="them.php?name=nhanvien">Thêm</a>
                    <form action="admin.php?name=nhanvien&action=4" method="POST">
                        <input type="text" id="tktk" name="tknv" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 25px;">Xóa</th>
                                <th>Mã Nhân Viên</th>
                                <th>Họ Và Tên</th>
                                <th>Địa Chỉ</th>
                                <th>SĐT</th>
                                <th>Chức Vụ</th>
                                <th>Lương</th>
                                <th>Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classnhanvien.php");
                                $timnv = $_POST["tknv"] ?? "";
                                if($action == "4"){
                                    $dsnv = Nhanvien::GetElement($timnv);
                                }else{
                                    $dsnv = Nhanvien::GetAll();}
                                foreach ($dsnv as $itemnv){
                            ?>
                            <tr>
                                <td style="text-align: center;"><a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa nhân viên?');"
                                href="admin.php?action=3&tieude=nhanvien&manv=<?php echo $itemnv->manv ?>"></a></td>
                                <td><?php echo $itemnv->manv ?></td>
                                <td><?php echo $itemnv->tennv ?></td>
                                <td><?php echo $itemnv->diachinv ?></td>
                                <td><?php echo $itemnv->sdt ?></td>
                                <td><?php echo $itemnv->chucvu ?></td>
                                <td><?php echo $itemnv->luong ?></td>
                                <td>
                                    <a class="a1" href="sua.php?name=nhanvien&manv=<?php echo $itemnv->manv ?>">Edit</a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF NHAN VIEN------------------------------>

             <!-------------------------------start OF khách hàng------------------------------>
            <div id="dskhachhang">
                <h2>Danh Sách Khách Hàng</h2>
                <div class="form-container">
                    <a href="them.php?name=khachhang">Thêm</a>
                    <form action="admin.php?name=khachhang&action=4" method="POST">
                        <input type="text" id="tktk" name="tkkh" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 25px;">Xóa</th>
                                <th>Mã Khách Hàng</th>
                                <th>Họ Và Tên</th>
                                <th>Địa Chỉ</th>
                                <th>SĐT</th>
                                <th>Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classkhachhang.php");
                                $timkh = $_POST["tkkh"] ?? "";
                                if($action == "4"){
                                    $dskh = Khachhang::GetElement($timkh);
                                }
                                else{
                                    $dskh = Khachhang::GetAll();}
                                foreach ($dskh as $itemkh){
                            ?>
                            <tr>
                                <td style="text-align: center;"><a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa khách hàng?');"
                                href="admin.php?action=3&tieude=khachhang&makh=<?php echo $itemkh->makh ?>"></a></td>
                                <td><?php echo $itemkh->makh ?></td>
                                <td><?php echo $itemkh->tenkh ?></td>
                                <td><?php echo $itemkh->diachikh ?></td>
                                <td><?php echo $itemkh->sdt ?></td>
                                <td>
                                    <a class="a1" href="sua.php?name=khachhang&makh=<?php echo $itemkh->makh ?>">Edit</a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF KHACH HANG------------------------------>

             <!-------------------------------start OF sách------------------------------>
            <div id="dssach">
                <h2>Danh Sách Sách</h2>
                <div class="form-container">
                    <a href="them.php?name=sach">Thêm</a>
                    <form action="admin.php?name=sach&action=4" method="POST">
                        <input type="text" id="tktk" name="tks" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 35px;">Xóa</th>
                                <th>Mã Sách</th>
                                <th>Tên Sách</th>
                                <th>Hình Ảnh</th>
                                <th>Loại Sách</th>
                                <th>Tác Giả</th>
                                <th>NXB</th>
                                <th>Số Lượng</th>
                                <th>Giá Bán</th>
                                <th>Giá Nhập</th>
                                <th>Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classsach.php");
                                $tims = $_POST["tks"] ?? "";
                                if($action == "4"){
                                    $dss = sach::GetElement($tims);
                                }
                                else{
                                    $dss = sach::GetAll();}
                                foreach ($dss as $items){
                            ?>
                            <tr>
                                <td style="text-align: center;"><a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa sách không?');"
                                href="admin.php?action=3&tieude=sach&masach=<?php echo $items->masach ?>"></a></td>
                                <td><?php echo $items->masach ?></td>
                                <td><?php echo $items->tensach ?></td>
                                <td><img style="width: 100px;" src="./img/<?php echo $items->img ?>"></td>
                                <td><?php echo $items->loaisach ?></td>
                                <td><?php echo $items->tacgia ?></td>
                                <td><?php echo $items->nxb ?></td>
                                <td><?php echo $items->soluong ?></td>
                                <td><?php echo $items->gianhap ?></td>
                                <td><?php echo $items->giaban ?></td>
                                <td>
                                    <a class="a1" href="sua.php?name=sach&masach=<?php echo $items->masach ?>">Edit</a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
             <!-------------------------------END OF SACH------------------------------>

              <!-------------------------------start OF đơn hàng xuất------------------------------>
            <div id="dsdonhangxuat">
                <h2>Danh Sách Đơn Hàng Xuất</h2>
                <div class="form-container">
                    <a href="them.php?name=donhangxuat">Thêm</a>
                    <form action="admin.php?name=donhangxuat&action=4" method="POST">
                        <input type="text" id="tktk" name="tkdhxuat" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 35px;">Xóa</th>
                                <th>Mã Đơn hàng</th>
                                <th>Ngày</th>
                                <th>Mã Nhân Viên</th>
                                <th>Mã Khách hàng</th>
                                <th>Tổng Tiền</th>
                                <th>Tình Trạng Đơn Hàng</th>
                                <th>Tình Trạng Thanh Toán</th>
                                <th>Chức Năng</th>
                                <th>Xem Chi Tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classdonhangxuat.php");
                                $timdonhang = $_POST["tkdhxuat"] ?? "";
                                if($action == "4"){
                                    $dsdonh = Donhangxuat::GetElementdonhang($timdonhang);
                                }
                                else{
                                    $dsdonh = Donhangxuat::GetAllDonhang();}
                                foreach ($dsdonh as $itemdonh){
                            ?>
                            <tr>
                                <td style="text-align: center;"><a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa đơn hàng không?');"
                                href="admin.php?action=5&tieude=donhangxuat&madhx=<?php echo $itemdonh->madh ?>"></a></td>
                                <td><?php echo $itemdonh->madh ?></td>
                                <td><?php echo $itemdonh->ngay ?></td>
                                <td><?php echo $itemdonh->manv ?></td>
                                <td><?php echo $itemdonh->makh ?></td>
                                <td><?php echo $itemdonh->tongtien ?></td>
                                <td><?php echo $itemdonh->ttdh ?></td>
                                <td><?php echo $itemdonh->tttt ?></td>
                                <td>
                                    <?php if ($itemdonh->ttdh == 'Đã hủy') { ?>
                                        <a class="a1">Đã Hủy</a>
                                    <?php } elseif ($itemdonh->ttdh != 'Đã hoàn thành') { ?>
                                        <a class="a1" href="admin.php?action=2&tieude=donhangxuat&madh=<?php echo $itemdonh->madh ?>">Xác Nhận</a>
                                        <a class="a1" href="admin.php?action=3&tieude=donhangxuat&madh=<?php echo $itemdonh->madh ?>" style="margin-left: 10px;">Hủy</a>
                                    <?php } else { ?>
                                        <a class="a1">Đã Hoàn Thành</a>
                                    <?php } ?>
                                </td>
                                <td><a href="donhangchitiet.php?name=donhang&madhx=<?php echo $itemdonh->madh ?>">Chi Tiết</a></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF Don hàng xuất------------------------------>

            <!-------------------------------start OF đơn hàng đặt------------------------------>
            <div id="dsdathang">
                <h2>Danh Sách Đơn Đặt</h2>
                <div class="form-container">
                    <form action="admin.php?name=dathang&action=4" method="POST">
                        <input type="text" id="tktk" name="tkdhxuat" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 35px;">Xóa</th>
                                <th>Mã Đơn hàng</th>
                                <th>Ngày</th>
                                <th>Mã Nhân Viên</th>
                                <th>Mã Khách hàng</th>
                                <th>Tổng Tiền</th>
                                <th>Tình Trạng Đơn Hàng</th>
                                <th>Tình Trạng Thanh Toán</th>
                                <th>Chức Năng</th>
                                <th>Xem Chi Tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classdonhangxuat.php");
                                $timdonhang = $_POST["tkdhxuat"] ?? "";
                                if($action == "4"){
                                    $dsdonh = Donhangxuat::GetElementdathang($timdonhang);
                                }
                                else{
                                    $dsdonh = Donhangxuat::GetAllDathang();}
                                if (empty($dsdonh)) {
                                    echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                                }else{
                                    foreach ($dsdonh as $itemdonh){
                            ?>
                            <tr>
                                <td style="text-align: center;"><a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa đơn hàng không?');"
                                href="admin.php?action=5&tieude=dathang&madhx=<?php echo $itemdonh->madh ?>"></a></td>
                                <td><?php echo $itemdonh->madh ?></td>
                                <td><?php echo $itemdonh->ngay ?></td>
                                <td><?php echo $itemdonh->manv ?></td>
                                <td><?php echo $itemdonh->makh ?></td>
                                <td><?php echo $itemdonh->tongtien ?></td>
                                <td><?php echo $itemdonh->ttdh ?></td>
                                <td><?php echo $itemdonh->tttt ?></td>
                                <td>
                                    <a class="a1" href="admin.php?action=2&tieude=dathang&madh=<?php echo $itemdonh->madh ?>&makh=<?php echo $itemdonh->makh ?>">Xác Nhận</a>
                                </td>
                                <td><a href="donhangchitiet.php?name=donhang&madhx=<?php echo $itemdonh->madh ?>">Chi Tiết</a></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF Đặt hàng------------------------------>

            <!-------------------------------start OF đơn hàng nhập------------------------------>
            <div id="dsdonhangnhap">
                <h2>Danh Sách Đơn Hàng Nhập</h2>
                <div class="form-container">
                    <a href="them.php?name=donhangnhap">Thêm</a>
                    <form action="admin.php?name=donhangnhap&action=4" method="POST">
                        <input type="text" id="tktk" name="tkdhn" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 35px;">Xóa</th>
                                <th>Mã Đơn hàng</th>
                                <th>Ngày</th>
                                <th>Mã Nhân Viên</th>
                                <th>Mã Nhà Cung Cấp</th>
                                <th>Tổng Tiền</th>
                                <th>Tình Trạng Thanh Toán</th>
                                <th>Chức Năng</th>
                                <th>Xem Chi Tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classdonhangnhap.php");
                                $timdonhang = $_POST["tkdhn"] ?? "";
                                if($action == "4"){
                                    $dsdonh = Donhangnhap::GetElementdonhang($timdonhang);
                                }
                                else{
                                    $dsdonh = Donhangnhap::GetAllDonhang();}
                                if (empty($dsdonh)) {
                                    echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                                }else{
                                    foreach ($dsdonh as $itemdonh){
                            ?>
                            <tr>
                                <td style="text-align: center;"><a class="bi bi-trash" onclick="return confirm('Bạn có muốn xóa đơn hàng không?');"
                                href="admin.php?action=5&tieude=donhangnhap&madhn=<?php echo $itemdonh->madh ?>"></a></td>
                                <td><?php echo $itemdonh->madh ?></td>
                                <td><?php echo $itemdonh->ngay ?></td>
                                <td><?php echo $itemdonh->manv ?></td>
                                <td><?php echo $itemdonh->manxb ?></td>
                                <td><?php echo $itemdonh->tongtien ?></td>
                                <td><?php echo $itemdonh->tttt ?></td>
                                <td>
                                    <?php if ($itemdonh->tttt != 'Đã thanh toán') { ?>
                                        <a class="a1" href="admin.php?action=2&tieude=donhangnhap&madh=<?php echo $itemdonh->madh ?>">Xác Nhận</a>
                                    <?php } else { ?>
                                        <a class="a1">Đã Hoàn Thành</a>
                                    <?php } ?>
                                </td>
                                <td><a href="donhangchitiet.php?name=donhangnhap&madhn=<?php echo $itemdonh->madh ?>">Chi Tiết</a></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF Đơn hàng nhập------------------------------>

            <!-------------------------------START OF Khuyến mãi------------------------------>
             <div id="dskhuyenmai">
                <h2>Danh Sách Khuyến Mãi</h2>
                <div class="form-container">
                    <a href="them.php?name=khuyenmai">Thêm</a>
                    <form action="" method="POST">
                        <input type="text" id="" name="" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Khuyến Mãi</th>
                                <th>Tên Sự kiện</th>
                                <th>Ngày Bắt Đầu</th>
                                <th>Ngày Kết Thúc</th>
                                <th>Xem Chi Tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once("classkhuyenmai.php");
                            $dskm = Khuyenmai::getAllKhuyenMai();
                            foreach ($dskm as $items) {
                                ?>
                                <tr>
                                    <td><?php echo $items->makm ?></td>
                                    <td><?php echo $items->tensk ?></td>
                                    <td><?php echo $items->tgbd ?></td>
                                    <td><?php echo $items->tgkt ?></td>
                                    <td><a class="a1"
                                            href="donhangchitiet.php?name=khuyenmai&makm=<?php echo $items->makm; ?>">Chi
                                            Tiết</a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF Khuyến mãi------------------------------>

             <!-------------------------------start OF lịch sử thanh toán của đơn hàng xuất------------------------------>
            <div id="dsgdbanhang">
                <h2>Danh Sách Lịch Sử Giao Dịch Bán Hàng</h2>
                <div class="form-container">
                    <form action="admin.php?name=gdbanhang&action=4" method="POST">
                        <input type="text" id="tktk" name="tkgdbh" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Đơn hàng</th>
                                <th>Ngày</th>
                                <th>Tổng Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classthanhtoan.php");
                                $timdonhang = $_POST["tkgdbh"] ?? "";
                                if($action == "4"){
                                    $dsdonh = Thanhtoanxuat::GetElementdonhang($timdonhang);
                                }
                                else{
                                    $dsdonh = Thanhtoanxuat::GetAllThanhToanXuat();}
                                if (empty($dsdonh)) {
                                    echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                                }else{
                                    foreach ($dsdonh as $itemdonh){
                            ?>
                            <tr>
                                <td><?php echo $itemdonh->madhx ?></td>
                                <td><?php echo $itemdonh->ngaytt ?></td>
                                <td><?php echo $itemdonh->tongtien ?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF Lịch sử giao dịch bán hàng------------------------------>

             <!-------------------------------start OF lịch sử thanh toán của đơn hàng nhập------------------------------>
            <div id="dsgdnhaphang">
                <h2>Danh Sách Lịch Sử Giao Dịch Bán Hàng</h2>
                <div class="form-container">
                    <form action="admin.php?name=gdnhaphang&action=4" method="POST">
                        <input type="text" id="tktk" name="tkgdnh" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Đơn hàng</th>
                                <th>Ngày</th>
                                <th>Tổng Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classthanhtoan.php");
                                $timdonhang = $_POST["tkgdng"] ?? "";
                                if($action == "4"){
                                    $dsdonh = ThanhToanNhap::GetElementdonhang($timdonhang);
                                }
                                else{
                                    $dsdonh = ThanhToanNhap::GetAllThanhToanNhap();}
                                if (empty($dsdonh)) {
                                    echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                                }else{
                                    foreach ($dsdonh as $itemdonh){
                            ?>
                            <tr>
                                <td><?php echo $itemdonh->madhn ?></td>
                                <td><?php echo $itemdonh->ngaytt ?></td>
                                <td><?php echo $itemdonh->tongtien ?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF Lịch sử giao dịch nhập hàng------------------------------>


             <!-------------------------------start OF thống kê tiền trong 1 tháng theo biểu đồ------------------------------>
             <div id="dstktienbieudo">
                <h2>Thống Kê Tiền Trong Tháng</h2>
                <div class="year-container">
                    <a id="tkbdtien-left" href="admin.php?name=tktienbieudo">Thống kê tiền trong tháng theo biểu đồ</a>
                    <a id="tkbdtien-right" href="admin.php?name=tktienthangbieudo">Thống kê tiền trong năm theo biểu đồ</a>
                </div>
                <form method="GET" action="admin.php">
                    <input type="hidden" name="name" value="tktienbieudo"> <!-- Trường ẩn cho name -->
                    <label for="thang">Chọn tháng:</label>
                    <select name="thang" id="thang">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo ($i == date("n")) ? 'selected' : ''; ?>>
                                <?php echo $i; ?>
                            </option>
                        <?php endfor; ?>
                    </select>

                    <label for="nam">Chọn năm:</label>
                    <select name="nam" id="nam">
                        <?php 
                            $currentYear = date("Y");
                            for ($i = $currentYear - 5; $i <= $currentYear; $i++): // Hiển thị 5 năm gần đây ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == $currentYear) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>
                                </option>
                        <?php endfor; ?>
                    </select>

                    <button type="submit">Xem</button>
                </form>

                <?php
                    require_once("classthanhtoan.php");

                    // Lấy tháng và năm từ GET hoặc mặc định là tháng và năm hiện tại
                    $thang = isset($_GET['thang']) ? (int)$_GET['thang'] : date("n");
                    $nam = isset($_GET['nam']) ? (int)$_GET['nam'] : date("Y");

                    // Lấy dữ liệu doanh thu theo ngày trong tháng và năm đã chọn
                    $data = Thanhtoanxuat::GetTongTienTheoThangNam($thang, $nam);

                    if (empty($data)) {
                        echo "<script>alert('Không có dữ liệu cho tháng và năm này.');</script>";
                        $data = []; // Đảm bảo có mảng rỗng nếu không có dữ liệu
                    }
                    
                    $days = array_column($data, 'ngay');
                    $revenues = array_column($data, 'doanhthu');
                    
                    // Truyền dữ liệu sang JavaScript
                    echo "<script>window.days = " . json_encode($days) . ";</script>";
                    echo "<script>window.revenues = " . json_encode($revenues) . ";</script>";
                ?>
                <canvas id="revenueChart"></canvas>

                <!-- Tải file JavaScript riêng -->
                <script src="bieudo.js?v=<?php echo time() ?>"></script>
            </div>
            <!-------------------------------END OF Thống kê tiền theo biểu đồ trong 1 tháng nào đó------------------------------>

             <!-------------------------------start OF thống kê tiền 1 năm theo biểu đồ------------------------------>
            <div id="dstktienthangbieudo">
                <h2>Thống Kê Tiền Trong Năm</h2>
                <div class="year-container">
                    <a id="tkbdtien-left" href="admin.php?name=tktienbieudo">Thống kê tiền trong tháng theo biểu đồ</a>
                    <a id="tkbdtien-right" href="admin.php?name=tktienthangbieudo">Thống kê tiền trong năm theo biểu đồ</a>
                </div>
                <form method="GET" action="admin.php">
                    <input type="hidden" name="name" value="tktienthangbieudo"> <!-- Trường ẩn cho name -->

                    <label for="nam">Chọn năm:</label>
                    <select name="nam" id="nam">
                        <?php 
                            $currentYear = date("Y");
                            for ($i = $currentYear - 5; $i <= $currentYear; $i++): // Hiển thị 5 năm gần đây ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == $currentYear) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>
                                </option>
                        <?php endfor; ?>
                    </select>

                    <button type="submit">Xem</button>
                </form>

                <?php
                    require_once("classthanhtoan.php");

                    // Lấy năm từ GET hoặc mặc định là năm hiện tại
                    $nam = isset($_GET['nam']) ? (int)$_GET['nam'] : date("Y");

                    // Lấy dữ liệu doanh thu cao nhất theo tháng cho năm đã chọn
                    $data = Thanhtoanxuat::getDoanhThuCaoNhatTheoThangTrongNam($nam);

                    // Khởi tạo mảng tháng với giá trị 0 cho các tháng chưa có dữ liệu
                    $months = range(1, 12); // Tạo mảng từ 1 đến 12 (các tháng)
                    $revenues = array_fill(0, 12, 0); // Tạo mảng doanh thu với 12 phần tử, mỗi phần tử ban đầu là 0

                    // Cập nhật doanh thu cho các tháng có dữ liệu
                    foreach ($data as $row) {
                        $index = $row['thang'] - 1; // Lấy chỉ số tương ứng với tháng (từ 1 đến 12)
                        $revenues[$index] = $row['doanhthu']; // Gán doanh thu vào đúng tháng
                    }

                    // Truyền dữ liệu PHP sang JavaScript
                    echo "<script>window.months = " . json_encode($months) . ";</script>";
                    echo "<script>window.revenues = " . json_encode($revenues) . ";</script>";
                ?>

                <canvas id="monthlyRevenueChart"></canvas>

                <!-- Tải file JavaScript riêng -->
                <script src="bieudonam.js?v=<?php echo time() ?>"></script>
            </div>
            <!-------------------------------END OF Thống kê tiền theo biểu đồ trong 1 năm nào đó------------------------------>

             <!-------------------------------start OF sách bán chạy------------------------------>
            <div id="dstkbanchay">
                <h2>Thống Kê Sách Bán Chạy</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Sách</th>
                                <th>Tên Sách</th>
                                <th>Hình Ảnh</th>
                                <th>Số Lượng</th>
                                <th>Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classsach.php");
                                
                                $dsdonh = sach::Getbanchay();
                                if (empty($dsdonh)) {
                                    echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                                }else{
                                    foreach ($dsdonh as $itemdonh){
                            ?>
                            <tr>
                                <td><?php echo $itemdonh->masach ?></td>
                                <td><?php echo $itemdonh->tensach ?></td>
                                <td><img style="width:100px; height: 100px;" src="./img/<?php echo $itemdonh->img?>"></td>
                                <td><?php echo $itemdonh->soluong ?></td>
                                <td><?php echo $itemdonh->gianhap ?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF Thống kê sách bán chạy------------------------------>

             <!-------------------------------start OF sách sắp hết------------------------------>
            <div id="dstksachsaphet">
                <h2>Thống Kê Sách Sắp Hết</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Sách</th>
                                <th>Tên Sách</th>
                                <th>Hình Ảnh</th>
                                <th>Loại Sách</th>
                                <th>Tác Giả</th>
                                <th>NXB</th>
                                <th>Số Lượng</th>
                                <th>Giá Bán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classsach.php");
                                $timdonhang = $_POST["tktksachsaphet"] ?? "";
                                if($action == "4"){
                                    $dsdonh = sach::GetElement($timdonhang);
                                }
                                else{
                                    $dsdonh = sach::GetSapHet();}
                                if (empty($dsdonh)) {
                                    echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                                }else{
                                    foreach ($dsdonh as $itemdonh){
                            ?>
                            <tr>
                            <td><?php echo $itemdonh->masach ?></td>
                                <td><?php echo $itemdonh->tensach ?></td>
                                <td><img style="width: 100px;" src="./img/<?php echo $itemdonh->img ?>"></td>
                                <td><?php echo $itemdonh->loaisach ?></td>
                                <td><?php echo $itemdonh->tacgia ?></td>
                                <td><?php echo $itemdonh->nxb ?></td>
                                <td><?php echo $itemdonh->soluong ?></td>
                                <td><?php echo $itemdonh->giaban ?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF Thống kê sách sắp hết----------------------------->

                <!-------------------------------start OF sách khuyến mãi------------------------------>
                <div id="dstksachkhuyenmai">
                <h2>Thống Kê Sách khuyến mãi</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Sách</th>
                                <th>Tên Sách</th>
                                <th>Hình Ảnh</th>
                                <th>Loại Sách</th>
                                <th>Giá Bán</th>
                                <th>Khuyến Mãi</th>
                                <th>Giá Khuyến Mãi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classkhuyenmai.php");
                                $dsdonh = Khuyenmai::GetSachKM();
                                if (empty($dsdonh)) {
                                    echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                                }else{
                                    foreach ($dsdonh as $itemdonh){
                            ?>
                            <tr>
                            <td><?php echo $itemdonh->masach ?></td>
                                <td><?php echo $itemdonh->tensach ?></td>
                                <td><img style="width: 100px;" src="./img/<?php echo $itemdonh->img ?>"></td>
                                <td><?php echo $itemdonh->theloai ?></td>
                                <td><?php echo $itemdonh->giaban ?></td>
                                <td><?php echo $itemdonh->ptkm ."%" ?></td>
                                <td><?php echo $itemdonh->giaban * (1-$itemdonh->ptkm/100) ?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF Thống kê sách sắp hết----------------------------->

            <!-------------------------------start OF bảng chấm công------------------------------>
            <div id="dschamcong">
                <h2>Danh Sách Chấm Công</h2>
                <div class="form-container">
                    <form action="admin.php?name=chamcong&action=4" method="POST">
                        <input type="text" id="tktk" name="tkcc" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Nhân Viên</th>
                                <th>Ngày</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Thời Gian Kết Thúc</th>
                                <th>Giờ Làm Tiêu Chuẩn</th>
                                <th>Tăng Ca</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classchamcong.php");
                                $tkcc = $_POST["tkcc"] ?? "";
                                if($action == "4"){
                                    $dscc = Chamcong::GetElement($tkcc);
                                }
                                else{
                                    $dscc = Chamcong::GetAll();}
                                if (empty($dscc)) {
                                    echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                                }else{
                                    foreach ($dscc as $itemcc){
                            ?>
                            <tr>
                            <td><?php echo $itemcc->manv ?></td>
                                <td><?php echo $itemcc->ngay ?></td>
                                <td><?php echo $itemcc->tgbd ?></td>
                                <td><?php echo $itemcc->tgkt ?></td>
                                <td><?php echo $itemcc->giolamtc ?></td>
                                <td><?php echo $itemcc->tgtc ?></td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF bảng chấm công----------------------------->

            
            <!-------------------------------start OF bảng lương------------------------------>
            <div id="dsluong">
                <h2>Danh Sách Bảng Lương</h2>
                <div class="form-container">
                    <form action="admin.php?name=luong&action=4" method="POST">
                        <input type="text" id="tktk" name="tkbl" placeholder="Nhập thông tin cần tìm kiếm">
                        <input type="submit" value="search" class="material-icons" id="search">
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Nhân Viên</th>
                                <th>Tháng</th>
                                <th>Năm</th>
                                <th>Tổng Thời Gian</th>
                                <th>Tổng Tăng Ca</th>
                                <th>Lương Làm Việc</th>
                                <th>Lương Tăng Ca</th>
                                <th>Tổng Lương</th>
                                <th>Tình Trạng</th>
                                <th>Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once("classluong.php");
                                $tkbl = $_POST["tkbl"] ?? "";
                                if($action == "4"){
                                    $dsbl = Luong::GetElement($tkbl);
                                }
                                else{
                                    $dsbl = Luong::GetAll();}
                                if (empty($dsbl)) {
                                    echo "<p>Không có dữ liệu nào được tìm thấy.</p>";
                                }else{
                                    foreach ($dsbl as $iteml){
                            ?>
                            <tr>
                            <td><?php echo $iteml->manv ?></td>
                                <td><?php echo $iteml->thang ?></td>
                                <td><?php echo $iteml->nam ?></td>
                                <td><?php echo $iteml->tonggiolam ?></td>
                                <td><?php echo $iteml->giotangca ?></td>
                                <td><?php echo $iteml->luonglamviec ?></td>
                                <td><?php echo $iteml->luongtangca ?></td>
                                <td><?php echo $iteml->tongluong ?></td>
                                <td><?php echo $iteml->tinhtrang ?></td>
                                <td>
                                    <?php if ($iteml->tinhtrang == "Chưa nhận") { ?>
                                        <a href="admin.php?tieude=luong&action=2&manv=<?php echo $iteml->manv; ?>&thang=<?php echo $iteml->thang; ?>&nam=<?php echo $iteml->nam; ?>">Xác Nhận</a>
                                    <?php } else { ?>
                                        <a>Đã Hoàn Thành</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-------------------------------END OF bảng chấm công----------------------------->
        </main>
         <!-------END OF MAIN--------->
    </div>
</body>
<script src="admin.js?v=<?php echo time(); ?>"></script>
</html>