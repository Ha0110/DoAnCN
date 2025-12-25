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
require_once '../crud/themsp.php';

$thongbao = '';
$loi = '';


$danhmuc_list = get_all_danhmuc();
$hangsx_list  = get_all_hangsx();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $masanpham     = trim($_POST['masanpham']);
    $tensanpham    = trim($_POST['tensanpham']);
    $madanhmuc     = $_POST['madanhmuc'];
    $mahangsanxuat = !empty($_POST['mahangsanxuat']) ? $_POST['mahangsanxuat'] : null;
    $mota          = trim($_POST['mota']);
    $gia           = (int)$_POST['gia'];
    $soluong       = (int)$_POST['soluong'];

    // === KIỂM TRA DỮ LIỆU ===
    if (empty($masanpham) || empty($tensanpham) || empty($madanhmuc) || $gia < 0 || $soluong < 0) {
        $loi = "Vui lòng điền đầy đủ và chính xác thông tin!";
    } elseif (sp_da_ton_tai($masanpham)) {
        $loi = "Mã sản phẩm <strong>$masanpham</strong> đã tồn tại!";
    } elseif (empty($_FILES['anh']['name'])) {
        $loi = "Vui lòng chọn ảnh sản phẩm!";
    } else {

        // === XỬ LÝ UPLOAD ẢNH ===
        $upload_dir = "../../images/";
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $file = $_FILES['anh'];

        if ($file['error'] === 0) {

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $allowed) && $file['size'] <= 5 * 1024 * 1024) {


                $newname = $masanpham . "." . $ext;

                if (move_uploaded_file($file['tmp_name'], $upload_dir . $newname)) {
                    $anh_file = $newname;
                }
            }
        }

        if (empty($anh_file)) {
            $loi = "Không thể upload ảnh. Vui lòng thử lại!";
        } else {
            // === GỌI HÀM THÊM SẢN PHẨM ===
            $data = [
                'masanpham'     => $masanpham,
                'tensanpham'    => $tensanpham,
                'madanhmuc'     => $madanhmuc,
                'mahangsanxuat' => $mahangsanxuat,
                'mota'          => $mota,
                'gia'           => $gia,
                'soluong'       => $soluong,
                'anh_files'     => [$anh_file]
            ];

            if (them_sanpham($data)) {
                $thongbao = "<div class='alert success'>Thêm sản phẩm <strong>$tensanpham</strong> thành công!</div>";
                $_POST = [];
            } else {
                $loi = "Lỗi khi thêm sản phẩm vào CSDL!";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
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

        .preview-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin: 5px;
            border-radius: 6px;
            border: 2px solid #3498db;
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
            <h2 class="page-title">THÊM SẢN PHẨM MỚI</h2>

            <?php if ($thongbao) echo $thongbao; ?>
            <?php if ($loi) echo "<div class='alert error'>$loi</div>"; ?>

            <div class="form-container">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Mã sản phẩm <span style="color:red">*</span></label>
                        <input type="text" name="masanpham" value="<?= $_POST['masanpham'] ?? '' ?>" required maxlength="10" placeholder="VD: SP05">
                        <small>Tối đa 10 ký tự</small>
                    </div>

                    <div class="form-group">
                        <label>Tên sản phẩm <span style="color:red">*</span></label>
                        <input type="text" name="tensanpham" value="<?= $_POST['tensanpham'] ?? '' ?>" required maxlength="255">
                    </div>

                    <div class="form-group">
                        <label>Danh mục <span style="color:red">*</span></label>
                        <select name="madanhmuc" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($danhmuc_list as $dm): ?>
                                <option value="<?= $dm['madanhmuc'] ?>" <?= (($_POST['madanhmuc'] ?? '') == $dm['madanhmuc'] ? 'selected' : '') ?>>
                                    <?= $dm['tendanhmuc'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Hãng sản xuất</label>
                        <select name="mahangsanxuat">
                            <option value="">-- Không chọn --</option>
                            <?php foreach ($hangsx_list as $hsx): ?>
                                <option value="<?= $hsx['mahangsanxuat'] ?>" <?= (($_POST['mahangsanxuat'] ?? '') == $hsx['mahangsanxuat'] ? 'selected' : '') ?>>
                                    <?= $hsx['tenhang'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Giá bán (VNĐ) <span style="color:red">*</span></label>
                        <input type="number" name="gia" value="<?= $_POST['gia'] ?? '' ?>" required min="0">
                        <small>giá lớn hơn hoặc bằng 0</small>
                    </div>

                    <div class="form-group">
                        <label>Số lượng tồn kho <span style="color:red">*</span></label>
                        <input type="number" name="soluong" value="<?= $_POST['soluong'] ?? '0' ?>" required min="0">
                        <small>giá lớn hơn hoặc bằng 0</small>
                    </div>

                    <div class="form-group">
                        <label>Mô tả sản phẩm</label>
                        <textarea name="mota" placeholder="Nhập thông tin chi tiết..."><?= $_POST['mota'] ?? '' ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Ảnh sản phẩm <span style="color:red">*</span></label>
                        <input type="file" name="anh" accept="image/*" required onchange="previewImages(this)">
                        <div id="preview" style="margin-top:10px"></div>
                        <small>Định dạng: JPG, PNG, GIF, WebP | Tối đa 5MB/ảnh</small>
                    </div>

                    <div style="text-align:center; margin-top:30px">
                        <button type="submit" class="btn btn-primary">THÊM SẢN PHẨM</button>
                        <a href="index.php" class="btn btn-secondary">Quay lại danh sách</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Xem trước ảnh khi chọn
        function previewImages(input) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';
            if (input.files) {
                [...input.files].forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'preview-img';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>

</body>

</html>