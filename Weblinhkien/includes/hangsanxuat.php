<?php



// === LẤY TẤT CẢ HÃNG SẢN XUẤT ===
function get_all_hangsx()
{
    global $conn; 
    $sql = "
        SELECT mahangsanxuat, tenhang 
        FROM hangsanxuat 
        ORDER BY tenhang ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// === LẤY HÃNG SẢN XUẤT THEO ID ===
function get_hangsanxuat_by_id($mahangsanxuat)
{
    global $conn;
    $sql = "SELECT mahangsanxuat, tenhang FROM hangsanxuat WHERE mahangsanxuat = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$mahangsanxuat]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
