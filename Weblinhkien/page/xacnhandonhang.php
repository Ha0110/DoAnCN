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

// Kiểm tra ID đơn hàng
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: giohang.php');
    exit();
}

$madonhang = $_GET['id'];

// Lấy thông tin đơn hàng
$donhang = get_donhang_by_id($madonhang);

// Kiểm tra đơn hàng có tồn tại và thuộc về người dùng không
if (!$donhang || $donhang['manguoidung'] !== $manguoidung) {
    die("<h3 style='text-align:center; margin-top:100px;'>Không tìm thấy đơn hàng</h3>");
}

// Lấy chi tiết đơn hàng
$chitiet = get_chitiet_donhang($madonhang);

// Dịch trạng thái
$trangthai_text = [
    'cho_xu_ly' => 'Chờ xử lý',
    'dang_xu_ly' => 'Đang xử lý',
    'da_giao' => 'Đã giao',
    'huy' => 'Đã hủy'
];

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng | Linh Kiện 24h</title>
    <link href="../css/templatemo_style.css" rel="stylesheet" type="text/css" />
    <style>
        .confirm-container { max-width:900px; margin:40px auto; padding:20px; }
        .confirm-box { background:#d4edda; padding:20px; border-radius:8px; border:2px solid #28a745; margin-bottom:20px; }
        .confirm-box h2 { color:#28a745; margin:0; }
        .info-box { background:#fff; padding:15px; border-radius:8px; margin:15px 0; border:1px solid #e0e0e0; box-shadow:0 2px 4px rgba(0,0,0,0.05); }
        .info-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee; }
        .info-row strong { flex:0 0 200px; }
        .products-table { width:100%; border-collapse:collapse; margin:15px 0; background:#fff; border:1px solid #e0e0e0; border-radius:8px; overflow:hidden; box-shadow:0 2px 4px rgba(0,0,0,0.05); }
        .products-table th, .products-table td { padding:12px 15px; text-align:left; }
        .products-table th { background:#f9f9f9; font-weight:bold; border-bottom:2px solid #e0e0e0; }
        .products-table td { border-bottom:1px solid #f0f0f0; }
        .total-row { font-weight:bold; font-size:1.2em; background:#f0f0f0; }
        .btn { display:inline-block; padding:10px 16px; background:#27ae60; color:#fff; text-decoration:none; border-radius:5px; font-weight:bold; margin:10px 5px 10px 0; }
        .btn:hover { background:#229954; }
        .btn-secondary { background:#95a5a6; }
        .btn-secondary:hover { background:#7f8c8d; }
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
        <div class="confirm-container">
            <div class="confirm-box">
                <h2>✓ Đặt hàng thành công!</h2>
                <p>Mã đơn hàng: <strong><?= htmlspecialchars($donhang['madon']); ?></strong></p>
            </div>

            <h3>Thông tin đơn hàng</h3>
            <div class="info-box">
                <div class="info-row">
                    <strong>Mã đơn hàng:</strong>
                    <span><?= htmlspecialchars($donhang['madonhang']); ?></span>
                </div>
                <div class="info-row">
                    <strong>Trạng thái:</strong>
                    <span><?= htmlspecialchars($trangthai_text[$donhang['trangthai']] ?? 'Chờ xử lý'); ?></span>
                </div>
                <div class="info-row">
                    <strong>Ngày đặt:</strong>
                    <span><?= isset($donhang['ngaydathang']) ? date('d/m/Y H:i', strtotime($donhang['ngaydathang'])) : 'Không rõ'; ?></span>
                </div>
            </div>

            <h3>Thông tin người nhận</h3>
            <div class="info-box">
                <div class="info-row">
                    <strong>Người nhận:</strong>
                    <span><?= htmlspecialchars($donhang['tennguoinhan']); ?></span>
                </div>
                <div class="info-row">
                    <strong>Số điện thoại:</strong>
                    <span><?= htmlspecialchars($donhang['sodienthoai']); ?></span>
                </div>
                <div class="info-row">
                    <strong>Địa chỉ:</strong>
                    <span><?= htmlspecialchars($donhang['diachi'] . ', ' . $donhang['thanhpho']); ?></span>
                </div>
            </div>

            <h3>Chi tiết sản phẩm</h3>
            <table class="products-table">
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
                <?php foreach ($chitiet as $ct): ?>
                    <tr>
                        <td><?= htmlspecialchars($ct['tensanpham']); ?></td>
                        <td><?= number_format($ct['gia'], 0, ',', '.'); ?>₫</td>
                        <td><?= $ct['soluong']; ?></td>
                        <td><?= number_format($ct['thanhtien'], 0, ',', '.'); ?>₫</td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="3" style="text-align:right;">Tổng tiền:</td>
                    <td><?= number_format($donhang['tongtien'], 0, ',', '.'); ?>₫</td>
                </tr>
            </table>

            <div style="text-align:center; margin-top:30px;">
                <a href="../index.php" class="btn">Tiếp tục mua sắm</a>
                <a href="lichsudonhang.php" class="btn btn-secondary">Xem lịch sử đơn hàng</a>
            </div>
        </div>
    </div>
  </div>
</div>

<?php include "../Header&Footer/footer.php"; ?>
</body>
</html>
