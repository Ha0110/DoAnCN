<?php
// === HÀM SỬA SẢN PHẨM  ===
function sua_sanpham($data) {
    global $conn;
    try {
        $conn->beginTransaction();

        // 1. Cập nhật thông tin sản phẩm
        $sql = "UPDATE sanpham SET 
                    tensanpham = ?, 
                    madanhmuc = ?, 
                    mahangsanxuat = ?, 
                    mota = ?, 
                    gia = ? 
                WHERE masanpham = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $data['tensanpham'],
            $data['madanhmuc'],
            $data['mahangsanxuat'],
            $data['mota'],
            $data['gia'],
            $data['masanpham']
        ]);

        // 2. Cập nhật tồn kho
        $check_tk = $conn->prepare("SELECT matonkho FROM tonkho WHERE masanpham = ?");
        $check_tk->execute([$data['masanpham']]);
        if ($check_tk->rowCount() > 0) {
            // Nếu đã có → UPDATE
            $conn->prepare("UPDATE tonkho SET soluong = ? WHERE masanpham = ?")
                 ->execute([$data['soluong'], $data['masanpham']]);
        } else {
            // Nếu chưa có → INSERT mới
            $matonkho = 'TK' . strtoupper(uniqid());
            $conn->prepare("INSERT INTO tonkho (matonkho, masanpham, soluong) VALUES (?, ?, ?)")
                 ->execute([$matonkho, $data['masanpham'], $data['soluong']]);
        }

        // 3. Thêm ảnh mới
        if (!empty($data['anh_files'])) {
            foreach ($data['anh_files'] as $filename) {               
                $maanh = 'A' . strtoupper(uniqid());
                $sql_anh = "INSERT INTO anh (maanh, masanpham, duongdan) VALUES (?, ?, ?)";
                $conn->prepare($sql_anh)->execute([$maanh, $data['masanpham'], $filename]);
            }
        }

        $conn->commit();
        return true;

    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Lỗi sửa sản phẩm: " . $e->getMessage());
        return false;
    }
}
function get_anh_sp($masanpham) {
    global $conn;
    $stmt = $conn->prepare("SELECT maanh, duongdan FROM anh WHERE masanpham = ? ORDER BY maanh");
    $stmt->execute([$masanpham]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// === HÀM XÓA ẢNH THEO maanh ===
function xoa_anh($maanh) {
    global $conn;
    try {
        // Lấy tên file để xóa thật trên server
        $stmt = $conn->prepare("SELECT duongdan FROM anh WHERE maanh = ?");
        $stmt->execute([$maanh]);
        $file = $stmt->fetchColumn();

        // Xóa file thật (nếu tồn tại và không phải ảnh mặc định)
        if ($file && $file !== 'no_image.png') {
            $path = "../images/" . $file;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Xóa bản ghi trong DB
        $conn->prepare("DELETE FROM anh WHERE maanh = ?")->execute([$maanh]);
        return true;
    } catch (Exception $e) {
        error_log("Lỗi xóa ảnh: " . $e->getMessage());
        return false;
    }
}
function get_sp_id_admin($id) {
    global $conn;
    $sql = "
        SELECT 
            sp.*,
            dm.tendanhmuc,
            COALESCE(hsx.tenhang, '') AS tenhang,
            COALESCE(hsx.mahangsanxuat, '') AS mahangsanxuat,
            tk.soluong
        FROM sanpham sp
        INNER JOIN danhmuc dm ON sp.madanhmuc = dm.madanhmuc
        LEFT JOIN hangsanxuat hsx ON sp.mahangsanxuat = hsx.mahangsanxuat
        LEFT JOIN tonkho tk ON sp.masanpham = tk.masanpham
        WHERE sp.masanpham = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>