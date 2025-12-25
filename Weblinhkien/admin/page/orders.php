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

// === XỬ LÝ CẬP NHẬT TRẠNG THÁI ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    $madonhang = $_POST['madonhang'] ?? '';
    $trangthai = $_POST['trangthai'] ?? '';
    
    if (!empty($madonhang) && !empty($trangthai)) {
        if (update_trangthai_donhang($madonhang, $trangthai)) {
            $_SESSION['msg'] = 'Cập nhật trạng thái đơn hàng thành công!';
        } else {
            $_SESSION['error'] = 'Lỗi khi cập nhật trạng thái đơn hàng!';
        }
    }
    header('Location: orders.php');
    exit;
}

// === XỬ LÝ HỦY ĐƠN HÀNG ===
if (isset($_GET['action']) && $_GET['action'] == 'cancel' && isset($_GET['id'])) {
    $madonhang = $_GET['id'];
    if (huy_donhang($madonhang)) {
        $_SESSION['msg'] = 'Hủy đơn hàng thành công!';
    } else {
        $_SESSION['error'] = 'Không thể hủy đơn hàng này (đã được xử lý hoặc lỗi hệ thống)!';
    }
    header('Location: orders.php');
    exit;
}

$message = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['msg']);
unset($_SESSION['error']);
$i=1;
$status = isset($_GET['status']) ? $_GET['status'] : 'all';
$valid_status = ['all', 'cho_xu_ly', 'dang_xu_ly', 'da_giao', 'huy'];
if (!in_array($status, $valid_status)) $status = 'all';

if ($status === 'all') {
    $all_donhang = get_all_donhang();
} else {
    $all_donhang = get_donhang_by_status($status);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Đơn hàng</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
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

        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #34495e;
            color: white;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table tbody tr:hover {
            background: #f5f5f5;
        }

        .status-badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            display: inline-block;
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

        .btn {
            padding: 8px 16px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-info {
            background: #3498db;
            color: white;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .empty-message {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-size: 16px;
        }

        .filter-section {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 6px;
        }

        .filter-group {
            display: inline-block;
            margin-right: 20px;
        }

        .filter-group label {
            font-weight: bold;
            margin-right: 10px;
        }

        .filter-group select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="sidebar">
            <h3>ADMIN PANEL</h3>
            <a href="../index.php" >
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
            <h2 class="page-title">QUẢN LÝ ĐƠN HÀNG</h2>
            <?php if ($message) { ?>
                <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
            <?php } ?>
            <?php if ($error) { ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php } ?>

            <div class="filter-section">
                <form method="get" action="orders.php">
                    <div class="filter-group">
                        <label for="status">Lọc theo trạng thái:</label>
                        <select name="status" id="status" onchange="this.form.submit()">
                            <option value="all" <?php echo ($status === 'all') ? 'selected' : ''; ?>>Tất cả</option>
                            <option value="cho_xu_ly" <?php echo ($status === 'cho_xu_ly') ? 'selected' : ''; ?>>Chờ xử lý</option>
                            <option value="dang_xu_ly" <?php echo ($status === 'dang_xu_ly') ? 'selected' : ''; ?>>Đang xử lý</option>
                            <option value="da_giao" <?php echo ($status === 'da_giao') ? 'selected' : ''; ?>>Đã giao</option>
                            <option value="huy" <?php echo ($status === 'huy') ? 'selected' : ''; ?>>Hủy</option>
                        </select>
                    </div>
                </form>
            </div>

            <?php if (count($all_donhang) > 0) { ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã Đơn Hàng</th>
                                <th>Khách Hàng</th>
                                <th>Ngày Đặt</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_donhang as $dh) { ?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><strong><?php echo htmlspecialchars($dh['madonhang']); ?></strong></td>
                                    <td>
                                        <?php echo htmlspecialchars($dh['tennguoidung'] ?? 'N/A'); ?><br>
                                        <small><?php echo htmlspecialchars($dh['email'] ?? ''); ?></small>
                                    </td>
                                    <td><?php echo isset($dh['ngaydathang']) ? date('d/m/Y H:i', strtotime($dh['ngaydathang'])) : 'N/A'; ?></td>
                                    <td><strong><?php echo number_format($dh['tongtien'], 0, ',', '.'); ?> đ</strong></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $dh['trangthai']; ?>">
                                            <?php echo get_trang_thai_text($dh['trangthai']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="chitiet_donhang.php?id=<?php echo urlencode($dh['madonhang']); ?>" class="btn btn-info">Chi Tiết</a>
                                        <?php if ($dh['trangthai'] === 'cho_xu_ly') { ?>
                                            <a href="?action=cancel&id=<?php echo urlencode($dh['madonhang']); ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">Hủy</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="empty-message">Không có đơn hàng nào.</div>
            <?php } ?>
        </div>
    </div>

</body>

</html>
