<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login_logout/dangnhap.php");
    exit();
}

require_once '../../includes/config.php';
require_once '../../includes/sanpham.php';
require_once '../../includes/danhmuc.php';
require_once '../../includes/hangsanxuat.php';
require_once '../crud/suasp.php';


$thongbao = '';
$loi      = '';

$danhmuc_list = get_all_danhmuc();
$hangsx_list  = get_all_hangsx();

// Kiểm tra ID sản phẩm
if (!isset($_GET['id']) || empty(trim($_GET['id']))) {
    die("<h3 style='color:red;text-align:center;margin-top:100px;'>Lỗi: Không có mã sản phẩm!</h3>");
}
$masanpham = trim($_GET['id']);

// Lấy thông tin sản phẩm 
$sp = get_sp_id_admin($masanpham);
if (!$sp) {
    die("<h3 style='color:red;text-align:center;margin-top:100px;'>Sản phẩm không tồn tại hoặc đã bị xóa!</h3>");
}


$madanhmuc_hientai     = $sp['madanhmuc'] ?? '';
$mahangsanxuat_hientai = $sp['mahangsanxuat'] ?? '';
$soluong_hientai       = $sp['soluong'] ?? 0;
$mota_hientai          = $sp['mota'] ?? '';

$anh_list = get_anh_sp($masanpham);

// XỬ LÝ XÓA ẢNH
if (isset($_GET['xoaanh'])) {
    if (xoa_anh($_GET['xoaanh'])) {
        $thongbao = "<div class='alert success'>Xóa ảnh thành công!</div>";
    } else {
        $loi = "<div class='alert error'>Lỗi khi xóa ảnh!</div>";
    }
    $anh_list = get_anh_sp($masanpham);
}

