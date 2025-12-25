<?php


// === HỦY ĐƠN HÀNG ===
function huy_donhang($madonhang) {
    global $conn;
    try {
        $conn->beginTransaction();

        // Chỉ được hủy nếu đang ở trạng thái 'cho_xu_ly'
        $check = $conn->prepare("SELECT trangthai FROM donhang WHERE madonhang = ?");
        $check->execute([$madonhang]);
        $order = $check->fetch(PDO::FETCH_ASSOC);
        
        if (!$order) {
            $conn->rollBack();
            return false;
        }

        if ($order['trangthai'] !== 'cho_xu_ly') {
            $conn->rollBack();
            error_log("Không thể hủy đơn hàng không ở trạng thái 'cho_xu_ly'");
            return false;
        }

        $sql = "UPDATE donhang SET trangthai = 'huy' WHERE madonhang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$madonhang]);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi hủy đơn hàng: " . $e->getMessage());
        return false;
    }
}

// === LẤY TẤT CẢ ĐƠN HÀNG ===
function get_all_donhang() {
    global $conn;
    $sql = "
        SELECT 
            dh.*,
            dc.tennguoinhan,
            dc.sodienthoai,
            dc.diachi,
            dc.thanhpho,
            nd.hoten AS tennguoidung,
            nd.email
        FROM donhang dh
        LEFT JOIN diachi dc ON dh.madiachi = dc.madiachi
        LEFT JOIN nguoidung nd ON dh.manguoidung = nd.manguoidung
        ORDER BY dh.ngaydathang DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// LẤY ĐƠN HÀNG THEO TRẠNG THÁI 
function get_donhang_by_status($status) {
    global $conn;
    $allowed_status = ['cho_xu_ly', 'dang_xu_ly', 'da_giao', 'huy'];

    if (!in_array($status, $allowed_status)) {
        return [];
    }

    $sql = "
        SELECT 
            dh.*,
            dc.tennguoinhan,
            dc.sodienthoai,
            dc.diachi,
            dc.thanhpho,
            nd.hoten AS tennguoidung,
            nd.email
        FROM donhang dh
        LEFT JOIN diachi dc ON dh.madiachi = dc.madiachi
        LEFT JOIN nguoidung nd ON dh.manguoidung = nd.manguoidung
        WHERE dh.trangthai = ?
        ORDER BY dh.ngaydathang DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$status]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// === LẤY ĐƠN HÀNG THEO ID ===
function get_donhang_by_id_admin($madonhang) {
    global $conn;
    $sql = "
        SELECT 
            dh.*,
            dc.tennguoinhan,
            dc.sodienthoai,
            dc.diachi,
            dc.thanhpho,
            nd.hoten AS tennguoidung,
            nd.email
        FROM donhang dh
        LEFT JOIN diachi dc ON dh.madiachi = dc.madiachi
        LEFT JOIN nguoidung nd ON dh.manguoidung = nd.manguoidung
        WHERE dh.madonhang = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$madonhang]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// === LẤY CHI TIẾT ĐƠN HÀNG ===
function get_chitiet_donhang_admin($madonhang) {
    global $conn;
    $sql = "SELECT * FROM chitietdonhang WHERE madonhang = ? ORDER BY mactdh";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$madonhang]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// === TÍNH TRẠNG THÁI VN ===
function get_trang_thai_text($status) {
    $status_map = [
        'cho_xu_ly' => 'Chờ xử lý',
        'dang_xu_ly' => 'Đang xử lý',
        'da_giao' => 'Đã giao',
        'huy' => 'Hủy'
    ];
    return isset($status_map[$status]) ? $status_map[$status] : 'Không xác định';
}

// === TÍNH MÀU TRẠNG THÁI ===
function get_trang_thai_color($status) {
    $color_map = [
        'cho_xu_ly' => '#f39c12',  // Orange
        'dang_xu_ly' => '#3498db',  // Blue
        'da_giao' => '#27ae60',     // Green
        'huy' => '#e74c3c'          // Red
    ];
    return isset($color_map[$status]) ? $color_map[$status] : '#95a5a6';
}
?>
