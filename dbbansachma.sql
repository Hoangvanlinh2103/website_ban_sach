-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 17, 2024 lúc 02:58 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dbbansachma`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbchamcong`
--

CREATE TABLE `tbchamcong` (
  `ID` int(11) NOT NULL,
  `MANV` varchar(10) NOT NULL,
  `NGAY` date NOT NULL DEFAULT current_timestamp(),
  `TGBD` time NOT NULL,
  `TGKT` time NOT NULL,
  `GIOLAMTC` double NOT NULL DEFAULT 0,
  `TGTC` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbchamcong`
--

INSERT INTO `tbchamcong` (`ID`, `MANV`, `NGAY`, `TGBD`, `TGKT`, `GIOLAMTC`, `TGTC`) VALUES
(1, 'NV001', '2024-11-04', '08:00:00', '17:00:00', 8, 1),
(2, 'NV002', '2024-11-04', '08:00:00', '16:00:00', 8, 0),
(3, 'NV003', '2024-11-04', '09:00:00', '17:00:00', 7, 0),
(4, 'NV004', '2024-11-04', '08:30:00', '17:30:00', 8, 1),
(5, 'NV005', '2024-11-04', '08:00:00', '15:30:00', 7, 0),
(6, 'NV006', '2024-11-04', '08:00:00', '17:30:00', 8, 1.5),
(7, 'NV007', '2024-11-04', '08:00:00', '18:00:00', 8, 2),
(8, 'NV008', '2024-11-04', '09:00:00', '17:00:00', 7, 0),
(9, 'NV009', '2024-11-04', '08:00:00', '15:30:00', 7, 0),
(10, 'NV010', '2024-11-04', '08:00:00', '16:00:00', 8, 0),
(24, 'NV001', '2024-11-05', '00:00:07', '18:00:00', 8, 3),
(25, 'NV002', '2024-11-15', '00:00:07', '15:00:00', 8, 0),
(26, 'NV001', '2024-11-15', '00:00:07', '00:00:17', 8, 2),
(27, 'NV002', '2024-11-14', '00:00:07', '00:00:17', 8, 2),
(28, 'NV001', '2024-11-14', '00:00:07', '00:00:15', 8, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbdanhgia`
--

CREATE TABLE `tbdanhgia` (
  `ID` int(11) NOT NULL,
  `MASACH` varchar(10) NOT NULL,
  `MAKH` varchar(10) NOT NULL,
  `DIEMDANHGIA` int(11) NOT NULL,
  `NOIDUNG` text NOT NULL,
  `NGAY` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbdanhgia`
--

INSERT INTO `tbdanhgia` (`ID`, `MASACH`, `MAKH`, `DIEMDANHGIA`, `NOIDUNG`, `NGAY`) VALUES
(1, 'SACH001', 'KH001', 5, 'hay', '2024-11-08'),
(2, 'SACH001', 'KH002', 4, 'Thiếu chút thì hay', '2024-11-08'),
(3, 'SACH001', 'KH009', 3, 'Tạm', '2024-11-08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbdonhangnhap`
--

CREATE TABLE `tbdonhangnhap` (
  `MADHNHAP` varchar(10) NOT NULL,
  `NGAYNHAP` date NOT NULL DEFAULT current_timestamp(),
  `MANV` varchar(10) NOT NULL,
  `MANCC` varchar(10) DEFAULT NULL,
  `TONGTIEN` double NOT NULL,
  `TINHTRANGTT` varchar(50) NOT NULL DEFAULT 'Chưa thanh toán'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbdonhangnhap`
--

INSERT INTO `tbdonhangnhap` (`MADHNHAP`, `NGAYNHAP`, `MANV`, `MANCC`, `TONGTIEN`, `TINHTRANGTT`) VALUES
('DHN001', '2024-10-01', 'NV001', 'NXB001', 1410000, 'Đã thanh toán'),
('DHN002', '2024-10-02', 'NV001', 'NXB002', 1230000, 'Đã thanh toán'),
('DHN003', '2024-10-03', 'NV001', 'NXB003', 810000, 'Đã thanh toán'),
('DHN004', '2024-10-04', 'NV002', 'NXB005', 1165000, 'Đã thanh toán'),
('DHN005', '2024-10-05', 'NV002', 'NXB004', 1215000, 'Đã thanh toán'),
('DHN006', '2024-10-06', 'NV002', 'NXB005', 720000, 'Đã thanh toán'),
('DHN007', '2024-10-07', 'NV006', 'NXB001', 1440000, 'Đã thanh toán'),
('DHN008', '2024-10-08', 'NV006', 'NXB002', 1000000, 'Đã thanh toán'),
('DHN009', '2024-10-09', 'NV006', 'NXB005', 1210000, 'Đã thanh toán'),
('DHN010', '2024-10-10', 'NV002', 'NXB004', 1270000, 'Đã thanh toán'),
('DHN011', '2024-10-30', 'NV006', NULL, 160000, 'Đã thanh toán'),
('DHN012', '2024-10-30', 'NV006', NULL, 640000, 'Đã thanh toán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbdonhangnhap_ct`
--

CREATE TABLE `tbdonhangnhap_ct` (
  `MACT` int(11) NOT NULL,
  `MADHNHAP` varchar(10) NOT NULL,
  `MASACH` varchar(10) NOT NULL,
  `SLNHAP` int(11) NOT NULL,
  `GIANHAP` double NOT NULL,
  `THANHTIEN` double NOT NULL,
  `GHICHU` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbdonhangnhap_ct`
--

INSERT INTO `tbdonhangnhap_ct` (`MACT`, `MADHNHAP`, `MASACH`, `SLNHAP`, `GIANHAP`, `THANHTIEN`, `GHICHU`) VALUES
(1, 'DHN001', 'SACH001', 10, 80000, 800000, 'Nhập hàng'),
(2, 'DHN001', 'SACH002', 5, 50000, 250000, 'Nhập hàng'),
(3, 'DHN001', 'SACH003', 6, 60000, 360000, 'Nhập hàng'),
(4, 'DHN002', 'SACH004', 7, 30000, 210000, 'Nhập hàng'),
(5, 'DHN002', 'SACH005', 8, 40000, 320000, 'Nhập hàng'),
(6, 'DHN002', 'SACH006', 10, 70000, 700000, 'Nhập hàng'),
(7, 'DHN003', 'SACH007', 5, 80000, 400000, 'Nhập hàng'),
(8, 'DHN003', 'SACH008', 10, 25000, 250000, 'Nhập hàng'),
(9, 'DHN003', 'SACH009', 8, 20000, 160000, 'Nhập hàng'),
(10, 'DHN004', 'SACH010', 5, 45000, 225000, 'Nhập hàng'),
(11, 'DHN004', 'SACH011', 8, 30000, 240000, 'Nhập hàng'),
(12, 'DHN004', 'SACH012', 7, 100000, 700000, 'Nhập hàng'),
(13, 'DHN005', 'SACH013', 10, 75000, 750000, 'Nhập hàng'),
(14, 'DHN005', 'SACH014', 5, 45000, 225000, 'Nhập hàng'),
(15, 'DHN005', 'SACH015', 4, 60000, 240000, 'Nhập hàng'),
(16, 'DHN006', 'SACH016', 8, 50000, 400000, 'Nhập hàng'),
(17, 'DHN006', 'SACH017', 6, 20000, 120000, 'Nhập hàng'),
(18, 'DHN006', 'SACH018', 5, 40000, 200000, 'Nhập hàng'),
(19, 'DHN007', 'SACH019', 7, 70000, 490000, 'Nhập hàng'),
(20, 'DHN007', 'SACH020', 10, 80000, 800000, 'Nhập hàng'),
(21, 'DHN007', 'SACH021', 5, 30000, 150000, 'Nhập hàng'),
(22, 'DHN008', 'SACH022', 6, 45000, 270000, 'Nhập hàng'),
(23, 'DHN008', 'SACH023', 8, 60000, 480000, 'Nhập hàng'),
(24, 'DHN008', 'SACH024', 5, 50000, 250000, 'Nhập hàng'),
(25, 'DHN009', 'SACH025', 10, 70000, 700000, 'Nhập hàng'),
(26, 'DHN009', 'SACH026', 6, 50000, 300000, 'Nhập hàng'),
(27, 'DHN009', 'SACH027', 7, 30000, 210000, 'Nhập hàng'),
(28, 'DHN010', 'SACH028', 6, 80000, 480000, 'Nhập hàng'),
(29, 'DHN010', 'SACH029', 5, 60000, 300000, 'Nhập hàng'),
(30, 'DHN010', 'SACH030', 7, 70000, 490000, 'Nhập hàng'),
(35, 'DHN011', 'SACH001', 2, 80000, 160000, 'Nhập hàng'),
(38, 'DHN012', 'SACH001', 8, 80000, 640000, 'Nhập hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbdonhangxuat`
--

CREATE TABLE `tbdonhangxuat` (
  `MADHXUAT` varchar(10) NOT NULL,
  `NGAYXUAT` date NOT NULL DEFAULT current_timestamp(),
  `MANV` varchar(10) DEFAULT NULL,
  `MAKH` varchar(10) DEFAULT NULL,
  `TONGTIEN` double NOT NULL DEFAULT 0,
  `TINHTRANGDH` varchar(100) NOT NULL DEFAULT 'Chưa xử lý',
  `TINHTRANGTT` varchar(50) NOT NULL DEFAULT 'Chưa thanh toán'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbdonhangxuat`
--

INSERT INTO `tbdonhangxuat` (`MADHXUAT`, `NGAYXUAT`, `MANV`, `MAKH`, `TONGTIEN`, `TINHTRANGDH`, `TINHTRANGTT`) VALUES
('DHX001', '2024-10-15', 'NV001', 'KH001', 315000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX002', '2024-10-16', 'NV001', 'KH002', 420000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX003', '2024-10-17', 'NV001', 'KH003', 509000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX004', '2024-10-18', 'NV002', 'KH004', 800000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX005', '2024-10-19', 'NV006', 'KH005', 200000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX006', '2024-10-20', 'NV002', 'KH006', 355000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX007', '2024-10-21', 'NV006', 'KH007', 90000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX008', '2024-10-22', 'NV002', 'KH008', 350000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX009', '2024-10-23', 'NV006', 'KH009', 220000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX010', '2024-10-24', 'NV002', 'KH010', 165000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX011', '2024-10-30', 'NV006', NULL, 1320000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX012', '2024-11-01', 'NV006', NULL, 150000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX013', '2024-11-01', 'NV006', NULL, 240000, 'Đã hủy', 'Chưa thanh toán'),
('DHX014', '2024-11-01', 'NV006', NULL, 120000, 'Đã hủy', 'Chưa thanh toán'),
('DHX015', '2024-11-02', 'NV006', NULL, 240000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX016', '2024-11-02', 'NV006', NULL, 180000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX017', '2024-11-02', 'NV006', NULL, 120000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX018', '2024-11-02', 'NV006', NULL, 120000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX019', '2024-11-02', 'NV006', NULL, 120000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX020', '2024-11-02', 'NV006', NULL, 120000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX021', '2024-11-02', 'NV006', NULL, 120000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX022', '2024-11-03', 'NV006', NULL, 240000, 'Đã hoàn thành', 'Đã thanh toán'),
('DHX023', '2024-11-04', 'NV006', 'KH009', 120000, 'Đã hủy', 'Chưa thanh toán'),
('DHX024', '2024-11-04', 'NV006', NULL, 108000, 'Đã hủy', 'Chưa thanh toán'),
('DHX025', '2024-11-04', 'NV006', NULL, 120000, 'Đã hủy', 'Chưa thanh toán'),
('DHX026', '2024-11-04', 'NV006', NULL, 120000, 'Đã hủy', 'Chưa thanh toán'),
('DHX027', '2024-11-07', 'NV006', 'KH009', 291000, 'Chưa xử lý', 'Chưa thanh toán'),
('DHX028', '2024-11-07', 'NV006', 'KH009', 108000, 'Chưa xử lý', 'Chưa thanh toán'),
('DHX029', '2024-11-08', 'NV006', 'KH009', 75000, 'Chưa xử lý', 'Chưa thanh toán'),
('DHX030', '2024-11-08', 'NV006', 'KH009', 369000, 'Chưa xử lý', 'Chưa thanh toán'),
('DHX031', '2024-11-10', NULL, 'KH009', 90000, 'Chưa xử lý', 'Chưa thanh toán'),
('DHX032', '2024-11-15', NULL, 'KH009', 195000, 'Chưa xử lý', 'Đã thanh toán'),
('DHX033', '2024-11-17', 'NV006', 'KH009', 120000, 'Đang xử lý', 'Chưa thanh toán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbdonhangxuat_ct`
--

CREATE TABLE `tbdonhangxuat_ct` (
  `MACT` int(11) NOT NULL,
  `MADHXUAT` varchar(10) NOT NULL,
  `MASACH` varchar(10) NOT NULL,
  `SLXUAT` int(11) NOT NULL,
  `THANHTIEN` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbdonhangxuat_ct`
--

INSERT INTO `tbdonhangxuat_ct` (`MACT`, `MADHXUAT`, `MASACH`, `SLXUAT`, `THANHTIEN`) VALUES
(1, 'DHX001', 'SACH001', 2, 240000),
(2, 'DHX001', 'SACH002', 1, 75000),
(3, 'DHX002', 'SACH005', 3, 180000),
(4, 'DHX002', 'SACH007', 2, 240000),
(5, 'DHX003', 'SACH003', 4, 360000),
(6, 'DHX003', 'SACH010', 1, 149000),
(7, 'DHX004', 'SACH012', 5, 750000),
(8, 'DHX004', 'SACH004', 1, 50000),
(9, 'DHX005', 'SACH006', 2, 200000),
(10, 'DHX006', 'SACH008', 2, 320000),
(11, 'DHX006', 'SACH009', 1, 35000),
(12, 'DHX007', 'SACH015', 1, 90000),
(13, 'DHX008', 'SACH011', 3, 150000),
(14, 'DHX008', 'SACH013', 2, 200000),
(15, 'DHX009', 'SACH016', 1, 80000),
(16, 'DHX009', 'SACH014', 2, 140000),
(17, 'DHX010', 'SACH017', 3, 105000),
(18, 'DHX010', 'SACH018', 1, 60000),
(57, 'DHX011', 'SACH001', 11, 1320000),
(58, 'DHX012', 'SACH002', 2, 150000),
(59, 'DHX013', 'SACH001', 2, 240000),
(60, 'DHX014', 'SACH005', 2, 120000),
(61, 'DHX015', 'SACH001', 2, 240000),
(62, 'DHX016', 'SACH003', 2, 180000),
(63, 'DHX017', 'SACH001', 1, 120000),
(64, 'DHX018', 'SACH001', 1, 120000),
(65, 'DHX019', 'SACH001', 1, 120000),
(66, 'DHX020', 'SACH001', 1, 120000),
(67, 'DHX021', 'SACH001', 1, 120000),
(83, 'DHX022', 'SACH001', 2, 240000),
(87, 'DHX023', 'SACH001', 1, 120000),
(88, 'DHX024', 'SACH001', 1, 120000),
(89, 'DHX025', 'SACH001', 1, 120000),
(90, 'DHX026', 'SACH001', 1, 120000),
(112, 'DHX027', 'SACH001', 2, 216000),
(113, 'DHX027', 'SACH002', 1, 75000),
(114, 'DHX028', 'SACH001', 1, 108000),
(115, 'DHX029', 'SACH002', 1, 75000),
(116, 'DHX030', 'SACH005', 1, 60000),
(117, 'DHX030', 'SACH008', 1, 160000),
(118, 'DHX030', 'SACH010', 1, 149000),
(119, 'DHX031', 'SACH003', 1, 90000),
(146, 'DHX032', 'SACH002', 1, 75000),
(147, 'DHX032', 'SACH001', 1, 120000),
(148, 'DHX033', 'SACH001', 1, 120000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbgiohang`
--

CREATE TABLE `tbgiohang` (
  `ID` int(11) NOT NULL,
  `MAKH` varchar(10) NOT NULL,
  `MASACH` varchar(10) NOT NULL,
  `SOLUONG` int(11) NOT NULL,
  `TINHTRANG` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbkhachhang`
--

CREATE TABLE `tbkhachhang` (
  `MAKH` varchar(10) NOT NULL,
  `TENKH` varchar(100) NOT NULL,
  `DIACHIKH` varchar(200) NOT NULL,
  `SDT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbkhachhang`
--

INSERT INTO `tbkhachhang` (`MAKH`, `TENKH`, `DIACHIKH`, `SDT`) VALUES
('KH001', 'Nguyễn Văn A', '123 Phố Sách, Hoàn Kiếm, Hà Nội', 123456789),
('KH002', 'Trần Thị B', '456 Đường Học, Đống Đa, Hà Nội', 987654321),
('KH003', 'Lê Văn C', '789 Đường Thư, Hai Bà Trưng, Hà Nội', 555123456),
('KH004', 'Phạm Thị D', '321 Đường Giáo Dục, Cầu Giấy, Hà Nội', 654321789),
('KH005', 'Ngô Văn E', '147 Đường Nghiên Cứu, Tây Hồ, Hà Nội', 123789456),
('KH006', 'Bùi Thị F', '258 Đường Phát Triển, Thanh Xuân, Hà Nội', 789654123),
('KH007', 'Đặng Văn G', '369 Đường Kinh Doanh, Bắc Từ Liêm, Hà Nội', 456987321),
('KH008', 'Nguyễn Thị H', '147 Đường Học Thuật, Nam Từ Liêm, Hà Nội', 321456789),
('KH009', 'Trương Văn nam', '258 Đường Sáng Tạo, Hoàng Mai, Hà Nội', 654987321),
('KH010', 'Nguyễn Văn K', '369 Đường Bán Hàng, Long Biên, Hà Nội', 159753486),
('KH011', 'Hoàng Thế A', 'Hà Nội', 968106961),
('KH012', 'Hoàng Thế A', 'Hà Nội', 968106961);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbkhuyenmai`
--

CREATE TABLE `tbkhuyenmai` (
  `MAKM` varchar(10) NOT NULL,
  `TENSK` varchar(255) NOT NULL,
  `NGAYBD` date NOT NULL,
  `NGAYKT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbkhuyenmai`
--

INSERT INTO `tbkhuyenmai` (`MAKM`, `TENSK`, `NGAYBD`, `NGAYKT`) VALUES
('KM001', '', '0000-00-00', '0000-00-00'),
('KM002', 'Khuyến mãi mới', '2024-10-21', '2024-10-30'),
('KM003', 'test', '2024-11-05', '2024-11-06'),
('KM004', 'test km', '2024-11-11', '2024-11-14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbkhuyenmai_ct`
--

CREATE TABLE `tbkhuyenmai_ct` (
  `ID` int(11) NOT NULL,
  `MAKM` varchar(10) NOT NULL,
  `MASACH` varchar(10) NOT NULL,
  `PTKM` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbkhuyenmai_ct`
--

INSERT INTO `tbkhuyenmai_ct` (`ID`, `MAKM`, `MASACH`, `PTKM`) VALUES
(1, 'KM001', 'SACH001', 0),
(2, 'KM001', 'SACH002', 0),
(3, 'KM001', 'SACH003', 0),
(4, 'KM001', 'SACH004', 0),
(5, 'KM001', 'SACH005', 0),
(6, 'KM001', 'SACH006', 0),
(7, 'KM001', 'SACH007', 0),
(8, 'KM001', 'SACH008', 0),
(9, 'KM001', 'SACH009', 0),
(10, 'KM001', 'SACH010', 0),
(11, 'KM001', 'SACH011', 0),
(12, 'KM001', 'SACH012', 0),
(13, 'KM001', 'SACH013', 0),
(14, 'KM001', 'SACH014', 0),
(15, 'KM001', 'SACH015', 0),
(16, 'KM001', 'SACH016', 0),
(17, 'KM001', 'SACH017', 0),
(18, 'KM001', 'SACH018', 0),
(19, 'KM001', 'SACH019', 0),
(20, 'KM001', 'SACH020', 0),
(21, 'KM001', 'SACH021', 0),
(22, 'KM001', 'SACH022', 0),
(23, 'KM001', 'SACH023', 0),
(24, 'KM001', 'SACH024', 0),
(25, 'KM001', 'SACH025', 0),
(26, 'KM001', 'SACH026', 0),
(27, 'KM001', 'SACH027', 0),
(28, 'KM001', 'SACH028', 0),
(29, 'KM001', 'SACH029', 0),
(30, 'KM001', 'SACH030', 0),
(31, 'KM002', 'SACH001', 15),
(32, 'KM002', 'SACH002', 15),
(33, 'KM002', 'SACH003', 15),
(34, 'KM002', 'SACH004', 15),
(35, 'KM002', 'SACH005', 15),
(36, 'KM002', 'SACH006', 15),
(37, 'KM002', 'SACH007', 15),
(38, 'KM002', 'SACH008', 15),
(39, 'KM002', 'SACH009', 15),
(40, 'KM002', 'SACH010', 15),
(41, 'KM002', 'SACH011', 15),
(42, 'KM002', 'SACH012', 15),
(43, 'KM002', 'SACH013', 15),
(44, 'KM002', 'SACH014', 15),
(45, 'KM002', 'SACH015', 15),
(46, 'KM002', 'SACH016', 15),
(47, 'KM002', 'SACH017', 15),
(48, 'KM002', 'SACH018', 15),
(49, 'KM002', 'SACH019', 15),
(50, 'KM002', 'SACH020', 15),
(51, 'KM002', 'SACH021', 15),
(52, 'KM002', 'SACH022', 15),
(53, 'KM002', 'SACH023', 15),
(54, 'KM002', 'SACH024', 15),
(55, 'KM002', 'SACH025', 15),
(56, 'KM002', 'SACH026', 15),
(57, 'KM002', 'SACH027', 15),
(58, 'KM002', 'SACH028', 15),
(59, 'KM002', 'SACH029', 15),
(60, 'KM002', 'SACH030', 15),
(61, 'KM003', 'SACH001', 10),
(62, 'KM004', 'SACH001', 25),
(63, 'KM004', 'SACH005', 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbluong`
--

CREATE TABLE `tbluong` (
  `ID` int(11) NOT NULL,
  `MANV` varchar(10) NOT NULL,
  `THANG` int(11) NOT NULL,
  `NAM` int(11) NOT NULL,
  `TONGGIOLAM` int(11) NOT NULL,
  `GIOTANGCA` int(11) NOT NULL,
  `LUONGLAMVIEC` double NOT NULL,
  `LUONGTANGCA` double NOT NULL,
  `TONGLUONG` double NOT NULL,
  `TINHTRANG` varchar(20) NOT NULL DEFAULT 'Chưa nhận'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbluong`
--

INSERT INTO `tbluong` (`ID`, `MANV`, `THANG`, `NAM`, `TONGGIOLAM`, `GIOTANGCA`, `LUONGLAMVIEC`, `LUONGTANGCA`, `TONGLUONG`, `TINHTRANG`) VALUES
(1, 'NV001', 10, 2024, 160, 20, 9600000, 1200000, 10800000, 'Chưa nhận'),
(2, 'NV002', 10, 2024, 150, 10, 9000000, 600000, 9600000, 'Chưa nhận'),
(3, 'NV003', 10, 2024, 140, 0, 7700000, 0, 7700000, 'Chưa nhận'),
(4, 'NV004', 10, 2024, 155, 15, 8525000, 825000, 9350000, 'Chưa nhận'),
(5, 'NV005', 10, 2024, 150, 0, 8250000, 0, 8250000, 'Chưa nhận'),
(6, 'NV006', 10, 2024, 160, 25, 12800000, 1875000, 14675000, 'Chưa nhận'),
(7, 'NV007', 10, 2024, 160, 30, 9600000, 1800000, 11400000, 'Chưa nhận'),
(8, 'NV008', 10, 2024, 145, 0, 8700000, 0, 8700000, 'Chưa nhận'),
(9, 'NV009', 10, 2024, 140, 0, 8400000, 0, 8400000, 'Chưa nhận'),
(10, 'NV010', 10, 2024, 150, 0, 8250000, 0, 8250000, 'Chưa nhận'),
(12, 'NV001', 11, 2024, 32, 6, 1920000, 540000, 2460000, 'Đã trả'),
(13, 'NV002', 11, 2024, 24, 2, 1440000, 180000, 1620000, 'Chưa nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbnhanvien`
--

CREATE TABLE `tbnhanvien` (
  `MANV` varchar(10) NOT NULL,
  `TENNV` varchar(100) NOT NULL,
  `DIACHINV` varchar(200) NOT NULL,
  `SDT` int(11) NOT NULL,
  `CHUCVU` varchar(50) NOT NULL,
  `LUONG` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbnhanvien`
--

INSERT INTO `tbnhanvien` (`MANV`, `TENNV`, `DIACHINV`, `SDT`, `CHUCVU`, `LUONG`) VALUES
('NV001', 'Nguyễn Văn A', '123 Đường Sách, Hoàn Kiếm, Hà Nội', 123456789, 'Nhân viên bán hàng', 60000),
('NV002', 'Trần Thị B', '456 Đường Thư, Đống Đa, Hà Nội', 987654321, 'Nhân viên bán hàng', 60000),
('NV003', 'Lê Văn C', '789 Đường Giáo Dục, Hai Bà Trưng, Hà Nội', 555123456, 'Nhân viên đóng hàng', 55000),
('NV004', 'Phạm Thị D', '321 Đường Văn Học, Cầu Giấy, Hà Nội', 654321789, 'Nhân viên sắp xếp sách', 55000),
('NV005', 'Ngô Văn E', '147 Đường Nghiên Cứu, Tây Hồ, Hà Nội', 123789456, 'Nhân viên sắp xếp sách', 55000),
('NV006', 'Bùi Thị F', '258 Đường Phát Triển, Thanh Xuân, Hà Nội', 789654123, 'Quản lý', 80000),
('NV007', 'Đặng Văn G', '369 Đường Kinh Doanh, Bắc Từ Liêm, Hà Nội', 456987321, 'Nhân viên đóng hàng', 60000),
('NV008', 'Nguyễn Thị H', '147 Đường Học Thuật, Nam Từ Liêm, Hà Nội', 321456789, 'Nhân viên bán hàng', 60000),
('NV009', 'Trương Văn I', '258 Đường Sáng Tạo, Hoàng Mai, Hà Nội', 654987321, 'Nhân viên đóng hàng', 60000),
('NV010', 'Nguyễn Văn K', '369 Đường Bán Hàng, Long Biên, Hà Nội', 159753486, 'Nhân viên sắp xếp sách', 55000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbnxb`
--

CREATE TABLE `tbnxb` (
  `MANXB` varchar(10) NOT NULL,
  `TENNXB` varchar(200) NOT NULL,
  `DIACHINXB` varchar(200) NOT NULL,
  `SDT` int(11) NOT NULL,
  `EMAILNXB` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbnxb`
--

INSERT INTO `tbnxb` (`MANXB`, `TENNXB`, `DIACHINXB`, `SDT`, `EMAILNXB`) VALUES
('NXB001', 'Nhà xuất bản Kim Đồng', 'Hà Nội, Việt Nam', 123456789, 'nxbkimdong@example.com'),
('NXB002', 'Nhà xuất bản Văn Học', 'Hồ Chí Minh, Việt Nam', 234567890, 'nxbvanhoc@example.com'),
('NXB003', 'Nhà xuất bản Trẻ', 'Đà Nẵng, Việt Nam', 345678901, 'nxbtre@example.com'),
('NXB004', 'Nhà xuất bản Thế Giới', 'Hải Phòng, Việt Nam', 456789012, 'nxbthegioi@example.com'),
('NXB005', 'Nhà xuất bản Đại Học Quốc Gia', 'Hà Nội, Việt Nam', 567890123, 'nxbduhoc@example.com'),
('NXB006', 'Nhà xuất bản lao động', 'Hà Nội, Việt Nam', 178196214, 'nxbld@example.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbsach`
--

CREATE TABLE `tbsach` (
  `MASACH` varchar(10) NOT NULL,
  `TENSACH` varchar(100) NOT NULL,
  `HINHANH` varchar(100) NOT NULL,
  `LOAISACH` varchar(100) NOT NULL,
  `TACGIA` varchar(100) NOT NULL,
  `NXB` varchar(10) NOT NULL,
  `SLSACH` int(11) NOT NULL,
  `GIANHAP` double NOT NULL,
  `GIABAN` double NOT NULL,
  `MOTA` varchar(1600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbsach`
--

INSERT INTO `tbsach` (`MASACH`, `TENSACH`, `HINHANH`, `LOAISACH`, `TACGIA`, `NXB`, `SLSACH`, `GIANHAP`, `GIABAN`, `MOTA`) VALUES
('SACH001', 'Nhà Giả Kim', 'nha_gia_kim.jpg', 'Văn học', 'Paulo Coelho', 'NXB001', 94, 80000, 120000, 'Nội dung cuốn sách kể về cậu bé chăn cừu có tên Santiago ở Tây Ban Nha, cậu muốn được khám phá mọi nơi nên đã mạnh dạn tự đi theo một cuộc hành trình của riêng mình. Điểm thú vị là trong suốt chặng đường của mình, cậu luôn mang theo bên mình một cuốn sách. Vào một tối đầy sao, khi cậu đang nằm ngủ tại một nhà thờ cũ đã đổ nát, cậu bỗng mơ thấy một giấc mơ kỳ lạ, được một người lạ như một nhà giả kim hướng dẫn và bày cách để từ Tây Ban Nha sang Kim tự tháp Ai Cập tìm kho báu. Dù chỉ là một giấc mơ mà cậu còn không biết đó là thật hay mơ và nghe có vẻ hơi hoang đường, nhưng cậu bé này vẫn quyết định đi tìm kiếm kho báu một cách thật sự.'),
('SACH002', 'Đắc Nhân Tâm', 'dac_nhan_tam.jpg', 'Tâm lý', 'Dale Carnegie', 'NXB002', 200, 50000, 75000, 'Khi ta nhắc đến cuốn sách “Đắc Nhân Tâm” của Dale Carnegie, không chỉ đơn thuần là một tác phẩm nổi tiếng mà còn là một kim chỉ nam giúp con người giao tiếp hiệu quả hơn. Sách không chỉ mang lại kiến thức về nghệ thuật kết nối mà còn mở ra những cánh cửa tư duy mới mẻ về mối quan hệ giữa con người trong xã hội hiện đại. Cuốn sách đã chuyền cảm hứng cho hàng triệu người trên khắp thế giới, với hơn 15 triệu bản được bán ra . Đây không chỉ là một con số ấn tượng, mà còn phản ánh sức hút mạnh mẽ cũng như tầm ảnh hưởng lớn lao của nó đến cách sống và cách ứng xử của từng cá nhân.'),
('SACH003', 'Dưỡng Tâm Giàu Có Dưỡng Thân Nghèo Khó', 'duong_tam_giau_co_duong_tam_ngheo_kho.jpg', 'Tâm lý', 'Nguyễn Anh Dũng', 'NXB003', 148, 60000, 90000, 'Dưỡng Tâm Giàu Có Dưỡng Thân Nghèo Khó – tác giả Nguyễn Anh Dũng, đây là một quyển sách được đánh giá tốt cũng như nhận khá nhiều lời khen từ độc giả bốn phương, bởi từng câu chuyện bình dị đời thường được kể đến, thậm chí là minh chứng về thành công vĩ đại của các doanh nhân trên thế giới từ cổ chí kim đến nay, quyển sách không chỉ mang “định nghĩa mới về sự giàu có”, hoặc giúp bạn đọc nhận thức được vốn dĩ vấn đề vây quanh cuộc sống đã đơn giản ngay từ đầu. Cũng phải nhắc đến giá trị tinh thần mà nó mang lại, như xoa dịu tâm hồn đang chán chường chính bản thân giữa ngã rẽ tương lai, sách kéo bạn trở về với bình yên, với thực tại và lối sống biết đủ là hạnh phúc.'),
('SACH004', 'Người bán hàng vĩ đại nhất thế giới', 'nguoi_ban_hang_vi_dai_nhat_the_gioi.jpg', 'Kinh doanh', 'Og Mandino', 'NXB001', 80, 30000, 50000, 'Cuốn sách Người Bán Hàng Vĩ Đại Nhất Thế Giới kể về hành trình của Hafit từ xuất thân chỉ là cậu bé chăn lạc đà cho Pathros nhưng mang trong mình ước mơ đổi đời, mong muốn trở nên vĩ đại hơn cả Pathors, trở thành một nhà buôn tài giỏi và giàu có và là người bán hàng tài năng nhất thế gian này. Nhờ có được 10 cuộn giấy da chỉ đường mà Pathros trao cho, ông đã thực hiện được ước mơ của cuộc đời mình.\r\n\r\nSau khi vượt qua được thử thách của Pathros, Hafit được Pathros trao cho một chiếc rương, bên trong là cả mười cuộn giấy da cùng chiếc túi đựng một trăm ta-lăng vàng. Số vàng này giúp Hafit đủ sống và mua được một ít thảm để bắt đầu buôn bán. Và nếu như Hafit kết hợp những thứ đã học với kinh nghiệm mà ông đã trải qua thì chắc chắn doanh thu đi buôn của ông sẽ tăng từng ngày. '),
('SACH005', 'Bên rặng tuyết sơn', 'ben-rang-tuyet-son.jpg', 'Tâm linh', 'Swami Amar Jyoti', 'NXB002', 118, 40000, 60000, 'Câu chuyện bắt đầu với hành trình của nhân vật  đến thung lũng  để học đạo. Tại đây, anh gặp một đạo sư già thông thái, và những bài học đầu tiên của  là về việc quên đi thời gian và lắng nghe âm thanh của vũ trụ. Câu chuyện diễn ra trong dãy núi Tuyết Sơn, đưa người đọc đến những giây phút bình yên và tìm hiểu về sức mạnh vĩnh hằng của thế giới tâm linh.'),
('SACH006', 'Nghệ Thuật Giao Tiếp Để Thành Công', 'nghe-thuat-giao-tiep-de-thanh-cong.jpg', 'Kỹ năng sống', 'Leil Lowndes', 'NXB003', 90, 70000, 100000, 'Bạn có bao giờ ngưỡng mộ những người thành đạt, những người “dường như có tất cả” chưa? Bạn thấy họ thật tự tin trong các cuộc gặp gỡ làm ăn hay luôn là người dẫn dắt không khí các bữa tiệc… Vì sao họ đạt được những điều đó? Cuốn sách Nghệ thuật giao tiếp để thành công với 92 thủ thuật được chắt lọc và đúc rút từ những tình huống linh hoạt trong đời sống xã hội, từ cổ chí kim sẽ trang bị cho bạn những kiến thức, kỹ năng sống và làm việc có ảnh hưởng lớn tới bước đường thành công cả đời của bạn.'),
('SACH007', 'Sapiens: Lược sử loài người', 'sapiens-luoc-su-loai-nguoi.jpg', 'Khoa học', 'Yuval Noah Harari', 'NXB002', 60, 80000, 120000, 'Là một quyển sách tóm tắt về lịch sử phát triển cũng như tiến hoá của loài người mà cụ thể là loài Sapiens(thuộc chi Homo), loài người duy nhất còn tồn tại – chúng ta. Từ một loài không đặc biệt, nằm giữa chuỗi thức ăn đến khi vươn lên tới đỉnh đứng đầu chuỗi thức ăn và trở nên nổi tiếng như “một loài sinh vật giết chóc nhất trong biên niên sử sinh học” và điều gì đã dẫn dắt chúng ta đến nền văn minh hiện tại? Bằng cách hành văn đầy sức gợi và lôi cuốn người đọc của tác giả Yuval Noah Harari, ông dẫn dắt độc giả qua các mốc sự kiện trọng đại của nhân loại qua các câu chuyện làm mình không ngừng phải suy nghĩ trong quá trình đọc quyển sách này.'),
('SACH008', 'Những kẻ xuất chúng', 'nhung-ke-xuat-chung.jpg', 'Tâm lý', 'Malcolm Gladwell', 'NXB003', 50, 80000, 160000, 'Cuốn sách Những Kẻ Xuất Chúng sẽ giúp bạn tìm ra câu trả lời thông qua các phân tích về xã hội, văn hóa và thế hệ của những nhân vật kiệt xuất như Bill Gates, Beatles và Mozart, bên cạnh những thất bại đáng kinh ngạc của một số người khác (ví dụ: Christopher Langan, người có chỉ số IQ cao hơn Einstein nhưng rốt cuộc lại quay về làm việc trong một trại ngựa). Theo đó, cùng với tài năng và tham vọng, những người thành công đều được thừa hưởng một cơ hội đặt biệt để rèn luyện kỹ năng và cho phép họ vượt lên những người cùng trang lứa.'),
('SACH009', 'Quẳng gánh lo đi và vui sống', 'quang-ganh-lo-di-va-vui-song.jpg', 'Tâm lý', 'Dale Carnegie', 'NXB001', 40, 20000, 35000, 'Bất kỳ ai đang sống đều sẽ có những lo lắng thường trực về học hành, công việc, những hoá đơn, chuyện nhà cửa,... Cuộc sống không dễ dàng giải thoát bạn khỏi căng thẳng, ngược lại, nếu quá lo lắng, bạn có thể mắc bệnh trầm cảm. Quẳng Gánh Lo Đi Và Vui Sống khuyên bạn hãy khóa chặt dĩ vãng và tương lai lại để sống trong cái phòng kín mít của ngày hôm nay. Mọi vấn đề đều có thể được giải quyết, chỉ cần bạn bình tĩnh và xác định đúng hành động cần làm vào đúng thời điểm.\r\n\r\nQuẳng Gánh Lo Đi Và Vui Sống khuyên bạn những cách để giảm thiểu lo lắng rất đơn giản như chia sẻ nó với người khác, tìm cách giải quyết vấn đề, quên tất cả những điều lo lắng nằm ngoài tầm tay,... Cố gắng thực tập điều này hàng ngày và trong cuộc sống chắc hẳn bạn sẽ thành công, có thể, không được như bạn muốn, nhưng chỉ cần bớt đi một chút phiền muộn thì cuộc sống của bạn đã có thêm một niềm vui.'),
('SACH010', 'AI TRONG CUỘC CÁCH MẠNG CÔNG NGHỆ 4.0', 'ai-trong-cuoc-cach-mang-cong-nghe-40.jpg', 'Khoa học', 'Ajay Agrawal', 'NXB006', 75, 85000, 149000, 'Cuốn sách \"AI trong cuộc cách mạng công nghệ 4.0\" là tác phẩm mang ý nghĩa khai sáng trong cuộc đua thần tốc này. Các tác giả Ajay Agrawal, Joshua Gans và Avi Goldfarb đã làm rõ ba nội dung:\r\n\r\n- Sự phát triển của AI không thực sự đem lại cho chúng ta “trí tuệ”, thay vào đó là một yếu tố quan trọng của trí tuệ: sự dự đoán\r\n\r\n- Dự đoán đem lại các dữ liệu đầu vào quan trọng cho quá trình đưa ra quyết định\r\n\r\n- Những tính năng của AI có thể dẫn đến những đánh đổi: tốc độ nhanh hơn đồng nghĩa với ít chính xác hơn; tự động hóa nhiều hơn đồng nghĩa với ít sự kiểm soát hơn; nhiều dữ liệu hơn đồng nghĩa với ít riêng tư hơn'),
('SACH011', 'NGHỆ THUẬT QUYẾN RŨ', 'nghe-thuat-quyen-ru.jpg', 'Tâm lý', 'Robert Greene', 'NXB001', 110, 30000, 50000, 'Quyến rũ là một dạng sân khấu ngoài đời, là nơi gặp gỡ giữa ảo ảnh và hiện thực, là một dạng lừa dối, nhưng con người thích được dẫn lệch hướng, họ khát khao được người khác quyến rũ. Hãy vất bỏ hết những khuynh hướng đạo đức, hãy làm theo triết lí vui vẻ của người quyến rũ, rồi bạn sẽ thấy quá trình còn lại dễ dàng và tự nhiên. Nghệ thuật Quyến rũ nhằm trang bị cho bạn vũ khí thuyết phục và hấp dẫn người khác, để những người xung quanh bạn từ từ mất khả năng chống cự mà không hiểu như thế nào và tại sao điều đó lại xảy ra. Nó là nghệ thuật chiến đấu trong thời đại tinh tế này.'),
('SACH012', 'Những người khốn khổ', 'nhung-nguoi-khon-kho.jpg', 'Văn học', 'Victor Hugo', 'NXB002', 130, 100000, 150000, '\"Khi pháp luật và phong hóa còn đày đọa con người, còn dựng nên những địa ngục giữa xã hội văn minh và đem một thứ định mệnh nhân tạo chồng thêm lên thiên mệnh; khi ba vấn đề lớn của thời đại là sự sa đọa của đàn ông vì bán sức lao động, sự trụy lạc của đàn bà vì đói khát, sự cằn cỗi của trẻ nhỏ vì tối tăm, chưa được giải quyết; khi ở một số nơi đời sống còn ngạt thở; nói khác đi, và trên quan điểm rộng hơn, khi trên mặt đất, dốt nát và đói khổ còn tồn tại, thì những cuốn sách như loại này còn có thể có ích.”'),
('SACH013', 'Bí mật tư duy triệu phú', 'bi-mat-tu-duy-trieu-phu.jpg', 'Kinh doanh', 'T. Harv Eker', 'NXB004', 95, 75000, 100000, 'Trong cuốn sách này T. Harv Eker sẽ tiết lộ những bí mật tại sao một số người lại đạt được những thành công vượt bậc, được số phận ban cho cuộc sống sung túc, giàu có, trong khi một số người khác phải chật vật, vất vả mới có một cuộc sống qua ngày. Bạn sẽ hiểu được nguồn gốc sự thật và những yếu tố quyết định thành công, thất bại để rồi áp dụng, thay đổi cách suy nghĩ, lên kế hoạch rồi tìm ra cách làm việc, đầu tư, sử dụng nguồn tài chính của bạn theo hướng hiệu quả nhất.'),
('SACH014', 'Hãy sống như ngày mai sẽ chết', 'hay-song-nhu-ngay-mai-se-chet.jpg', 'Tâm lý', 'Phi Tuyết', 'NXB001', 65, 45000, 70000, 'Trước khi đọc bài viết này của tôi, hãy bạn hãy trả lời câu hỏi phía tiêu đề trước đã nhé.\r\n\r\nSao rồi? Bạn có thể trả lời được không? Nếu có thì xin chúc mừng vì bạn đã biết rõ mục tiêu và định hướng của mình. Còn nếu câu trả lời là không hoặc vẫn còn mơ hồ, tôi khuyến khích bạn nên đọc Sống Như Ngày Mai Sẽ Chết của tác giả Phi Tuyết để có thêm động lực tìm kiếm trọng tâm cuộc sống bạn muốn hướng tới. Theo tôi cuốn sách này phù hợp với mọi thành phần trong giới trẻ Việt Nam: từ sinh viên đang đi học đại học, đến người đã đi làm nhưng vẫn đang đặt dấu hỏi to tướng cho cuộc đời mình, rằng “vì sao mình lại đến Trái Đất?” Đặc biệt, những người đã chai lì với các câu khuyên răn tuổi trẻ nên làm cái nọ cái kia nhưng vẫn chưa chịu đứng dậy tạo sự thay đổi cho bản thân thì càng nên đọc những lời Phi Tuyết viết trong cuốn sách này.'),
('SACH015', 'LẬP BẢN ĐỒ TƯ DUY', 'lap-ban-do-tu-duy.jpg', 'Giáo dục', 'Tony Buzan', 'NXB006', 40, 60000, 90000, '\"Lập Bản Đồ Tư Duy\" là một cuốn sách nhỏ nhưng mang đến nhiều kiến thức hữu ích, giúp bạn sắp xếp và giải quyết các công việc từng bước nhanh chóng và thuận lợi hơn. Không chỉ nhắc đến những bản đồ trong công việc hay học tập, cuốn sách này còn hướng dẫn người đọc lên kế hoạch cho những kỳ nghỉ hay thậm chí là những ngày kỷ niệm quan trọng.'),
('SACH016', 'Kỷ Nguyên Trí Tuệ Nhân Tạo', 'ky-nguyen-tri-tue-nhan-tao.jpg', 'Công nghệ', 'Nhiều tác giả', 'NXB005', 85, 50000, 80000, 'Một ngày của nhân viên văn phòng thành phố, ngoài thời gian dành cho ngủ nghỉ, thì có hơn 60% thời gian dành để cho giao tiếp xã giao và xử lý những công việc mưu sinh mang tính quy trình, chỉ có khoảng 10% thời gian dành cho bản thân. Ngày nay, các nhà nghiên cứu trong lĩnh vực khoa học công nghệ đang nỗ lực để cho máy móc có được “trí tuệ” giống như con người, đồng thời để cho hoạt động con người được “thông tin hóa”. Những công việc mà trước đây bạn cho rằng chỉ có con người mới làm được, chẳng hạn như lái xe, phiên dịch, giảng bài, thậm chí là chẩn đoán, điều trị bệnh, thì bây giờ đều có thể giao cho máy móc. Đồng thời, máy móc cũng có thể thu nhận, truyền tải, phân tích hoạt động của con người, sau đó đưa ra những phản hồi, nhằm nâng cao hiệu quả công việc.'),
('SACH017', 'Sách Cẩm Nang Hướng Dẫn Du Lịch Việt Nam', 'cam-nang-huong-dan-du-lich-vn.jpg', 'Du lịch', 'Nhiều tác giả', 'NXB004', 70, 20000, 35000, 'Cẩm Nang Hướng Dẫn Du Lịch Việt Nam Việt Nam là đất nước có bề dày lịch sử, đa dạng dân tộc, nhiều lễ hội, nhiều món ăn ngon, phong tục tập quán mỗi vùng miền cũng biến đổi độc đáo, phong phú. Trong những năm qua, du lịch Việt Nam đang trên đà phát triển, lượng khách quốc tế đến cũng như kháchdu lịch nội địa ngày càng tăng.Du lịch Việt Nam ngày càng được biết đến nhiều hơn trên thế giới, nhiều điểm đến trong nước được bình chọn là địa chỉ yêu thích của du khách quốc tế.Du lịch đang ngày càng nhận được sự quan tâm của toàn xã hội. Chất lượng du lịch Việt Nam đang dần tốt lên, đi vào chiều sâu thay vì chiều rộng theo đúng định hướng trong Chiến lược phát triển du lịch Việt Nam “Phát triển du lịch trở thành ngành kinh tế mũi nhọn, du lịch chiếm tỷ trọng ngày càng cao trong cơ cấu GDP, tạo động lực thúc đẩy phát triển kinh tế - xã hội.'),
('SACH018', 'Hành trình về phương Đông', 'hanh-trinh-ve-phuong-dong.jpg', 'Văn học', 'Dr. Blair T. Spalding', 'NXB002', 50, 40000, 60000, ''),
('SACH019', 'Dạy Con Làm Giàu', 'day-con-lam-giau.jpg', 'Kỹ năng sống', 'Sharon L. Lechter, Robert T. Kiyosaki', 'NXB001', 45, 70000, 95000, 'Dạy Con Làm Giàu là bộ sách gồm 13 tập được viết bởi tác giả Robert T.Kiyosaki và Sharon L.Lechter, là bộ sách được rất nhiều bạn trẻ yêu thích và nằm trong top những cuốn sách nên đọc. Bộ sách “kinh điển” này viết về quản lý tài chính cá nhân, được viết theo lối kể những câu chuyện của chính tác giả nhằm làm người đọc thấy vấn đề tài chính thật thú vị.'),
('SACH020', 'Tư Duy Nhanh Và Chậm', 'tu-duy-nhanh-va-cham.jpg', 'Tâm lý', 'Daniel Kahneman', 'NXB005', 100, 80000, 120000, 'Chúng ta thường tự cho rằng con người là sinh vật có lý trí mạnh mẽ, khi quyết định hay đánh giá vấn đề luôn kĩ lưỡng và lý tính. Nhưng sự thật là, dù bạn có cẩn trọng tới mức nào, thì trong cuộc sống hàng ngày hay trong vấn đề liên quan đến kinh tế, bạn vẫn có những quyết định dựa trên cảm tính chủ quan của mình. Thinking fast and slow, cuốn sách nổi tiếng tổng hợp tất cả nghiên cứu được tiến hành qua nhiều thập kỷ của nhà tâm lý học từng đạt giải Nobel Kinh tế Daniel Kahneman sẽ cho bạn thấy những sư hợp lý và phi lý trong tư duy của chính bạn. Cuốn sách được đánh giá là “kiệt tác” trong việc thay đổi hành vi của con người, Thinking fast and slow đã dành được vô số giải thưởng danh giá, lọt vào Top 11 cuốn sách kinh doanh hấp dẫn nhất năm 2011. Alpha Books đã mua bản quyền và sẽ xuất bản cuốn sách trong Quý 1 năm nay. Thinking fast and slow dù là cuốn sách có tính hàn lâm cao nhưng vô cùng bổ ích với tất cả mọi người và đặc biệt rất dễ hiểu và vui nhộn.'),
('SACH021', 'Nửa Mặt Trời Vàng', 'nua_mat_troi_vang.jpg', 'Tiểu thuyết', 'Chimamanda Ngozi Adichie', 'NXB003', 60, 100000, 220000, 'Câu chuyện tập trung vào hai chị em sinh đôi, Olanna và Kainene, con của giới tinh hoa, đối diện với sự thất vọng và phản bội trong cuộc chiến tranh. Hai chị em theo đuổi con đường riêng của mình, với những thách thức và đau thương khác nhau.\r\n\r\nCuộc đời của họ bị thay đổi bởi chiến tranh, khiến họ đối mặt với cảm giác nghèo khó và thiếu thốn. Tình yêu, lòng trung thành, và sự hy sinh ngày càng trở nên phức tạp và cảm xúc.\r\n\r\nChimamanda Ngozi Adichie đã kể câu chuyện qua ba góc nhìn khác nhau: Ugwu, một chú bé nhà quê 13 tuổi, Olanna – người phụ nữ thượng lưu từ Biafra, và Richard – một nhà báo Anh. Mỗi góc nhìn đều tạo ra sự chân thực và sâu sắc về cuộc sống trong thời kỳ xung đột.\r\n\r\nNhững tình tiết sắc bén về kinh tế, sắc tộc, văn hóa, và tôn giáo của Nigeria được tái hiện một cách chân thực và cảm động trong cuốn tiểu thuyết này. Đây thực sự là một tác phẩm đầy cảm xúc, đong đầy dấu ấn lịch sử và nhân văn mà bạn không thể bỏ qua.Một nền văn học độc đáo và phong phú đến từ Nigeria, '),
('SACH022', 'KHỞI NGHIỆP TINH GỌN', 'khoi-nghiep-tinh-gon.jpg', 'Kinh doanh', 'Eric Ries', 'NXB002', 90, 45000, 70000, 'Cuốn sách \"Khởi nghiệp Tinh gọn\" (The Lean Startup) trình bày một mô hình khởi nghiệp vang danh toàn cầu, giúp thay đổi toàn bộ cách thức xây dựng công ty và tung ra sản phẩm mới trên thị trường.\r\n\r\n“Khởi nghiệp” - hai tiếng đơn giản đó có sức hút mạnh mẽ với bất kỳ ai, không chỉ đối với những người đang ấp ủ một dự án kinh doanh, mà ngay cả những ông chủ đang muốn tìm kiếm một sản phẩm hay một ý tưởng mới để “tái khởi nghiệp”, nói cách khác là tái tạo lại mô hình kinh doanh của mình. Tuy nhiên, từ ý tưởng đến thành công là điều không dễ!\r\n\r\nNhiều dự án khởi nghiệp thất bại không phải vì ý tưởng không tốt, chiến lược kém hay tầm nhìn sai, mà cốt lõi của mọi vấn đề nằm ở chỗ chúng ta không có được một mô hình và phương pháp để khởi nghiệp thành công. Vì khởi nghiệp không giống với thành lập và điều hành một công ty theo dạng truyền thống, nên nó cần một mô hình và phương pháp quản trị riêng.'),
('SACH023', 'Thế giới phẳng', 'the-gioi-phang.jpg', 'Kinh doanh', 'Thomas Friedman', 'NXB004', 75, 60000, 85000, 'Toàn cầu hóa là chủ đề vốn phức tạp và thu hút sự quan tâm của dư luận với không ít những ý kiến trái ngược nhau, được Thomas L.Friedman phân tích một cách độc đáo, với lập luận trung tâm về quá trình “trở nên phẳng” của thế giới. Khái niệm “phẳng” ở đây đồng nghĩa với “sự kết nối”. Những dở bỏ rào cản về chính trị cùng với những tiến bộ vượt bậc của cách mạng số đang làm cho thế giới “phẳng ra” và không còn nhiều trở ngại về địa lý như trước. Điều này mở ra cho các nước những phương thức sản xuất kinh doanh, những tình thế địa chính trị và địa kinh tế hoàn toàn mới.'),
('SACH024', 'Cách nuôi dạy trẻ thông minh', 'cam-nang-nuoi-day-con.jpg', 'Giáo dục', 'Maria Montessori', 'NXB003', 50, 50000, 90000, 'Cuốn sách giúp các bậc phụ huynh hiểu và nắm bắt có hiệu quả tinh thần thực sự của phương pháp giáo dục Montessori. Từ đó, lựa chọn được cách giáo dục phù hợp nhất cho con mình, để con có thể trưởng thành với tính cách vui vẻ, mạnh khỏe, độc lập, và biết yêu thương\r\n\r\nHiện nay, phương pháp giáo dục Montessori đang dần trở nên phổ biến và được nhiều người đón nhận, đặc biệt là các bậc phụ huynh có con trong độ tuổi mầm non.'),
('SACH025', 'NGOẠI TÌNH', 'ngoai-tinh.jpg', 'Văn học', 'Paulo Coelho', 'NXB005', 65, 70000, 100000, 'Ngoại tình là câu chuyện xoay quanh người phụ nữ Linda. Ở tuổi 31, cô có mọi thứ một người phụ nữ cần để cảm thấy viên mãn: người chồng thành đạt và yêu thương cô, hai đứa con ngoan, sự nghiệp ổn định và cuộc sống vật chất đầy đủ. Nhưng sự hoàn hảo đó chỉ là vẻ bề ngoài, thâm tâm Linda luôn đối diện với một nỗi sợ mơ hồ: vừa sợ chuỗi hành động lặp lại ngày này qua tháng khác, vừa sợ sự đời đổi thay bất ngờ khiến mình tay trắng.\r\n\r\nVậy thì ngoại tình liệu có phải là giải pháp tốt nhất cho Linda lúc này không?\r\n\r\nNgười ta vẫn thường nói hôn nhân giết chết tình yêu. Sự lặp lại những công việc hàng ngày khiến bạn chán nản. Mặt khác, bạn biết rằng đời vốn vô thường, giây phút yên bình này có thể biến mất bất cứ lúc nào. Trên các phương tiện đại chúng, các cặp tình nhân nổi tiếng ly dị, chia tay. Nó khiến bạn sợ hãi và mất niềm tin, Linda trong Ngoại tình cũng thế.'),
('SACH026', 'Tư Duy Rành Mạch', 'tu-duy-ranh-mach.png', 'Kỹ năng sống', 'Shane Parrish', 'NXB001', 80, 70000, 150000, 'Bạn đã tin rằng mình có thể tư duy rành mạch vào những thời điểm quan trọng. Nhưng rất có thể dưới áp lực tăng cao, bạn chẳng suy nghĩ được gì cả. Và những hành động tiếp theo của bạn chắc chắn sẽ đẩy bạn đi xa hơn khỏi những thứ mà bạn tìm kiếm – tình yêu, thành công, giàu có, chiến thắng. Theo Shane Parrish, chúng ta phải nhận ra những cơ hội đến với mình theo đúng như bản chất của chúng và triển khai khả năng nhận thức của mình để đạt được cuộc sống mà chúng ta mong muốn.\r\n\r\nCuốn sách “Tư duy rành mạch” cung cấp cho bạn các công cụ để nhận ra những khoảnh khắc có khả năng biến đổi cuộc sống và định hình lại cách bạn điều hướng cách bản thân phản ứng trước mỗi kích thích mình gặp phải. Chúng ta có thể đang tưởng tượng mình là nhân vật chính trong câu chuyện cuộc đời mình, nhưng sự thật đáng buồn là hầu hết chúng ta đều hành động như thể đang tuân theo chế độ lái tự động.'),
('SACH027', 'NHỮNG QUY LUẬT CỦA BẢN CHẤT CON NGƯỜI', 'nhung-quy-luat-cua-ban-chat-con-nguoi.jpg', 'Tâm lý', 'Robert Greene', 'NXB002', 40, 50000, 100000, 'Trong cuốn sách này, Robert Greene tìm cách… biến độc giả thành một ‘quan sát viên điềm tĩnh hơn và có đầu óc chiến lược hơn’, miễn nhiễm với ‘bi kịch cảm xúc’. Đó là những hứa hẹn khá cao, nhưng ngay cả những kẻ hoài nghi cũng sẽ trở thành những người tin tưởng sau khi đọc kỹ tác phẩm chỉnh chu của ông. Việc vượt qua ‘quy luật của sự thiếu sáng suốt’, chẳng hạn, dẫn tới khả năng ‘mở rộng tâm trí bạn ra trước những gì thật sự đang diễn ra, trái hẳn với những gì bạn cảm thấy’. Điều tra thận trọng của Robert Greene về cái tôi và xã hội sẽ mang tới cho độc giả trung thành một quan điểm mới mẻ và tràn đầy sức sống.'),
('SACH028', 'Cú Hích', 'cu-hich.jpg', 'Kinh tế', 'Richard Thaler', 'NXB004', 70, 80000, 120000, '“Cú hích” không chỉ đơn thuần là từ ngữ, mà còn chứa trong nó một cảm giác kỳ diệu, mô tả những thay đổi nhỏ tưởng chừng vô hại, nhưng lại ẩn sau đó sức mạnh thay đổi lớn lao trong hành vi của chúng ta. Đó có thể là một cái gật đầu nhẹ từ môi trường xung quanh, một lời khuyên nhỏ nhặt từ thông tin nhỏ bé, hoặc thậm chí là một bản lựa chọn thứ hai nhưng được thúc đẩy hơn.\r\n\r\nThaler và Sunstein đi sâu vào bản chất của cuộc sống, khám phá ra rằng chúng ta, con người, thường xuyên tự gây khó khăn cho bản thân bằng cách những quyết định ngớ ngẩn. Chúng ta như những chiếc máy tính dồi dào thông tin nhưng lại bị hạn chế bởi bộ xử lý tối đa. Những thông tin vượt quá ngưỡng của chúng ta, tạo nên cản trở và ảnh hưởng từ lối suy nghĩ đến tâm trạng.\r\n\r\nNhưng đó là lúc “Cú hích” xuất hiện, như một phép màu đang chờ được khám phá. Cú hích là chìa khóa mở cánh cửa cho quyết định thông minh hơn, loại bỏ những rào cản không cần thiết, giúp ta nhận biết điều quan trọng và bám vào nó, như ánh sáng bắt mắt trong bóng tối. Nhờ nó, ta dễ dàng hơn trong việc đối mặt với thiên kiến, làm cho lựa chọn trở nên nhẹ nhàng hơn, không còn rắc rối.\r\n\r\nTrang sách “Cú hích” đã gọi vang từ góc này đến góc khác thế giới, không những dừng lại ở những trang sách mà còn trở thành hướng dẫn sáng suốt cho các tay chỉ huy chính trị, doanh nhân thâm trầm và cả những tâm hồn yêu thương phi lợi nhuận. Tác phẩm này đã gắn kết mạch suy nghĩ của loài người với việc thiết kế lựa chọn thông minh và môi trường thân thiện, tạo động lực cho hành vi tốt đẹp hơn.'),
('SACH029', '5 Ngôn Ngữ Yêu Thương', '5-ngon-ngu-yeu-thuong.jpg', 'Tâm lý', 'Gary Chapman', 'NXB001', 55, 60000, 90000, 'Tình yêu là điều kỳ diệu, là niềm hạnh phúc, là sự trọn vẹn thuộc về nhau mà bạn, tôi, và tất cả chúng ta nâng niu vun đắp từng ngày. Từ những đôi lứa đang yêu đến những cặp vợ chồng dù son trẻ hay “răng long đầu bạc”, chúng ta luôn nuôi dưỡng và gìn giữ tình yêu của mình bằng sự thấu hiểu thể hiện qua ngôn ngữ của tình yêu.\r\n\r\nTheo Gary Chapman, đó chính là cách thể hiện cảm xúc thiêng liêng, tinh tế nhất của những kẻ yêu nhau, một bí ẩn mà ai cũng muốn khám phá và áp dụng để tạo ra nguồn hạnh phúc bất tận cho tình yêu của mình. 5 Ngôn Ngữ Yêu Thương của Gary Chapman sẽ hé mở cho bạn một điều thú vị rằng, mỗi người trong chúng ta đều có một “ngôn ngữ tình yêu” khác nhau. Khi hiểu được sự khác biệt ấy và biết cách sử dụng đúng ngôn ngữ tình yêu của mình, các bạn sẽ xây dựng được một nền tảng vững chắc cho tình yêu và một gia đình hạnh phúc, nơi cả hai đều cảm thấy mình được quan tâm, yêu thương và chia sẻ trong sự ấm áp, nồng nàn của tình yêu.'),
('SACH030', 'Chinh phục đỉnh cao', 'vi-dai-do-lua-chon.jpg', 'Kinh doanh', 'Jim Collins', 'NXB005', 85, 70000, 95000, 'Jim Collins là tác giả của hai đầu sách nổi tiếng – Từ tốt đến vĩ đại và Xây dựng để trường tồn. Cùng với phương pháp nghiên cứu như hai cuốn đầu tiên, trong quyển sách này, Jim Collins cùng với Morten T. Hansen đi tìm câu trả lời cho câu hỏi, tại sao các công ty vĩ đại vẫn trường tồn trong những lúc khó khăn, hỗn loạn. Qua rất nhiều năm nghiên cứu khoa học từ những công ty và các lãnh đạo hàng đầu, hai tác giả rút ra được kết luận rằng: Chúng tôi không tin cuộc sống sẽ trở nên tốt đẹp hơn hay có một phép nhiệm mầu và đoán định được tương lai, nhưng có thể nói những tác động phức tạp, toàn cầu hóa và công nghệ đang thúc đẩy thay đổi và càng dễ bị thay đổi hơn bao giờ hết. Chúng tôi cảm thấy trấn tĩnh vì chúng tôi đã hiểu hơn phải có những gì để sống sót, lèo lái và chiến thắng. Theo chúng tôi, trường tồn và tiêu vong phụ thuộc vào những hành động của chúng ta hơn là những gì mà thế giới gây cho chúng ta; và sự vĩ đại không chỉ là một cuộc chinh phục về kinh doanh, nó là cuộc chinh phục của con người.\r\n\r\nVà kết quả nghiên cứu sẽ gây bất ngờ cho nhiều nhà lãnh đạo các tổ chức đọc quyển sách này: Những nhà lãnh đạo của các công ty vĩ đại không sáng tạo hơn, không có tầm nhìn xa hơn, không có cá tính hơn, không có vận may hơn, không thích tìm kiếm rủi ro hơn, không anh hùng hơn, và không có khuynh hướng thực hiện những nước cờ lớn, táo bạo hơn. Nhưng họ đã lèo lái được công ty họ qua những lúc khó khăn để luôn trường tồn, bởi vì họ sống và làm việc theo ba yếu tố cân bằng nhau: kiên định với nguyên tắc, sáng tạo theo kinh nghiệm và biết sợ hãi một cách hữu ích.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbtaikhoan`
--

CREATE TABLE `tbtaikhoan` (
  `USERNAME` varchar(100) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `ROLE` varchar(50) NOT NULL,
  `MAKH` varchar(10) DEFAULT NULL,
  `MANV` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbtaikhoan`
--

INSERT INTO `tbtaikhoan` (`USERNAME`, `PASSWORD`, `ROLE`, `MAKH`, `MANV`) VALUES
('admin', '123', 'admin', NULL, 'NV006'),
('nva', '123', 'Nhân Viên', NULL, 'NV001'),
('vuviet110703@gmail.com', '123', 'Khách Hàng', 'KH009', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbthanhtoan_nhaphang`
--

CREATE TABLE `tbthanhtoan_nhaphang` (
  `ID` int(11) NOT NULL,
  `DHN` varchar(10) NOT NULL,
  `NGAYTT` date NOT NULL DEFAULT current_timestamp(),
  `TONGTIEN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbthanhtoan_nhaphang`
--

INSERT INTO `tbthanhtoan_nhaphang` (`ID`, `DHN`, `NGAYTT`, `TONGTIEN`) VALUES
(1, 'DHN001', '2024-10-22', 1410000),
(2, 'DHN002', '2024-10-22', 1230000),
(3, 'DHN003', '2024-10-22', 810000),
(4, 'DHN004', '2024-10-22', 1165000),
(5, 'DHN005', '2024-10-22', 1215000),
(6, 'DHN006', '2024-10-22', 720000),
(7, 'DHN007', '2024-10-22', 1440000),
(8, 'DHN008', '2024-10-22', 1000000),
(9, 'DHN009', '2024-10-22', 1210000),
(10, 'DHN010', '2024-10-22', 1270000),
(16, 'DHN011', '2024-10-30', 160000),
(17, 'DHN012', '2024-10-30', 640000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbthanhtoan_xuathang`
--

CREATE TABLE `tbthanhtoan_xuathang` (
  `ID` int(11) NOT NULL,
  `DHX` varchar(10) NOT NULL,
  `NGAYTT` date NOT NULL DEFAULT current_timestamp(),
  `TONGTIEN` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbthanhtoan_xuathang`
--

INSERT INTO `tbthanhtoan_xuathang` (`ID`, `DHX`, `NGAYTT`, `TONGTIEN`) VALUES
(1, 'DHX001', '2024-10-22', 315000),
(2, 'DHX002', '2024-10-22', 420000),
(3, 'DHX003', '2024-10-22', 509000),
(4, 'DHX004', '2024-10-22', 800000),
(5, 'DHX005', '2024-10-22', 200000),
(6, 'DHX006', '2024-10-22', 355000),
(7, 'DHX007', '2024-10-22', 90000),
(8, 'DHX008', '2024-10-22', 350000),
(9, 'DHX009', '2024-10-22', 220000),
(10, 'DHX010', '2024-10-22', 165000),
(18, 'DHX011', '2024-10-30', 1320000),
(19, 'DHX012', '2024-11-01', 150000),
(20, 'DHX015', '2024-11-02', 240000),
(21, 'DHX016', '2024-11-02', 180000),
(22, 'DHX017', '2024-11-02', 120000),
(23, 'DHX018', '2024-11-02', 120000),
(24, 'DHX019', '2024-11-02', 120000),
(25, 'DHX020', '2024-11-02', 120000),
(26, 'DHX021', '2024-11-02', 120000),
(27, 'DHX022', '2024-11-04', 240000),
(37, 'DHX032', '2024-11-15', 195000);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbchamcong`
--
ALTER TABLE `tbchamcong`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_tbchamcong_tbnhanvien` (`MANV`);

--
-- Chỉ mục cho bảng `tbdanhgia`
--
ALTER TABLE `tbdanhgia`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FB_tbdanhgia_tbkhachhang` (`MAKH`),
  ADD KEY `FK_tbdanhgia_tbsach` (`MASACH`);

--
-- Chỉ mục cho bảng `tbdonhangnhap`
--
ALTER TABLE `tbdonhangnhap`
  ADD PRIMARY KEY (`MADHNHAP`),
  ADD KEY `FK_tbdonhangnhap_tbnhanvien` (`MANV`),
  ADD KEY `FK_tbdonhangnhap_tbnxb` (`MANCC`);

--
-- Chỉ mục cho bảng `tbdonhangnhap_ct`
--
ALTER TABLE `tbdonhangnhap_ct`
  ADD PRIMARY KEY (`MACT`),
  ADD KEY `FK_tbdonhangnhapct_tbdonhangnhap` (`MADHNHAP`),
  ADD KEY `FK_tbdonhangnhapct_tbsach` (`MASACH`);

--
-- Chỉ mục cho bảng `tbdonhangxuat`
--
ALTER TABLE `tbdonhangxuat`
  ADD PRIMARY KEY (`MADHXUAT`),
  ADD KEY `FK_tbdonhangxuat_tbkhachhang` (`MAKH`),
  ADD KEY `FK_tbdonhangxuat_tbnhanvien` (`MANV`);

--
-- Chỉ mục cho bảng `tbdonhangxuat_ct`
--
ALTER TABLE `tbdonhangxuat_ct`
  ADD PRIMARY KEY (`MACT`),
  ADD KEY `FK_tbdonhangxuatct_tbdonhangxuat` (`MADHXUAT`),
  ADD KEY `FK_tbdonhangxuat_tbsach` (`MASACH`);

--
-- Chỉ mục cho bảng `tbgiohang`
--
ALTER TABLE `tbgiohang`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_tbgiohang_tbkhachhang` (`MAKH`),
  ADD KEY `FK_tbgiohang_tbsach` (`MASACH`);

--
-- Chỉ mục cho bảng `tbkhachhang`
--
ALTER TABLE `tbkhachhang`
  ADD PRIMARY KEY (`MAKH`);

--
-- Chỉ mục cho bảng `tbkhuyenmai`
--
ALTER TABLE `tbkhuyenmai`
  ADD PRIMARY KEY (`MAKM`);

--
-- Chỉ mục cho bảng `tbkhuyenmai_ct`
--
ALTER TABLE `tbkhuyenmai_ct`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_tbkhuyenmaict_tbkhuyenmai` (`MAKM`);

--
-- Chỉ mục cho bảng `tbluong`
--
ALTER TABLE `tbluong`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_tbluong_tbnhanvien` (`MANV`);

--
-- Chỉ mục cho bảng `tbnhanvien`
--
ALTER TABLE `tbnhanvien`
  ADD PRIMARY KEY (`MANV`);

--
-- Chỉ mục cho bảng `tbnxb`
--
ALTER TABLE `tbnxb`
  ADD PRIMARY KEY (`MANXB`);

--
-- Chỉ mục cho bảng `tbsach`
--
ALTER TABLE `tbsach`
  ADD PRIMARY KEY (`MASACH`),
  ADD KEY `FK_tbsach_tbnxb` (`NXB`);

--
-- Chỉ mục cho bảng `tbtaikhoan`
--
ALTER TABLE `tbtaikhoan`
  ADD PRIMARY KEY (`USERNAME`),
  ADD KEY `FK_tbtaikhoan_tbkhachhang` (`MAKH`),
  ADD KEY `FK_tbtaikhoan_tbnhanvien` (`MANV`);

--
-- Chỉ mục cho bảng `tbthanhtoan_nhaphang`
--
ALTER TABLE `tbthanhtoan_nhaphang`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_tbthanhtoannhap_tbdonhangnhap` (`DHN`);

--
-- Chỉ mục cho bảng `tbthanhtoan_xuathang`
--
ALTER TABLE `tbthanhtoan_xuathang`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_tbthanhtoanxuat_tbdonhangxuat` (`DHX`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbchamcong`
--
ALTER TABLE `tbchamcong`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `tbdanhgia`
--
ALTER TABLE `tbdanhgia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tbdonhangnhap_ct`
--
ALTER TABLE `tbdonhangnhap_ct`
  MODIFY `MACT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `tbdonhangxuat_ct`
--
ALTER TABLE `tbdonhangxuat_ct`
  MODIFY `MACT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT cho bảng `tbgiohang`
--
ALTER TABLE `tbgiohang`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tbkhuyenmai_ct`
--
ALTER TABLE `tbkhuyenmai_ct`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `tbluong`
--
ALTER TABLE `tbluong`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `tbthanhtoan_nhaphang`
--
ALTER TABLE `tbthanhtoan_nhaphang`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `tbthanhtoan_xuathang`
--
ALTER TABLE `tbthanhtoan_xuathang`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbchamcong`
--
ALTER TABLE `tbchamcong`
  ADD CONSTRAINT `FK_tbchamcong_tbnhanvien` FOREIGN KEY (`MANV`) REFERENCES `tbnhanvien` (`MANV`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbdanhgia`
--
ALTER TABLE `tbdanhgia`
  ADD CONSTRAINT `FB_tbdanhgia_tbkhachhang` FOREIGN KEY (`MAKH`) REFERENCES `tbkhachhang` (`MAKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbdanhgia_tbsach` FOREIGN KEY (`MASACH`) REFERENCES `tbsach` (`MASACH`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbdonhangnhap`
--
ALTER TABLE `tbdonhangnhap`
  ADD CONSTRAINT `FK_tbdonhangnhap_tbnhanvien` FOREIGN KEY (`MANV`) REFERENCES `tbnhanvien` (`MANV`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbdonhangnhap_tbnxb` FOREIGN KEY (`MANCC`) REFERENCES `tbnxb` (`MANXB`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbdonhangnhap_ct`
--
ALTER TABLE `tbdonhangnhap_ct`
  ADD CONSTRAINT `FK_tbdonhangnhapct_tbdonhangnhap` FOREIGN KEY (`MADHNHAP`) REFERENCES `tbdonhangnhap` (`MADHNHAP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbdonhangnhapct_tbsach` FOREIGN KEY (`MASACH`) REFERENCES `tbsach` (`MASACH`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbdonhangxuat`
--
ALTER TABLE `tbdonhangxuat`
  ADD CONSTRAINT `FK_tbdonhangxuat_tbkhachhang` FOREIGN KEY (`MAKH`) REFERENCES `tbkhachhang` (`MAKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbdonhangxuat_tbnhanvien` FOREIGN KEY (`MANV`) REFERENCES `tbnhanvien` (`MANV`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbdonhangxuat_ct`
--
ALTER TABLE `tbdonhangxuat_ct`
  ADD CONSTRAINT `FK_tbdonhangxuat_tbsach` FOREIGN KEY (`MASACH`) REFERENCES `tbsach` (`MASACH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbdonhangxuatct_tbdonhangxuat` FOREIGN KEY (`MADHXUAT`) REFERENCES `tbdonhangxuat` (`MADHXUAT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbgiohang`
--
ALTER TABLE `tbgiohang`
  ADD CONSTRAINT `FK_tbgiohang_tbkhachhang` FOREIGN KEY (`MAKH`) REFERENCES `tbkhachhang` (`MAKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbgiohang_tbsach` FOREIGN KEY (`MASACH`) REFERENCES `tbsach` (`MASACH`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbkhuyenmai_ct`
--
ALTER TABLE `tbkhuyenmai_ct`
  ADD CONSTRAINT `FK_tbkhuyenmaict_tbkhuyenmai` FOREIGN KEY (`MAKM`) REFERENCES `tbkhuyenmai` (`MAKM`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbluong`
--
ALTER TABLE `tbluong`
  ADD CONSTRAINT `FK_tbluong_tbnhanvien` FOREIGN KEY (`MANV`) REFERENCES `tbnhanvien` (`MANV`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbsach`
--
ALTER TABLE `tbsach`
  ADD CONSTRAINT `FK_tbsach_tbnxb` FOREIGN KEY (`NXB`) REFERENCES `tbnxb` (`MANXB`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbtaikhoan`
--
ALTER TABLE `tbtaikhoan`
  ADD CONSTRAINT `FK_tbtaikhoan_tbkhachhang` FOREIGN KEY (`MAKH`) REFERENCES `tbkhachhang` (`MAKH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tbtaikhoan_tbnhanvien` FOREIGN KEY (`MANV`) REFERENCES `tbnhanvien` (`MANV`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbthanhtoan_nhaphang`
--
ALTER TABLE `tbthanhtoan_nhaphang`
  ADD CONSTRAINT `FK_tbthanhtoannhap_tbdonhangnhap` FOREIGN KEY (`DHN`) REFERENCES `tbdonhangnhap` (`MADHNHAP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tbthanhtoan_xuathang`
--
ALTER TABLE `tbthanhtoan_xuathang`
  ADD CONSTRAINT `FK_tbthanhtoanxuat_tbdonhangxuat` FOREIGN KEY (`DHX`) REFERENCES `tbdonhangxuat` (`MADHXUAT`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
