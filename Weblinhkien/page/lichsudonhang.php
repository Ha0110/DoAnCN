<?php
session_start();
include "../includes/config.php";
include "../includes/donhang.php";
include "../includes/hamgiohang.php";

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: ../login_logout/dangnhap.php');
    exit();
}

$manguoidung = $_SESSION['user']['manguoidung'];

// Lấy danh sách đơn hàng
$donhang_list = get_donhang_by_user($manguoidung);

// Dịch trạng thái
$trangthai_text = [
    'cho_xu_ly' => 'Chờ xử lý',
    'dang_xu_ly' => 'Đang xử lý',
    'da_giao' => 'Đã giao',
    'huy' => 'Đã hủy'
];

$trangthai_color = [
    'cho_xu_ly' => '#ff9800',
    'dang_xu_ly' => '#2196F3',
    'da_giao' => '#4CAF50',
    'huy' => '#f44336'
];

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử đơn hàng | Linh Kiện 24h</title>
    <link href="../css/templatemo_style.css" rel="stylesheet" type="text/css" />
    <style>
        .history-container { max-width:1000px; margin:30px auto; padding:20px; }
        .order-card { background:#fff; padding:15px; border:1px solid #ddd; border-radius:8px; margin:15px 0; }
        .order-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
        .order-header h3 { margin:0; }
        .status-badge { padding:6px 12px; border-radius:4px; color:#fff; font-weight:bold; font-size:0.9em; }
        .order-info { display:grid; grid-template-columns:1fr 1fr; gap:15px; margin:10px 0; }
        .info-item { font-size:0.95em; }
        .info-item strong { color:#333; }
        .products { margin:10px 0; padding:10px 0; border-top:1px solid #eee; }
        .product-item { display:flex; justify-content:space-between; padding:6px 0; font-size:0.9em; }
        .btn { display:inline-block; padding:8px 12px; background:#27ae60; color:#fff; text-decoration:none; border-radius:5px; font-weight:bold; }
        .btn:hover { background:#229954; }
        .empty-msg { text-align:center; padding:50px; color:#999; }
        .order-total { font-weight:bold; font-size:1.1em; color:#e74c3c; text-align:right; padding:10px 0; border-top:1px solid #eee; }
    </style>
</head>
<body>

<div id="templatemo_body_wrapper">
  <div id="templatemo_wrapper">
    <!--header-->

<div id="templatemo_header">
    <div id="site_title">
        <a href="../index.php">
            <img src="../images/templatemo_logo.png" alt="logo" />
            <span>Cửa hàng linh kiện máy tính trực tuyến</span>
        </a>
    </div>

    <!-- Phần giỏ hàng + thông tin người dùng -->
    <div id="shopping_cart_box">
        <a href="../page/giohang.php"><h3>Giỏ hàng</h3></a>
        <p>Tổng cộng <span><?php echo get_cart_count(); ?> sản phẩm</span></p>

        <!-- Hiển thị thông tin đăng nhập / đăng ký -->
        <div style="margin-top: 15px; font-size: 14px; text-align: center;">
            <?php if (isset($_SESSION['user'])): ?>
                <strong>Xin chào <?php echo htmlspecialchars($_SESSION['user']['hoten']); ?>!</strong><br>
                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                    <a href="../admin/index.php" style="color:#ffeb3b; font-weight:bold;">Quản trị</a> | 
                <?php endif; ?>
                <a href="../login_logout/taikhoan.php" style="color:#a8e6cf;">Tài khoản</a> | 
                <a href="../login_logout/dangxuat.php" style="color:#ff9999;">Đăng xuất</a>
            <?php else: ?>
                <a href="../login_logout/dangnhap.php" style="color:#fff;">Đăng nhập</a> | 
                <a href="../login_logout/dangky.php" style="color:#a8e6cf;">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>
</div>
    <!--menu-->
    <div id="templatemo_menu">
        <div id="search_box">
          <form action="../index.php" method="get">
            <input type="text" name="q" placeholder="Tìm sản phẩm..." id="input_field" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" />
            <input type="submit" value="Tìm" id="submit_btn" />
          </form>
        </div>
        <ul>
          <li><a href="../index.php" class="current">Trang chủ</a></li>
        </ul>
      </div>
    <div id="templatemo_content_wrapper">
        <div class="history-container">
            <h2>LỊCH SỬ ĐƠN HÀNG</h2>

            <?php if (empty($donhang_list)): ?>
                <div class="empty-msg">
                    <p>Bạn chưa có đơn hàng nào.</p>
                    <a href="../index.php" style="color:#27ae60; text-decoration:none;">Quay lại trang chủ để mua sắm</a>
                </div>
            <?php else: ?>
                <?php foreach ($donhang_list as $dh): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <h3>Đơn hàng: <?= htmlspecialchars($dh['madon']); ?></h3>
                                <small style="color:#999;">Mã: <?= htmlspecialchars($dh['madonhang']); ?></small>
                            </div>
                            <span class="status-badge" style="background:<?= htmlspecialchars($trangthai_color[$dh['trangthai']] ?? '#999'); ?>;">
                                <?= htmlspecialchars($trangthai_text[$dh['trangthai']] ?? 'Chờ xử lý'); ?>
                            </span>
                        </div>

                        <div class="order-info">
                            <div class="info-item">
                                <strong>Người nhận:</strong> <?= htmlspecialchars($dh['tennguoinhan'] ?? '—'); ?><br/>
                                <strong>Điện thoại:</strong> <?= htmlspecialchars($dh['sodienthoai'] ?? '—'); ?><br/>
                                <strong>Địa chỉ:</strong> <?= htmlspecialchars(($dh['diachi'] ?? '') . ', ' . ($dh['thanhpho'] ?? '')); ?>
                            </div>
                            <div class="info-item">
                                <strong>Tổng tiền:</strong> <span style="font-size:1.2em; color:#e74c3c;"><?= number_format($dh['tongtien'], 0, ',', '.'); ?>₫</span><br/>
                                <a href="xacnhandonhang.php?id=<?= urlencode($dh['madonhang']); ?>" class="btn" style="margin-top:8px;">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
  </div>
</div>

<?php include "../Header&Footer/footer.php"; ?>
</body>
</html>
