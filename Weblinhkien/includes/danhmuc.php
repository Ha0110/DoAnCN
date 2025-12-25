<?php



//  LẤY TẤT CẢ DANH MỤC 
function get_all_danhmuc()
{
    global $conn; 
    $sql = "
    SELECT madanhmuc, tendanhmuc, mota
    FROM danhmuc 
    ORDER BY madanhmuc ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// LẤY DANH MỤC THEO ID 
function get_danhmuc_by_id($madanhmuc)
{
    global $conn;
    $sql = "SELECT madanhmuc, tendanhmuc, mota FROM danhmuc WHERE madanhmuc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$madanhmuc]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
