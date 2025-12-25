<?php
session_start();
require_once '../../includes/config.php';
require_once '../../includes/danhmuc.php';
require_once '../crud/danhmuc.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../../login_logout/dangnhap.php');
    exit;
}

// === XỬ LÝ XÓA DANH MỤC ===
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $madanhmuc = $_GET['id'];
    if (xoa_danhmuc($madanhmuc)) {
        $_SESSION['msg'] = 'Xóa danh mục thành công!';
    } else {
        $_SESSION['error'] = 'Không thể xóa danh mục này (có sản phẩm đang sử dụng hoặc lỗi hệ thống).';
    }
    header('Location: danhmuc.php');
    exit;
}

$message = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['msg']);
unset($_SESSION['error']);

$all_danhmuc = get_all_danhmuc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Danh mục</title>
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
            <a href="danhmuc.php" class="active">
                Quản lý danh mục
            </a>
            <a href="hangsanxuat.php">
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
            <h2 class="page-title">QUẢN LÝ DANH MỤC</h2>
            <?php if ($message) { ?>
                <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
            <?php } ?>
            <?php if ($error) { ?>
                <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
            <?php } ?>

            <div style="margin-bottom: 20px;">
                <a href="them_danhmuc.php" class="btn btn-primary">+ THÊM DANH MỤC</a>
            </div>

            <?php if (count($all_danhmuc) > 0) { ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Danh mục</th>
                                <th>Tên Danh mục</th>
                                <th>Mô tả</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_danhmuc as $dm_item) { ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($dm_item['madanhmuc']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($dm_item['tendanhmuc']); ?></td>
                                    <td><?php echo htmlspecialchars($dm_item['mota']); ?></td>
                                    <td>
                                        <a href="sua_danhmuc.php?id=<?php echo urlencode($dm_item['madanhmuc']); ?>" class="btn btn-warning">Sửa</a>
                                        <a href="?action=delete&id=<?php echo urlencode($dm_item['madanhmuc']); ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="empty-message">Không có danh mục nào. <a href="them_danhmuc.php" class="btn btn-primary">+ Tạo mới</a></div>
            <?php } ?>
        </div>
    </div>

</body>

</html>
