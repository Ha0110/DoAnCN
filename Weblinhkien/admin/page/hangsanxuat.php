<?php
session_start();
require_once '../../includes/config.php';
require_once '../../includes/hangsanxuat.php';
require_once '../crud/hangsanxuat.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../../login_logout/dangnhap.php');
    exit;
}

// === XỬ LÝ XÓA HÃNG ===
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $mahangsanxuat = $_GET['id'];
    if (xoa_hangsanxuat($mahangsanxuat)) {
        $_SESSION['msg'] = 'Xóa hãng sản xuất thành công!';
    } else {
        $_SESSION['error'] = 'Không thể xóa hãng này (có sản phẩm đang sử dụng hoặc lỗi hệ thống).';
    }
    header('Location: hangsanxuat.php');
    exit;
}

$message = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['msg']);
unset($_SESSION['error']);

$all_hangsanxuat = get_all_hangsx();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Hãng sản xuất</title>
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

        .empty-message {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-size: 16px;
        }

        .btn {
            padding: 12px 30px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 10px;
        }

        .btn-primary {
            background: #27ae60;
            color: white;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
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
            <a href="hangsanxuat.php" class="active">
                Quản lý hãng sản xuất
            </a>
            <a href="orders.php">
                Quản lý đơn hàng
            </a>
            <a href="nguoidung.php">
                Quản lý người dùng
            </a>
            <a href="../../login_logout/dangxuat.php" style="color:#ff9999;">Đăng xuất</a>
        </div>

        <div class="main-content">
            <h2 class="page-title">QUẢN LÝ HÃNG SẢN XUẤT</h2>
            <?php if ($message) { ?>
                <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
            <?php } ?>
            <?php if ($error) { ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php } ?>

            <div style="margin-bottom: 20px;">
                <a href="them_hangsanxuat.php" class="btn btn-primary">+ THÊM HÃNG SẢN XUẤT</a>
            </div>

            <?php if (count($all_hangsanxuat) > 0) { ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Hãng</th>
                                <th>Tên Hãng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_hangsanxuat as $hsx_item) { ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($hsx_item['mahangsanxuat']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($hsx_item['tenhang']); ?></td>
                                    <td>
                                        <a href="sua_hangsanxuat.php?id=<?php echo urlencode($hsx_item['mahangsanxuat']); ?>" class="btn btn-warning">Sửa</a>
                                        <a href="?action=delete&id=<?php echo urlencode($hsx_item['mahangsanxuat']); ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="empty-message">Không có hãng sản xuất nào. <a href="them_hangsanxuat.php" class="btn btn-primary">+ Tạo mới</a></div>
            <?php } ?>
        </div>
    </div>

</body>

</html>
