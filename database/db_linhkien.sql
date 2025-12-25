-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th12 16, 2025 lúc 01:22 PM
-- Phiên bản máy phục vụ: 9.1.0
-- Phiên bản PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_linhkien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `anh`
--

DROP TABLE IF EXISTS `anh`;
CREATE TABLE IF NOT EXISTS `anh` (
  `maanh` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `masanpham` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `duongdan` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`maanh`),
  KEY `masanpham` (`masanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `anh`
--

INSERT INTO `anh` (`maanh`, `masanpham`, `duongdan`) VALUES
('A01', 'SP001', 'intel-core-i5-12400f.jpg'),
('A02', 'SP002', 'Corsair-Vengeance-16GB-DDR4.jpg'),
('A03', 'SP003', 'Samsung-980-SSD-500GB.jpg'),
('A04', 'SP004', 'Mainboard-Gigabyte-A520M-S2H.jpg\r\n'),
('A69297F3E4', 'SP005', 'SP005_upd_1764327230_0.jpg'),
('A69297FF6B', 'SP007', 'SP007_upd_1764327414_0.jpg'),
('A692980680', 'SP008', 'SP008_upd_1764327528_0.jpg'),
('A692980B2D', 'SP009', 'SP009_upd_1764327602_0.jpg'),
('A692980EF5', 'SP010', 'SP010_upd_1764327663_0.jpg'),
('A69298128B', 'SP011', 'SP011_upd_1764327720_0.jpg'),
('A6929817E4', 'SP012', 'SP012_upd_1764327806_0.jpg'),
('A692981D12', 'SP013', 'SP013_upd_1764327889_0.jpg'),
('A6929821F2', 'SP014', 'SP014_upd_1764327967_0.jpg'),
('A692985E84', 'SP015', 'SP015_upd_1764328936_0.jpg'),
('A692985F3E', 'SP016', 'SP016_upd_1764328947_0.jpg'),
('A692985FF1', 'SP017', 'SP017_upd_1764328959_0.jpg'),
('A692986113', 'SP018', 'SP018_upd_1764328977_0.jpg'),
('A692986221', 'SP019', 'SP019_upd_1764328994_0.jpg'),
('A692986349', 'SP020', 'SP020_upd_1764329012_0.jpg'),
('A6929863C7', 'SP021', 'SP021_upd_1764329020_0.jpg'),
('A69298645E', 'SP022', 'SP022_upd_1764329029_0.jpg'),
('A6929864C0', 'SP023', 'SP023_upd_1764329036_0.jpg'),
('A692986542', 'SP024', 'SP024_upd_1764329044_0.jpg'),
('A6929865C0', 'SP025', 'SP025_upd_1764329052_0.jpg'),
('A692986673', 'SP026', 'SP026_upd_1764329063_0.jpg'),
('A692986760', 'SP027', 'SP027_upd_1764329078_0.jpg'),
('A6929867B1', 'SP028', 'SP028_upd_1764329083_0.jpg'),
('A692986816', 'SP029', 'SP029_upd_1764329089_0.jpg'),
('A69298687A', 'SP030', 'SP030_upd_1764329095_0.jpg'),
('A6929868D2', 'SP031', 'SP031_upd_1764329101_0.jpg'),
('A692986927', 'SP032', 'SP032_upd_1764329106_0.jpg'),
('A692986977', 'SP033', 'SP033_upd_1764329111_0.jpg'),
('A692986A03', 'SP034', 'SP034_upd_1764329120_0.jpg'),
('A692986A55', 'SP035', 'SP035_upd_1764329125_0.jpg'),
('A692986AA1', 'SP036', 'SP036_upd_1764329130_0.jpg'),
('A692986B10', 'SP037', 'SP037_upd_1764329137_0.jpg'),
('A692986B77', 'SP038', 'SP038_upd_1764329143_0.jpg'),
('A692986BF9', 'SP039', 'SP039_upd_1764329151_0.jpg'),
('A692986C91', 'SP040', 'SP040_upd_1764329161_0.jpg'),
('A692986CF6', 'SP041', 'SP041_upd_1764329167_0.jpg'),
('A692986D66', 'SP042', 'SP042_upd_1764329174_0.jpg'),
('A692986DDC', 'SP043', 'SP043_upd_1764329181_0.jpg'),
('A692986E87', 'SP044', 'SP044_upd_1764329192_0.jpg'),
('A692986EF6', 'SP045', 'SP045_upd_1764329199_0.jpg'),
('A692986F69', 'SP046', 'SP046_upd_1764329206_0.jpg'),
('A692987035', 'SP047', 'SP047_upd_1764329219_0.jpg'),
('A6929870A1', 'SP048', 'SP048_upd_1764329226_0.jpg'),
('A692987117', 'SP049', 'SP049_upd_1764329233_0.jpg'),
('A692987188', 'SP050', 'SP050_upd_1764329240_0.jpg'),
('A69298F72E', 'SP006', 'SP006_upd_1764331378_0.jpg'),
('A693AE29F2', 'SP00011111', 'SP00011111.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

DROP TABLE IF EXISTS `chitietdonhang`;
CREATE TABLE IF NOT EXISTS `chitietdonhang` (
  `mactdh` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `madonhang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `masanpham` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tensanpham` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gia` decimal(12,2) NOT NULL,
  `soluong` int NOT NULL,
  `thanhtien` decimal(12,2) NOT NULL,
  PRIMARY KEY (`mactdh`),
  KEY `madonhang` (`madonhang`),
  KEY `masanpham` (`masanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`mactdh`, `madonhang`, `masanpham`, `tensanpham`, `gia`, `soluong`, `thanhtien`) VALUES
('CT574AD400', 'DH574AC182', 'SP00011111', '23', 1000.00, 2, 2000.00),
('CT57D5A834', 'DH57D5A470', 'SP00011111', '23', 1000.00, 1, 1000.00),
('CT6B54FAA3', 'DH6B54F375', 'SP00011111', '23', 1000.00, 1, 1000.00),
('CT7C736498', 'DH7C7360BB', 'SP00011111', '23', 1000.00, 2, 2000.00),
('CT7C7365EE', 'DH7C7360BB', 'SP001', 'Intel Core i5 12400F', 4500000.00, 2, 9000000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

DROP TABLE IF EXISTS `danhmuc`;
CREATE TABLE IF NOT EXISTS `danhmuc` (
  `madanhmuc` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tendanhmuc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`madanhmuc`),
  UNIQUE KEY `tendanhmuc` (`tendanhmuc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`madanhmuc`, `tendanhmuc`, `mota`) VALUES
('DM01', 'CPU', 'Bộ vi xử lý máy tính'),
('DM02', 'RAM', 'Bộ nhớ trong tốc độ cao'),
('DM03', 'Ổ cứng SSD', 'Lưu trữ tốc độ cao...'),
('DM04', 'Mainboard', 'Bo mạch chủ cho PC'),
('DM05', 'HDD - Ổ cứng cơ', 'Ổ cứng HDD 3.5 inch dung lượng từ 1TB - 18TB, Seagate, WD, Toshiba...'),
('DM06', 'VGA - Card màn hình', 'Card đồ họa NVIDIA GeForce RTX 30/40/50 series và AMD Radeon RX 7000/8000 series'),
('DM07', 'Nguồn - PSU', 'Nguồn máy tính công suất 550W - 1600W, chuẩn 80+ Bronze/Gold/Platinum/Titanium'),
('DM08', 'Case - Vỏ máy tính', 'Vỏ case Full Tower, Mid Tower, Mini ITX, có kính cường lực, RGB...'),
('DM09', 'Tản nhiệt CPU', 'Tản nhiệt khí, tản nhiệt nước AIO 240mm/360mm, custom loop'),
('DM10', 'Quạt case & LED RGB', 'Quạt tản nhiệt ARGB, PWM, bộ điều khiển quạt, dải LED trang trí'),
('DM11', 'Màn hình - Monitor', 'Màn hình gaming 24-34 inch, 144Hz - 540Hz, Full HD → 4K, IPS/OLED'),
('DM12', 'Bàn phím cơ', 'Bàn phím cơ switch Cherry MX, Gateron, Kailh, Hotswap, RGB'),
('DM13', 'Chuột gaming', 'Chuột chơi game Logitech, Razer, Zowie, SteelSeries, nhẹ dưới 60g'),
('DM14', 'Tai nghe - Headphone', 'Tai nghe gaming 7.1, tai nghe audiophile, headset không dây'),
('DM15', 'Ghế gaming & Bàn', 'Ghế công thái học Secretlab, DXRacer, bàn nâng hạ điện, bàn gaming RGB');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi`
--

DROP TABLE IF EXISTS `diachi`;
CREATE TABLE IF NOT EXISTS `diachi` (
  `madiachi` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `manguoidung` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tennguoinhan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sodienthoai` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diachi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `thanhpho` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`madiachi`),
  KEY `manguoidung` (`manguoidung`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `diachi`
--

INSERT INTO `diachi` (`madiachi`, `manguoidung`, `tennguoinhan`, `sodienthoai`, `diachi`, `thanhpho`) VALUES
('DC6DA8F7B9', 'USD423A6F0', 'ha11', '0833211165', '123', 'TP.HCM'),
('DCCD1E207F', 'USD423A6F0', 'ha', '0833211165', '176 cao lo', 'TP.HCM');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

DROP TABLE IF EXISTS `donhang`;
CREATE TABLE IF NOT EXISTS `donhang` (
  `madonhang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `manguoidung` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `madiachi` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `madon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tongtien` decimal(12,2) NOT NULL,
  `trangthai` enum('cho_xu_ly','dang_xu_ly','da_giao','huy') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'cho_xu_ly',
  `ngaydathang` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`madonhang`),
  UNIQUE KEY `madon` (`madon`),
  KEY `manguoidung` (`manguoidung`),
  KEY `madiachi` (`madiachi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`madonhang`, `manguoidung`, `madiachi`, `madon`, `tongtien`, `trangthai`, `ngaydathang`) VALUES
('DH574AC182', 'USD423A6F0', 'DCCD1E207F', 'ORD202512161249565815', 2000.00, 'huy', '2025-12-16 19:49:56'),
('DH57D5A470', 'USD423A6F0', 'DCCD1E207F', 'ORD202512111755098029', 1000.00, 'cho_xu_ly', '2025-12-12 00:55:09'),
('DH6B54F375', 'USD423A6F0', 'DCCD1E207F', 'ORD202512111800216372', 1000.00, 'cho_xu_ly', '2025-12-12 01:00:21'),
('DH7C7360BB', 'USD423A6F0', 'DCCD1E207F', 'ORD202512111804556107', 9002000.00, 'cho_xu_ly', '2025-12-12 01:04:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hangsanxuat`
--

DROP TABLE IF EXISTS `hangsanxuat`;
CREATE TABLE IF NOT EXISTS `hangsanxuat` (
  `mahangsanxuat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenhang` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`mahangsanxuat`),
  UNIQUE KEY `tenhang` (`tenhang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hangsanxuat`
--

INSERT INTO `hangsanxuat` (`mahangsanxuat`, `tenhang`) VALUES
('HSX02', 'AMD'),
('HSX05', 'ASUS'),
('HSX03', 'Corsair'),
('HSX07', 'Gigabyte'),
('HSX01', 'Intel'),
('HSX06', 'MSI'),
('HSX04', 'Samsung');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

DROP TABLE IF EXISTS `nguoidung`;
CREATE TABLE IF NOT EXISTS `nguoidung` (
  `manguoidung` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `matkhau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hoten` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sodienthoai` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('customer','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'customer',
  PRIMARY KEY (`manguoidung`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`manguoidung`, `email`, `matkhau`, `hoten`, `sodienthoai`, `role`) VALUES
('USD423A6F0', 'phamngocha785@gmail.com', '$2y$10$wn90mCTB7Hu7ep54oeHCoePLTIE5Zyg.uhzYiWxIHyCE4nFU1uB2u', 'Phạm Ngọc Hà', '01648375070', 'customer'),
('USD6B6BC76', 'admin@gmail.com', '$2y$10$RsPY1oh8LNe1Ut0bryNWve8sb0KzEBgHlh3IWKvAvYqvAaf9toTu2', 'ad', '0833211165', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `masanpham` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tensanpham` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `madanhmuc` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mahangsanxuat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gia` decimal(12,2) NOT NULL,
  PRIMARY KEY (`masanpham`),
  KEY `madanhmuc` (`madanhmuc`),
  KEY `mahangsanxuat` (`mahangsanxuat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`masanpham`, `tensanpham`, `madanhmuc`, `mahangsanxuat`, `mota`, `gia`) VALUES
('SP00011111', '23', 'DM02', 'HSX07', '1', 1000.00),
('SP001', 'Intel Core i5 12400F', 'DM01', 'HSX01', 'CPU 6 nhân 12 luồng, hiệu năng cao.', 4500000.00),
('SP002', 'Corsair Vengeance 16GB DDR4', 'DM02', 'HSX03', 'RAM bus 3200MHz, hiệu năng tốt.', 1500000.00),
('SP003', 'Samsung 980 SSD 500GB', 'DM03', 'HSX04', 'SSD NVMe tốc độ cao.', 2000000.00),
('SP004', 'Mainboard Gigabyte A520M S2H', 'DM04', 'HSX02', 'Bo mạch chủ hỗ trợ AMD.', 2200000.00),
('SP005', 'ASUS ROG STRIX Z790-E Gaming WiFi', 'DM04', 'HSX05', 'Mainboard Intel cao cấp DDR5', 13990000.00),
('SP006', 'MSI B650 TOMAHAWK WIFI', 'DM04', 'HSX06', 'Mainboard AMD AM5 DDR5 WiFi 6E', 6290000.00),
('SP007', 'Gigabyte B550 AORUS Elite V2', 'DM04', 'HSX07', 'Mainboard AM4 giá tốt', 3390000.00),
('SP008', 'Corsair Vengeance RGB 32GB(2x16) DDR5 6000', 'DM02', 'HSX03', 'RAM DDR5 RGB tốc độ cao', 4590000.00),
('SP009', 'Samsung 990 PRO 2TB NVMe Gen4', 'DM03', 'HSX04', 'SSD đọc 7450MB/s', 5190000.00),
('SP010', 'Samsung 970 EVO Plus 1TB', 'DM03', 'HSX04', 'SSD NVMe giá tốt', 2890000.00),
('SP011', 'ASUS TUF Gaming RTX 4070 Ti 12GB', 'DM06', 'HSX05', 'Card đồ họa RTX 4070 Ti', 23990000.00),
('SP012', 'MSI RTX 4080 Gaming X Trio 16GB', 'DM06', 'HSX06', 'Card đồ họa 4K cực mạnh', 36990000.00),
('SP013', 'Gigabyte RTX 4090 AORUS Master 24GB', 'DM06', 'HSX07', 'Card đồ họa mạnh nhất', 59990000.00),
('SP014', 'Corsair RM1000x 1000W 80+ Gold', 'DM07', 'HSX03', 'Nguồn full modular siêu êm', 4390000.00),
('SP015', 'Corsair iCUE 5000X RGB White', 'DM08', 'HSX03', 'Case kính cường lực 3 mặt', 4990000.00),
('SP016', 'ASUS ROG Strix Helios Black', 'DM08', 'HSX05', 'Case cao cấp RGB', 7990000.00),
('SP017', 'MSI MEG Z790 ACE', 'DM04', 'HSX06', 'Mainboard flagship Intel', 15990000.00),
('SP018', 'AMD Ryzen 5 7600X', 'DM01', 'HSX02', '6 nhân 12 luồng AM5', 6890000.00),
('SP019', 'Intel Core i7-13700K', 'DM01', 'HSX01', '16 nhân 24 luồng', 10990000.00),
('SP020', 'Corsair Dominator Platinum RGB 32GB DDR4', 'DM02', 'HSX03', 'RAM cao cấp DDR4', 3590000.00),
('SP021', 'Gigabyte AORUS RGB 16GB DDR4 3600', 'DM02', 'HSX07', 'RAM RGB giá tốt', 1990000.00),
('SP022', 'ASUS ROG Swift PG42UQ 42\" 4K 138Hz OLED', 'DM11', 'HSX05', 'Màn hình OLED gaming đỉnh cao', 39990000.00),
('SP023', 'Samsung Odyssey G9 49\" 240Hz Curved', 'DM11', 'HSX04', 'Màn hình cong ultrawide', 29990000.00),
('SP024', 'MSI MPG GUNGNIR 110R', 'DM08', 'HSX06', 'Case kính cường lực 4 quạt RGB', 2290000.00),
('SP025', 'Corsair H150i Elite LCD XT 360mm', 'DM09', 'HSX03', 'Tản nhiệt nước AIO màn hình LCD', 6990000.00),
('SP026', 'ASUS ROG Ryujin III 360 ARGB', 'DM09', 'HSX05', 'Tản nước cao cấp nhất', 8990000.00),
('SP027', 'Gigabyte RTX 3060 Eagle 12GB', 'DM06', 'HSX07', 'Card đồ họa tầm trung ngon', 9990000.00),
('SP028', 'Intel Core i5-13400F', 'DM01', 'HSX01', '10 nhân giá cực hời', 5290000.00),
('SP029', 'AMD Ryzen 5 5600X', 'DM01', 'HSX02', '6 nhân 12 luồng kinh điển', 4990000.00),
('SP030', 'MSI B550M PRO-VDH WIFI', 'DM04', 'HSX06', 'Mainboard mini giá tốt', 2990000.00),
('SP031', 'Corsair CX750M 750W 80+ Bronze', 'DM07', 'HSX03', 'Nguồn semi-modular', 2090000.00),
('SP032', 'Samsung 870 EVO 1TB SATA', 'DM03', 'HSX04', 'SSD SATA bền bỉ', 2590000.00),
('SP033', 'ASUS Dual RTX 4060 Ti 8GB', 'DM06', 'HSX05', 'Card mới 4060 Ti hiệu năng tốt', 12990000.00),
('SP034', 'Gigabyte B760M DS3H', 'DM04', 'HSX07', 'Mainboard Intel giá rẻ', 2890000.00),
('SP035', 'Corsair Vengeance LPX 16GB DDR4 3200', 'DM02', 'HSX03', 'RAM cơ bản ổn định', 1090000.00),
('SP036', 'MSI MAG B650 TOMAHAWK WIFI', 'DM04', 'HSX06', 'Mainboard AM5 đẹp', 5990000.00),
('SP037', 'Intel Core i3-14100F', 'DM01', 'HSX01', '4 nhân 8 luồng văn phòng', 3290000.00),
('SP038', 'AMD Ryzen 9 7900X', 'DM01', 'HSX02', '12 nhân 24 luồng', 12990000.00),
('SP039', 'ASUS Prime Z790-A WiFi', 'DM04', 'HSX05', 'Mainboard Intel ổn định', 7990000.00),
('SP040', 'Corsair 4000D Airflow Black', 'DM08', 'HSX03', 'Case thoáng khí tối ưu', 2590000.00),
('SP041', 'Gigabyte RTX 4070 Gaming OC 12GB', 'DM06', 'HSX07', 'RTX 4070 hiệu năng cao', 17990000.00),
('SP042', 'Samsung T7 Shield 2TB External SSD', 'DM05', 'HSX04', 'Ổ cứng di động siêu bền', 4990000.00),
('SP043', 'MSI RTX 3050 Ventus 2X 8GB', 'DM06', 'HSX06', 'Card giá rẻ chơi game nhẹ', 7490000.00),
('SP044', 'Corsair HX1200i 1200W Platinum', 'DM07', 'HSX03', 'Nguồn cao cấp nhất', 7990000.00),
('SP045', 'ASUS ROG Strix B650-E Gaming WiFi', 'DM04', 'HSX05', 'Mainboard AMD cao cấp', 8990000.00),
('SP046', 'Intel Core i9-13900K', 'DM01', 'HSX01', '24 nhân thế hệ 13', 14990000.00),
('SP047', 'AMD Ryzen 7 7800X3D', 'DM01', 'HSX02', 'Vua chơi game 2025', 12490000.00),
('SP048', 'Gigabyte AORUS FV43U 43\" 4K 144Hz', 'DM11', 'HSX07', 'Màn hình lớn 4K', 21990000.00),
('SP049', 'Corsair K70 RGB TKL Champion', 'DM12', 'HSX03', 'Bàn phím cơ gaming', 3990000.00),
('SP050', 'ASUS ROG Claymore II Wireless', 'DM12', 'HSX05', 'Bàn phím cơ không dây cao cấp', 6990000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tonkho`
--

DROP TABLE IF EXISTS `tonkho`;
CREATE TABLE IF NOT EXISTS `tonkho` (
  `matonkho` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `masanpham` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `soluong` int DEFAULT '0',
  PRIMARY KEY (`matonkho`),
  KEY `masanpham` (`masanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tonkho`
--

INSERT INTO `tonkho` (`matonkho`, `masanpham`, `soluong`) VALUES
('TK01', 'SP001', 21),
('TK01c871f0', 'SP00011111', 100),
('TK02', 'SP002', 50),
('TK03', 'SP003', 30),
('TK04', 'SP004', 15),
('TK69297F3E', 'SP005', 5),
('TK69297F9A', 'SP006', 5),
('TK69297FDC', 'SP007', 10),
('TK69298068', 'SP008', 15),
('TK692980B2', 'SP009', 10),
('TK692980EF', 'SP010', 20),
('TK69298128', 'SP011', 6),
('TK6929817E', 'SP012', 3),
('TK692981D1', 'SP013', 2),
('TK6929821F', 'SP014', 28),
('TK692985E8', 'SP015', 8),
('TK692985F3', 'SP016', 6),
('TK692985FF', 'SP017', 20),
('TK69298611', 'SP018', 30),
('TK69298622', 'SP019', 9),
('TK69298634', 'SP020', 4),
('TK6929863C', 'SP021', 7),
('TK69298645', 'SP022', 25),
('TK6929864C', 'SP023', 41),
('TK69298650', 'SP024', 56),
('TK6929865C', 'SP025', 35),
('TK6929865F', 'SP026', 10),
('TK69298676', 'SP027', 52),
('TK6929867B', 'SP028', 15),
('TK69298681', 'SP029', 6),
('TK69298687', 'SP030', 8),
('TK6929868D', 'SP031', 17),
('TK69298692', 'SP032', 5),
('TK69298697', 'SP033', 3),
('TK692986A0', 'SP034', 1),
('TK692986A5', 'SP035', 2),
('TK692986AA', 'SP036', 9),
('TK692986AD', 'SP037', 21),
('TK692986B7', 'SP038', 60),
('TK692986BF', 'SP039', 100),
('TK692986C9', 'SP040', 5),
('TK692986CF', 'SP041', 7),
('TK692986D6', 'SP042', 8),
('TK692986DD', 'SP043', 5),
('TK692986E8', 'SP044', 30),
('TK692986EF', 'SP045', 40),
('TK692986F6', 'SP046', 70),
('TK69298703', 'SP047', 8),
('TK6929870A', 'SP048', 60),
('TK69298711', 'SP049', 25),
('TK69298718', 'SP050', 45);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `anh`
--
ALTER TABLE `anh`
  ADD CONSTRAINT `anh_ibfk_1` FOREIGN KEY (`masanpham`) REFERENCES `sanpham` (`masanpham`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`madonhang`) REFERENCES `donhang` (`madonhang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`masanpham`) REFERENCES `sanpham` (`masanpham`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`manguoidung`) REFERENCES `nguoidung` (`manguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`manguoidung`) REFERENCES `nguoidung` (`manguoidung`) ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`madiachi`) REFERENCES `diachi` (`madiachi`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`madanhmuc`) REFERENCES `danhmuc` (`madanhmuc`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`mahangsanxuat`) REFERENCES `hangsanxuat` (`mahangsanxuat`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `tonkho`
--
ALTER TABLE `tonkho`
  ADD CONSTRAINT `tonkho_ibfk_1` FOREIGN KEY (`masanpham`) REFERENCES `sanpham` (`masanpham`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
