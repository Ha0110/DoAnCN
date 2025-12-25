<?php
session_start();
include "../includes/config.php";
include "../includes/auth.php";
include "../includes/hamgiohang.php";


// Nếu chưa đăng nhập, chuyển tới trang đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: dangnhap.php');
    exit();
}

$manguoidung = $_SESSION['user']['manguoidung'];
$thongbao = '';

// Xử lý cập nhật thông tin (hoten, sodienthoai)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $hoten = trim($_POST['hoten'] ?? '');
    $sodienthoai = trim($_POST['sodienthoai'] ?? '');

    if ($hoten === '') {
        $thongbao = "<div class='error'>Họ tên không được để trống.</div>";
    } else {
        $sql = "UPDATE nguoidung SET hoten = ?, sodienthoai = ? WHERE manguoidung = ?";
        $stmt = $conn->prepare($sql);
        $ok = $stmt->execute([$hoten, $sodienthoai, $manguoidung]);
        if ($ok) {
            // Cập nhật session để hiển thị ngay
            $_SESSION['user']['hoten'] = $hoten;
            $_SESSION['user']['sodienthoai'] = $sodienthoai;
            $thongbao = "<div style='color:green; padding:10px; background:#d4edda; border-radius:5px;'>Cập nhật thành công.</div>";
        } else {
            $thongbao = "<div class='error'>Lỗi khi cập nhật, thử lại sau.</div>";
        }
    }
}

// Lấy thông tin người dùng mới nhất từ DB
$stmt = $conn->prepare("SELECT manguoidung, email, hoten, sodienthoai, role FROM nguoidung WHERE manguoidung = ? LIMIT 1");
$stmt->execute([$manguoidung]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Thông tin tài khoản</title>
    <link href="../css/templatemo_style.css" rel="stylesheet">
    <style>
        .account_container { max-width:700px; margin:40px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 0 20px rgba(0,0,0,0.05); }
        .account_row { display:flex; gap:20px; align-items:center; }
        .account_left { flex:1; }
        .account_right { width:260px; }
        .history-btn { display:inline-block; padding:10px 16px; background:#27ae60; color:#fff; border-radius:5px; text-decoration:none; font-weight:600; }
        input[type=text], input[type=email] { width:100%; padding:10px; margin:8px 0; border:1px solid #ddd; border-radius:5px; box-sizing:border-box; }
        input[type=submit] { padding:10px 18px; background:#27ae60; color:#fff; border:none; border-radius:5px; cursor:pointer; }
        .meta { font-size:14px; color:#666; }
        .error { background:#ffebee; color:#c62828; padding:12px; border-radius:5px; text-align:center; margin:15px 0; }
    </style>
</head>

<body>
    <div id="templatemo_body_wrapper">
        <div id="templatemo_wrapper">
            <!--header-->
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            ?>

            <div id="templatemo_header">
                <div id="site_title">
                    <a href="../index.php">
                        <img src="../images/templatemo_logo.png" alt="logo" />
                        <span>Cửa hàng linh kiện máy tính trực tuyến</span>
                    </a>
                </div>

                <!-- Phần giỏ hàng + thông tin người dùng -->
                <div id="shopping_cart_box">
                    <a href="../page/giohang.php">
                        <h3>Giỏ hàng</h3>
                    </a>
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
                <div class="account_container">
                    <h2>Thông tin tài khoản</h2>
                    <?php echo $thongbao; ?>

                    <?php if ($user): ?>
                        <div class="account_row">
                            <div class="account_left">
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

                                <h3>Cập nhật thông tin</h3>
                                <form method="post">
                                    <label>Họ và tên</label>
                                    <input type="text" name="hoten" value="<?php echo htmlspecialchars($user['hoten']); ?>" required>
                                    <label>Số điện thoại</label>
                                    <input type="text" name="sodienthoai" value="<?php echo htmlspecialchars($user['sodienthoai']); ?>">
                                    <input type="submit" name="update_profile" value="Cập nhật">
                                </form>
                            </div>
                            <div class="account_right">
                                <p><a href="../page/lichsudonhang.php" class="history-btn">Lịch sử đơn hàng</a></p>
                                <p><a href="dangxuat.php" style="color:#ff9999; font-weight:bold;">Đăng xuất</a></p>
                                <p style="margin-top:20px; font-size:13px; color:#777;">Bạn có thể cập nhật họ tên và số điện thoại.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="error">Không tìm thấy thông tin người dùng.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include "../Header&Footer/footer.php"; ?>
</body>

</html>