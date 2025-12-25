<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../../login_logout/dangnhap.php");
    exit();
}

require_once '../../includes/config.php';
require_once '../../includes/danhmuc.php';
require_once '../crud/danhmuc.php';

$thongbao = '';
$loi = '';
$dm = null;

// Lấy ID danh mục từ URL
if (!isset($_GET['id'])) {
    header("Location: danhmuc.php");
    exit();
}

$madanhmuc = $_GET['id'];
$dm = get_danhmuc_by_id($madanhmuc);

if (!$dm) {
    header("Location: danhmuc.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tendanhmuc = trim($_POST['tendanhmuc']);
    $mota = trim($_POST['mota']);

    // === KIỂM TRA DỮ LIỆU ===
    if (empty($tendanhmuc)) {
        $loi = "Vui lòng điền đầy đủ thông tin!";
    } else {
        // === GỌI HÀM SỬA DANH MỤC ===
        if (sua_danhmuc($madanhmuc, $tendanhmuc, $mota)) {
            $thongbao = "<div class='alert success'>Cập nhật danh mục <strong>$tendanhmuc</strong> thành công!</div>";
            $_SESSION['msg'] = "Cập nhật danh mục $tendanhmuc thành công!";
            $dm = get_danhmuc_by_id($madanhmuc);
        } else {
            $loi = "Lỗi khi cập nhật danh mục vào CSDL!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa danh mục</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2c3e50;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        textarea {
            height: 100px;
            resize: vertical;
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

        .btn-secondary {
            background: #95a5a6;
            color: white;
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
            <a href="orders.php">
                Quản lý đơn hàng
            </a>
            <a href="nguoidung.php">
                Quản lý người dùng
            </a>
            <a href="../../login_logout/dangxuat.php" style="color:#ff9999;">Đăng xuất</a>
        </div>

        <div class="main-content">
            <h2 class="page-title">CẬP NHẬT DANH MỤC</h2>

            <?php if ($thongbao) echo $thongbao; ?>
            <?php if ($loi) echo "<div class='alert error'>$loi</div>"; ?>

            <div class="form-container">
                <form method="post">
                    <div class="form-group">
                        <label>Mã Danh mục</label>
                        <input type="text" value="<?= htmlspecialchars($dm['madanhmuc']) ?>" readonly style="background-color: #ecf0f1; cursor: not-allowed;">
                    </div>

                    <div class="form-group">
                        <label>Tên Danh mục <span style="color:red">*</span></label>
                        <input type="text" name="tendanhmuc" value="<?= htmlspecialchars($dm['tendanhmuc']) ?>" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="mota" placeholder="Nhập thông tin chi tiết về danh mục..."><?= htmlspecialchars($dm['mota']) ?></textarea>
                    </div>

                    <div style="text-align:center; margin-top:30px">
                        <button type="submit" class="btn btn-primary">CẬP NHẬT</button>
                        <a href="danhmuc.php" class="btn btn-secondary">Quay lại danh sách</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
