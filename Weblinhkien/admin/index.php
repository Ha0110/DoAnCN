<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login_logout/dangnhap.php");
    exit();
}

require_once '../includes/config.php';
require_once '../includes/sanpham.php'; 

// Xử lý xóa
require_once 'crud/xoasp.php';
if (isset($_GET['xoa'])) {
    $masp = $_GET['xoa'];
    
    if (xoa_sanpham($masp)) {
        $thongbao = "<div class='alert success'>Xóa sản phẩm <strong>$masp</strong> thành công!</div>";
    } else {
        $thongbao = "<div class='alert error'>Lỗi khi xóa sản phẩm <strong>$masp</strong>!</div>";
    }
}


$danhsach_sp = getall_sp();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý sản phẩm</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .product-img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
        .alert { padding: 12px; margin: 15px 0; border-radius: 6px; font-weight: bold; }
        .success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
        .error { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="container">
    <?php include 'page/menu.php'; ?>

    <div class="main-content">
        <h2 class="page-title">QUẢN LÝ SẢN PHẨM</h2>
        
        <a href="page/them_sanpham.php" class="btn btn-success">+ Thêm sản phẩm mới</a>
        <br><br>

        <?php if (isset($thongbao)) echo $thongbao; ?>

        <?php if (empty($danhsach_sp)): ?>
            <p>Chưa có sản phẩm nào.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Ảnh</th>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Hãng</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Hành động</th>
                </tr>

                <?php foreach ($danhsach_sp as $sp): ?>
                    <tr>
                        <td>
                            <img src="../images/<?= htmlspecialchars($sp['anh_sanpham']) ?>" 
                                alt="<?= htmlspecialchars($sp['tensanpham']) ?>"
                                class="product-img"
                                onerror="this.src='../images/no_image.png'">
                        </td>
                        <td><strong><?= htmlspecialchars($sp['masanpham']) ?></strong></td>
                        <td style="text-align:left; max-width:320px;">
                            <?= htmlspecialchars($sp['tensanpham']) ?>
                        </td>
                        <td><?= htmlspecialchars($sp['tendanhmuc']) ?></td>
                        <td><?= htmlspecialchars($sp['tenhang'] ?? '—') ?></td>
                        <td><?= number_format($sp['gia']) ?>₫</td>
                        <td><b><?= $sp['soluong'] ?? 0 ?></b></td>
                        <td>
                            <a href="page/sua_sanpham.php?id=<?= $sp['masanpham'] ?>" class="btn btn-warning">Sửa</a>
                            <a href="?xoa=<?= $sp['masanpham'] ?>" 
                            class="btn btn-danger"
                            onclick="return confirm('XÓA HOÀN TOÀN sản phẩm:\n<?= addslashes($sp['tensanpham']) ?>?\n\nẢnh và tồn kho sẽ bị xóa vĩnh viễn!')">
                            Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>

</body>
</html>