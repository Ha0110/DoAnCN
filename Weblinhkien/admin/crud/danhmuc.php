<?php
// === KIỂM TRA MÃ DANH MỤC ĐÃ TỒN TẠI ===
function danhmuc_da_ton_tai($madanhmuc) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM danhmuc WHERE madanhmuc = ?");
    $stmt->execute([$madanhmuc]);
    return $stmt->fetchColumn() > 0;
}

// === THÊM DANH MỤC MỚI ===
function them_danhmuc($madanhmuc, $tendanhmuc, $mota = '') {
    global $conn;
    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO danhmuc (madanhmuc, tendanhmuc, mota) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$madanhmuc, $tendanhmuc, $mota]);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi thêm danh mục: " . $e->getMessage());
        return false;
    }
}

// === SỬA DANH MỤC ===
function sua_danhmuc($madanhmuc, $tendanhmuc, $mota = '') {
    global $conn;
    try {
        $conn->beginTransaction();

        $sql = "UPDATE danhmuc SET tendanhmuc = ?, mota = ? WHERE madanhmuc = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$tendanhmuc, $mota, $madanhmuc]);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi sửa danh mục: " . $e->getMessage());
        return false;
    }
}

// === XÓA DANH MỤC ===
function xoa_danhmuc($madanhmuc) {
    global $conn;
    try {
        $conn->beginTransaction();

        // Kiểm tra xem có sản phẩm nào dùng danh mục này không
        $check = $conn->prepare("SELECT COUNT(*) FROM sanpham WHERE madanhmuc = ?");
        $check->execute([$madanhmuc]);
        if ($check->fetchColumn() > 0) {
            $conn->rollBack();
            error_log("Không thể xóa danh mục đang được sử dụng");
            return false;
        }
        
        $sql = "DELETE FROM danhmuc WHERE madanhmuc = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$madanhmuc]);

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi xóa danh mục: " . $e->getMessage());
        return false;
    }
}
?>
