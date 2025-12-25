<?php
// === KIỂM TRA MÃ HÃNG ĐÃ TỒN TẠI ===
function hangsanxuat_da_ton_tai($mahangsanxuat) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM hangsanxuat WHERE mahangsanxuat = ?");
    $stmt->execute([$mahangsanxuat]);
    return $stmt->fetchColumn() > 0;
}

// === THÊM HÃNG SẢN XUẤT MỚI ===
function them_hangsanxuat($mahangsanxuat, $tenhang) {
    global $conn;
    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO hangsanxuat (mahangsanxuat, tenhang) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$mahangsanxuat, $tenhang]);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi thêm hãng sản xuất: " . $e->getMessage());
        return false;
    }
}

// === SỬA HÃNG SẢN XUẤT ===
function sua_hangsanxuat($mahangsanxuat, $tenhang) {
    global $conn;
    try {
        $conn->beginTransaction();

        $sql = "UPDATE hangsanxuat SET tenhang = ? WHERE mahangsanxuat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$tenhang, $mahangsanxuat]);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi sửa hãng sản xuất: " . $e->getMessage());
        return false;
    }
}

// === XÓA HÃNG SẢN XUẤT ===
function xoa_hangsanxuat($mahangsanxuat) {
    global $conn;
    try {
        $conn->beginTransaction();

        // Kiểm tra xem có sản phẩm nào dùng hãng này không
        $check = $conn->prepare("SELECT COUNT(*) FROM sanpham WHERE mahangsanxuat = ?");
        $check->execute([$mahangsanxuat]);
        if ($check->fetchColumn() > 0) {
            $conn->rollBack();
            error_log("Không thể xóa hãng đang được sử dụng");
            return false;
        }
        
        $sql = "DELETE FROM hangsanxuat WHERE mahangsanxuat = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$mahangsanxuat]);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi xóa hãng sản xuất: " . $e->getMessage());
        return false;
    }
}
?>
