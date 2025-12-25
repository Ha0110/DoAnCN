<?php
if (!isset($conn)) {
    include_once "config.php";
}

// Tạo mã đơn hàng dạng DH + 8 ký tự hexa ngẫu nhiên
function tao_ma_donhang() {
    return 'DH' . strtoupper(substr(uniqid(), -8));
}

// Tạo mã chi tiết đơn hàng
function tao_ma_ctdh() {
    return 'CT' . strtoupper(substr(uniqid(), -8));
}

// Tạo mã địa chỉ
function tao_ma_diachi() {
    return 'DC' . strtoupper(substr(uniqid(), -8));
}

// Lấy tất cả địa chỉ của người dùng
function get_diachi_by_user($manguoidung) {
    global $conn;
    $sql = "SELECT * FROM diachi WHERE manguoidung = ? ORDER BY madiachi DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$manguoidung]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Thêm địa chỉ mới
function them_diachi($manguoidung, $tennguoinhan, $sodienthoai, $diachi, $thanhpho) {
    global $conn;
    
    if (empty($tennguoinhan) || empty($sodienthoai) || empty($diachi) || empty($thanhpho)) {
        return false;
    }
    
    $madiachi = tao_ma_diachi();
    $sql = "INSERT INTO diachi (madiachi, manguoidung, tennguoinhan, sodienthoai, diachi, thanhpho) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$madiachi, $manguoidung, $tennguoinhan, $sodienthoai, $diachi, $thanhpho]);
}

// Lấy thông tin một địa chỉ
function get_diachi_by_id($madiachi) {
    global $conn;
    $sql = "SELECT * FROM diachi WHERE madiachi = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$madiachi]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Tạo đơn hàng mới
function tao_donhang($manguoidung, $madiachi, $tongtien) {
    global $conn;
    
    // Kiểm tra dữ liệu đầu vào không được rỗng và tổng tiền phải lớn hơn 0
    if (empty($manguoidung) || empty($madiachi) || $tongtien <= 0) {
        return false;
    }
    
    // Tạo mã đơn hàng dạng DH + 8 ký tự hexa ngẫu nhiên
    $madonhang = 'DH' . strtoupper(substr(uniqid(), -8));
    // Tạo mã đơn hàng thứ cấp dạng ORD + timestamp + số ngẫu nhiên (tăng tính unique)
    $madon = 'ORD' . date('YmdHis') . rand(1000, 9999);

    // Lệnh INSERT với 5 placeholder tương ứng 5 giá trị truyền vào
    // trangthai được set cứng là 'cho_xu_ly' (chờ xử lý), ngaydathang dùng NOW() để lấy thời gian hiện tại
    $sql = "INSERT INTO donhang (madonhang, manguoidung, madiachi, madon, tongtien, trangthai, ngaydathang) 
            VALUES (?, ?, ?, ?, ?, 'cho_xu_ly', NOW())";
    $stmt = $conn->prepare($sql);

    // Thực thi INSERT với dữ liệu được binding: [madonhang, manguoidung, madiachi, madon, tongtien]
    if ($stmt->execute([$madonhang, $manguoidung, $madiachi, $madon, $tongtien])) {
        return $madonhang; // Trả về mã đơn hàng nếu tạo thành công
    }
    return false; // Trả về false nếu tạo thất bại
}

// Thêm chi tiết đơn hàng
function them_chitiet_donhang($madonhang, $masanpham, $tensanpham, $gia, $soluong) {
    global $conn;
    
    if (empty($madonhang) || empty($masanpham) || $gia < 0 || $soluong <= 0) {
        return false;
    }
    
    $mactdh = tao_ma_ctdh();
    $thanhtien = $gia * $soluong;
    
    $sql = "INSERT INTO chitietdonhang (mactdh, madonhang, masanpham, tensanpham, gia, soluong, thanhtien) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$mactdh, $madonhang, $masanpham, $tensanpham, $gia, $soluong, $thanhtien]);
}

// Lấy danh sách đơn hàng của người dùng
function get_donhang_by_user($manguoidung) {
    global $conn;
    $sql = "SELECT dh.*, dc.tennguoinhan, dc.sodienthoai, dc.diachi, dc.thanhpho 
            FROM donhang dh
            LEFT JOIN diachi dc ON dh.madiachi = dc.madiachi
            WHERE dh.manguoidung = ?
            ORDER BY dh.madonhang DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$manguoidung]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy chi tiết đơn hàng
function get_chitiet_donhang($madonhang) {
    global $conn;
    $sql = "SELECT * FROM chitietdonhang WHERE madonhang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$madonhang]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy thông tin một đơn hàng
function get_donhang_by_id($madonhang) {
    global $conn;
    $sql = "SELECT dh.*, dc.tennguoinhan, dc.sodienthoai, dc.diachi, dc.thanhpho 
            FROM donhang dh
            LEFT JOIN diachi dc ON dh.madiachi = dc.madiachi
            WHERE dh.madonhang = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$madonhang]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Cập nhật trạng thái đơn hàng
function update_trangthai_donhang($madonhang, $trangthai) {
    global $conn;
    $allowed_status = ['cho_xu_ly', 'dang_xu_ly', 'da_giao', 'huy'];
    
    if (!in_array($trangthai, $allowed_status)) {
        return false;
    }
    
    $sql = "UPDATE donhang SET trangthai = ? WHERE madonhang = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$trangthai, $madonhang]);
}

?>
