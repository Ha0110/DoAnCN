<?php
// === KIỂM TRA MÃ SẢN PHẨM ĐÃ TỒN TẠI ===
function sp_da_ton_tai($masanpham) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM sanpham WHERE masanpham = ?");
    $stmt->execute([$masanpham]);
    return $stmt->fetchColumn() > 0;
}

// === THÊM SẢN PHẨM MỚI ===
function them_sanpham($data) {
    global $conn;
    try {
        $conn->beginTransaction();

        // 1. Thêm vào bảng sanpham
        $sql = "INSERT INTO sanpham 
                (masanpham, tensanpham, madanhmuc, mahangsanxuat, mota, gia) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $data['masanpham'],
            $data['tensanpham'],
            $data['madanhmuc'],
            $data['mahangsanxuat'],
            $data['mota'],
            $data['gia']
        ]);

        // 2. Thêm tồn kho
        $matonkho = 'TK' . substr(md5(time() . $data['masanpham']), 0, 8);
        $sql2 = "INSERT INTO tonkho (matonkho, masanpham, soluong) VALUES (?, ?, ?)";
        $conn->prepare($sql2)->execute([$matonkho, $data['masanpham'], $data['soluong']]);

        // 3. Thêm ảnh
        if (!empty($data['anh_files'])) {
            $stt = 1;
            foreach ($data['anh_files'] as $filename) {
                $maanh = 'A' . strtoupper(uniqid()); // Ví dụ: A672f9c8e1a2b3
                $sql3 = "INSERT INTO anh (maanh, masanpham, duongdan) VALUES (?, ?, ?)";
                $conn->prepare($sql3)->execute([$maanh, $data['masanpham'], $filename]);
            }
        }

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi thêm sản phẩm: " . $e->getMessage());
        return false;
    }
}
?>