<?php
session_start();
include "../includes/config.php";
include "../includes/hamgiohang.php";
include "../includes/donhang.php";

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: ../login_logout/dangnhap.php');
    exit();
}

$manguoidung = $_SESSION['user']['manguoidung'];

// Kiểm tra giỏ hàng có trống không
if (empty($_SESSION['cart'])) {
    header('Location: giohang.php');
    exit();
}

// Kiểm tra địa chỉ được chọn
if (!isset($_POST['madiachi']) || empty($_POST['madiachi'])) {
    header('Location: dathang.php');
    exit();
}

$madiachi = $_POST['madiachi'];

// Kiểm tra địa chỉ có tồn tại và thuộc về người dùng không
$diachi = get_diachi_by_id($madiachi);
if (!$diachi || $diachi['manguoidung'] !== $manguoidung) {
    header('Location: dathang.php');
    exit();
}

// Lấy chi tiết giỏ hàng
$cart_data = get_cart_details();
$cart_items = $cart_data['items'];
$total_amount = $cart_data['total'];



// Bắt đầu giao dịch
try {
    $conn->beginTransaction();
    
    // 1. Tạo đơn hàng mới
    $madonhang = tao_donhang($manguoidung, $madiachi, $total_amount);
    
    if (!$madonhang) {
        throw new Exception("Không thể tạo đơn hàng");
    }
    
    // 2. Thêm chi tiết đơn hàng từ giỏ hàng
    foreach ($cart_items as $item) {
        $ok = them_chitiet_donhang(
            $madonhang,
            $item['masanpham'],
            $item['tensanpham'],
            $item['gia'],
            $item['quantity']
        );
        
        if (!$ok) {
            throw new Exception("Không thể thêm chi tiết đơn hàng");
        }
    }
    
    // 3. Commit giao dịch
    $conn->commit();
    
    // 4. Xóa giỏ hàng (session)
    $_SESSION['cart'] = [];

    // Mặc định: Redirect tới trang xác nhận với thông báo thành công
    header('Location: xacnhandonhang.php?id=' . urlencode($madonhang));
    exit();
    
} catch (Exception $e) {
    // Rollback nếu có lỗi
    $conn->rollBack();
    
    // Redirect về trang đặt hàng với thông báo lỗi
    $_SESSION['error'] = "Lỗi khi tạo đơn hàng: " . $e->getMessage();
    header('Location: dathang.php');
    exit();
}

?>
