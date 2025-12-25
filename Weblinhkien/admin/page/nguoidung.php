<?php
session_start();
require_once '../../includes/config.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../../login_logout/dangnhap.php');
    exit;
}

// Lấy danh sách người dùng
$stmt = $conn->prepare("SELECT manguoidung, hoten, email, sodienthoai, role FROM nguoidung ORDER BY manguoidung DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$message = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['msg']);
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người dùng</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .table-container { background:white; border-radius:10px; box-shadow:0 4px 20px rgba(0,0,0,0.1); overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        table thead { background:#34495e; color:white; }
        table th, table td { padding:12px; text-align:left; border-bottom:1px solid #eee; }
        .empty-message { text-align:center; padding:40px; color:#7f8c8d; }
        .badge-role { padding:6px 10px; border-radius:6px; color:white; font-weight:bold; }
        .role-admin { background:#e74c3c; }
        .role-user { background:#27ae60; }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h3>ADMIN PANEL</h3>
            <a href="../index.php">Quản lý sản phẩm</a>
            <a href="danhmuc.php">Quản lý danh mục</a>
            <a href="hangsanxuat.php">Quản lý hãng sản xuất</a>
            <a href="orders.php">Quản lý đơn hàng</a>
            <a href="nguoidung.php" class="active">Quản lý người dùng</a>
            <a href="../../login_logout/dangxuat.php" style="color:#ff9999;">Đăng xuất</a>
        </div>

        <div class="main-content">
            <h2 class="page-title">DANH SÁCH NGƯỜI DÙNG ĐĂNG KÝ</h2>

            <?php if ($message) { ?><div class="alert success"><?php echo htmlspecialchars($message); ?></div><?php } ?>
            <?php if ($error) { ?><div class="alert error"><?php echo htmlspecialchars($error); ?></div><?php } ?>

            <?php if (count($users) > 0) { ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã Người Dùng</th>
                                <th>Họ Tên</th>
                                <th>Email</th>
                                <th>Điện Thoại</th>
                                <th>Vai Trò</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($u['manguoidung']); ?></td>
                                    <td><?php echo htmlspecialchars($u['hoten']); ?></td>
                                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                                    <td><?php echo htmlspecialchars($u['sodienthoai']); ?></td>
                                    <td>
                                        <?php $role = $u['role'] ?? 'user'; ?>
                                        <span class="badge-role <?php echo $role === 'admin' ? 'role-admin' : 'role-user'; ?>">
                                            <?php echo htmlspecialchars(strtoupper($role)); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="empty-message">Không có người dùng nào.</div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
