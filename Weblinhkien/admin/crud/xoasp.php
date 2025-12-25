<?php



// === HÀM XÓA SẢN PHẨM HOÀN TOÀN
function xoa_sanpham($masanpham) {
    global $conn;
    
    try {
        $conn->beginTransaction();

        // 1. Lấy  ảnh của sản phẩm để xóa file thật
        $stmt = $conn->prepare("SELECT duongdan FROM anh WHERE masanpham = ?");
        $stmt->execute([$masanpham]);
        $anhs = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($anhs as $file) {
            $path = "../images/" . $file;
            if ($file && $file !== 'no_image.png' && file_exists($path)) {
                unlink($path); // Xóa file ảnh thật trên server
            }
        }

        // 2. Xóa dữ liệu trong DB
        
        $conn->prepare("DELETE FROM sanpham WHERE masanpham = ?")->execute([$masanpham]);

        $conn->commit();
        return true;

    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi xóa sản phẩm $masanpham: " . $e->getMessage());
        return false;
    }
}

