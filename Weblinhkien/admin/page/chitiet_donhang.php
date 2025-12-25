<?php
session_start();
require_once '../../includes/config.php';
require_once '../../includes/donhang.php';
require_once '../crud/donhang.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../../login_logout/dangnhap.php');
    exit;
}

// Lấy ID đơn hàng từ URL
if (!isset($_GET['id'])) {
    header('Location: orders.php');
    exit;
}

$madonhang = $_GET['id'];
$donhang = get_donhang_by_id_admin($madonhang);

if (!$donhang) {
    header('Location: orders.php');
    exit;
}

// === XỬ LÝ CẬP NHẬT TRẠNG THÁI ===
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trangthai = trim($_POST['trangthai'] ?? '');
    
    if (!empty($trangthai)) {
        if (update_trangthai_donhang($madonhang, $trangthai)) {
            $message = "Cập nhật trạng thái thành công!";
            $donhang = get_donhang_by_id_admin($madonhang);
        } else {
            $error = "Lỗi khi cập nhật trạng thái đơn hàng!";
        }
    }
}

$chitiet = get_chitiet_donhang_admin($madonhang);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .detail-container {
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .order-header {
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .order-header h2 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }

        .order-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-block {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #3498db;
        }

        .info-block h4 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }

        .info-item {
            margin: 8px 0;
            font-size: 14px;
        }

        .info-label {
            font-weight: bold;
            color: #34495e;
        }

        .status-section {
            padding: 20px;
            background: #ecf0f1;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .status-badge {
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            display: inline-block;
            margin-bottom: 15px;
        }

        .status-cho_xu_ly {
            background: #f39c12;
        }

        .status-dang_xu_ly {
            background: #3498db;
        }

        .status-da_giao {
            background: #27ae60;
        }

        .status-huy {
            background: #e74c3c;
        }

        .status-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .status-form select {
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-primary {
            background: #27ae60;
            color: white;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table thead {
            background: #34495e;
            color: white;
        }

        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items-table tbody tr:hover {
            background: #f5f5f5;
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            font-weight: bold;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .button-group {
            text-align: center;
            margin-top: 20px;
        }

        .total-section {
            padding: 20px;
            background: #ecf0f1;
            border-radius: 6px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="sidebar">
            <h3>ADMIN PANEL</h3>
            <a href="../index.php">
                Quản lý sản phẩm
            </a>
            <a href="danhmuc.php">
                Quản lý danh mục
            </a>
            <a href="hangsanxuat.php">
                Quản lý hãng sản xuất
            </a>
            <a href="orders.php" class="active">
                Quản lý đơn hàng
            </a>
            <a href="nguoidung.php">
                Quản lý người dùng
            </a>
            <a href="../../login_logout/dangxuat.php" style="color:#ff9999;">Đăng xuất</a>
        </div>

        <div class="main-content">
            <div class="detail-container">
                <?php if ($message) { ?>
                    <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
                <?php } ?>
                <?php if ($error) { ?>
                    <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
                <?php } ?>

                <div class="order-header">
                    <h2>Chi Tiết Đơn Hàng: <?php echo htmlspecialchars($donhang['madonhang']); ?></h2>
                </div>

                <div class="status-section">
                    <div>Trạng thái hiện tại:</div>
                    <span class="status-badge status-<?php echo $donhang['trangthai']; ?>">
                        <?php echo get_trang_thai_text($donhang['trangthai']); ?>
                    </span>

                    <?php if ($donhang['trangthai'] !== 'da_giao' && $donhang['trangthai'] !== 'huy') { ?>
                        <form method="POST" class="status-form">
                            <select name="trangthai" required>
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="cho_xu_ly" <?php echo $donhang['trangthai'] === 'cho_xu_ly' ? 'selected' : ''; ?>>Chờ xử lý</option>
                                <option value="dang_xu_ly" <?php echo $donhang['trangthai'] === 'dang_xu_ly' ? 'selected' : ''; ?>>Đang xử lý</option>
                                <option value="da_giao" <?php echo $donhang['trangthai'] === 'da_giao' ? 'selected' : ''; ?>>Đã giao</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        </form>
                    <?php } ?>
                </div>

                <div class="order-info">
                    <div>
                        <div class="info-block">
                            <h4>📋 Thông Tin Khách Hàng</h4>
                            <div class="info-item"><span class="info-label">Tên:</span> <?php echo htmlspecialchars($donhang['tennguoidung'] ?? 'N/A'); ?></div>
                            <div class="info-item"><span class="info-label">Email:</span> <?php echo htmlspecialchars($donhang['email'] ?? 'N/A'); ?></div>
                        </div>
                    </div>

                    <div>
                        <div class="info-block">
                            <h4>📦 Thông Tin Đơn Hàng</h4>
                            <div class="info-item"><span class="info-label">Mã Đơn:</span> <?php echo htmlspecialchars($donhang['madon'] ?? 'N/A'); ?></div>
                            <div class="info-item"><span class="info-label">Ngày Đặt:</span> <?php echo isset($donhang['ngaydathang']) ? date('d/m/Y H:i', strtotime($donhang['ngaydathang'])) : 'N/A'; ?></div>
                        </div>
                    </div>

                    <div>
                        <div class="info-block">
                            <h4>🏠 Địa Chỉ Giao Hàng</h4>
                            <div class="info-item"><span class="info-label">Người Nhận:</span> <?php echo htmlspecialchars($donhang['tennguoinhan'] ?? 'N/A'); ?></div>
                            <div class="info-item"><span class="info-label">Điện Thoại:</span> <?php echo htmlspecialchars($donhang['sodienthoai'] ?? 'N/A'); ?></div>
                            <div class="info-item"><span class="info-label">Địa Chỉ:</span> <?php echo htmlspecialchars($donhang['diachi'] ?? 'N/A'); ?></div>
                            <div class="info-item"><span class="info-label">Thành Phố:</span> <?php echo htmlspecialchars($donhang['thanhpho'] ?? 'N/A'); ?></div>
                        </div>
                    </div>

                    <div>
                        <div class="info-block" style="border-left-color: #e74c3c;">
                            <h4>💰 Tổng Tiền</h4>
                            <div style="font-size: 24px; font-weight: bold; color: #e74c3c;">
                                <?php echo number_format($donhang['tongtien'], 0, ',', '.'); ?> đ
                            </div>
                        </div>
                    </div>
                </div>

                <h3 style="margin-top: 30px; border-bottom: 2px solid #ecf0f1; padding-bottom: 10px;">Chi Tiết Sản Phẩm</h3>

                <?php if (count($chitiet) > 0) { ?>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Mã Sản Phẩm</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Giá</th>
                                <th>Số Lượng</th>
                                <th>Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($chitiet as $ct) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ct['masanpham']); ?></td>
                                    <td><?php echo htmlspecialchars($ct['tensanpham']); ?></td>
                                    <td><?php echo number_format($ct['gia'], 0, ',', '.'); ?> đ</td>
                                    <td style="text-align: center;"><?php echo $ct['soluong']; ?></td>
                                    <td><?php echo number_format($ct['thanhtien'], 0, ',', '.'); ?> đ</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p style="text-align: center; color: #7f8c8d; padding: 20px;">Không có sản phẩm trong đơn hàng này.</p>
                <?php } ?>

                <div class="button-group">
                    <a href="orders.php" class="btn btn-secondary">← Quay Lại Danh Sách</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