// XỬ LÝ CẬP NHẬT SẢN PHẨM
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tensanpham    = trim($_POST['tensanpham']);
    $madanhmuc     = $_POST['madanhmuc'];
    $mahangsanxuat = !empty($_POST['mahangsanxuat']) ? $_POST['mahangsanxuat'] : null;
    $mota          = trim($_POST['mota']);
    $gia           = (float)$_POST['gia'];
    $soluong       = (int)$_POST['soluong'];

    // Upload ảnh mới
    $anh_moi = [];

    if (!empty($_FILES['anh_moi']['name'])) {

        $upload_dir = "../../images/";
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $file = $_FILES['anh_moi'];

        if ($file['error'] === 0) {

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $allowed) && $file['size'] <= 5 * 1024 * 1024) {


                $newname = $masanpham . "_upd." . $ext;

                if (move_uploaded_file($file['tmp_name'], $upload_dir . $newname)) {
                    $anh_moi[] = $newname;
                }
            }
        }
    }


    $data = [
        'masanpham'     => $masanpham,
        'tensanpham'    => $tensanpham,
        'madanhmuc'     => $madanhmuc,
        'mahangsanxuat' => $mahangsanxuat,
        'mota'          => $mota,
        'gia'           => $gia,
        'soluong'       => $soluong,
        'anh_files'     => $anh_moi
    ];

    if (sua_sanpham($data)) {
        $thongbao = "<div class='alert success'>Cập nhật sản phẩm thành công!</div>";
        $sp       = get_sp_id($masanpham); // refresh dữ liệu
        $anh_list = get_anh_sp($masanpham);
        // cập nhật lại biến an toàn
        $madanhmuc_hientai     = $sp['madanhmuc'] ?? '';
        $mahangsanxuat_hientai = $sp['mahangsanxuat'] ?? '';
        $soluong_hientai       = $sp['soluong'] ?? 0;
        $mota_hientai          = $sp['mota'] ?? '';
    } else {
        $loi = "<div class='alert error'>Lỗi khi cập nhật sản phẩm!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm - <?= htmlspecialchars($sp['tensanpham']) ?></title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .form-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .form-group {
            margin: 20px 0;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        .btn {
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin: 8px 4px;
        }

        .btn-primary {
            background: #28a745;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
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

        .anh-hientai {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 15px 0;
        }

        .anh-item {
            position: relative;
            border: 3px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }

        .anh-item img {
            width: 140px;
            height: 140px;
            object-fit: cover;
        }

        .xoa-anh {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #dc3545;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            font-size: 18px;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .xoa-anh:hover {
            background: #c82333;
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
            <a href="./../login_logout/dangxuat.php" style="color:#ff9999;">Đăng xuất</a>
        </div>

        <div class="main-content">
            <h2 class="page-title">SỬA SẢN PHẨM: <strong style="color:#007bff"><?= htmlspecialchars($sp['tensanpham']) ?></strong></h2>

            <?= $thongbao ?>
            <?= $loi ?>

            <div class="form-container">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Mã sản phẩm</label>
                        <input type="text" value="<?= $masanpham ?>" disabled style="background:#f8f9fa; font-weight:bold;">
                        <small>Mã sản phẩm không thể thay đổi</small>
                    </div>

                    <div class="form-group">
                        <label>Tên sản phẩm *</label>
                        <input type="text" name="tensanpham" value="<?= htmlspecialchars($sp['tensanpham']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Danh mục *</label>
                        <select name="madanhmuc" required>
                            <?php foreach ($danhmuc_list as $dm): ?>
                                <option value="<?= $dm['madanhmuc'] ?>" <?= ($madanhmuc_hientai == $dm['madanhmuc'] ? 'selected' : '') ?>>
                                    <?= htmlspecialchars($dm['tendanhmuc']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Hãng sản xuất</label>
                        <select name="mahangsanxuat">
                            <option value="">-- Không chọn --</option>
                            <?php foreach ($hangsx_list as $hsx): ?>
                                <option value="<?= $hsx['mahangsanxuat'] ?>" <?= ($mahangsanxuat_hientai == $hsx['mahangsanxuat'] ? 'selected' : '') ?>>
                                    <?= htmlspecialchars($hsx['tenhang']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Giá bán (VNĐ) *</label>
                        <input type="number" name="gia" value="<?= $sp['gia'] ?>" required min="0">
                        <small>giá lớn hơn hoặc bằng 0</small>
                    </div>

                    <div class="form-group">
                        <label>Số lượng tồn kho *</label>
                        <input type="number" name="soluong" value="<?= $soluong_hientai ?>" required min="0">
                        <small>giá lớn hơn hoặc bằng 0</small>
                    </div>

                    <div class="form-group">
                        <label>Mô tả sản phẩm</label>
                        <textarea name="mota"><?= htmlspecialchars($mota_hientai) ?></textarea>
                    </div>

                    <!-- ẢNH  -->
                    <div class="form-group">
                        <label>Ảnh hiện tại</label>

                        <?php if (!empty($anh_list)):
                            $anh = $anh_list[0];
                        ?>
                            <div class="anh-hientai">
                                <div class="anh-item">
                                    <img src="../../images/<?= htmlspecialchars($anh['duongdan']) ?>" alt="">
                                    <a href="?id=<?= $masanpham ?>&xoaanh=<?= $anh['maanh'] ?>"
                                        class="xoa-anh" title="Xóa ảnh"
                                        onclick="return confirm('Xóa vĩnh viễn ảnh này?')">X</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <p><i>Chưa có ảnh nào</i></p>
                        <?php endif; ?>
                    </div>



                    <div class="form-group">
                        <label>Thêm ảnh mới</label>
                        <input type="file" name="anh_moi" accept="image/*">
                        <small>Định dạng: JPG, PNG, GIF, WebP | Tối đa 5MB/ảnh</small>
                    </div>

                    <div style="text-align:center; margin-top:40px;">
                        <button type="submit" class="btn btn-primary">CẬP NHẬT SẢN PHẨM</button>
                        <a href="index.php" class="btn btn-secondary">Quay lại danh sách</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>