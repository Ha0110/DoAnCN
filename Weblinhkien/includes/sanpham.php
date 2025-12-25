<?php

function getall_sp()
{
    global $conn;
    $sql = "
        SELECT 
            sp.masanpham,
            sp.tensanpham,
            sp.mota,
            sp.gia,
            dm.tendanhmuc,
            hsx.tenhang,
            tk.soluong,
            COALESCE(a.duongdan, 'no_image.png') AS anh_sanpham 
        FROM sanpham sp
        INNER JOIN danhmuc dm ON sp.madanhmuc = dm.madanhmuc
        LEFT JOIN hangsanxuat hsx ON sp.mahangsanxuat = hsx.mahangsanxuat
        LEFT JOIN tonkho tk ON sp.masanpham = tk.masanpham
        LEFT JOIN anh a ON sp.masanpham = a.masanpham
        GROUP BY sp.masanpham
        ORDER BY sp.masanpham ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    return $kq;
}

function get_sp_id($id)
{
    global $conn;

    $sql = "
        SELECT 
            sp.masanpham,
            sp.tensanpham,
            sp.mota,
            sp.gia,
            dm.tendanhmuc,
            hsx.tenhang,
            tk.soluong,
            COALESCE(a.duongdan, 'no_image.png') AS anh_sanpham
        FROM sanpham sp
        INNER JOIN danhmuc dm ON sp.madanhmuc = dm.madanhmuc
        LEFT JOIN hangsanxuat hsx ON sp.mahangsanxuat = hsx.mahangsanxuat
        LEFT JOIN tonkho tk ON sp.masanpham = tk.masanpham
        LEFT JOIN anh a ON sp.masanpham = a.masanpham
        WHERE sp.masanpham = ?
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_sp_dm($madanhmuc)
{
    global $conn;
    $sql = "
        SELECT 
            sp.masanpham,
            sp.tensanpham,
            sp.mota,
            sp.gia,
            dm.tendanhmuc,
            hsx.tenhang,
            tk.soluong,
            COALESCE(a.duongdan, 'no_image.png') AS anh_sanpham
        FROM sanpham sp
        INNER JOIN danhmuc dm ON sp.madanhmuc = dm.madanhmuc
        LEFT JOIN hangsanxuat hsx ON sp.mahangsanxuat = hsx.mahangsanxuat
        LEFT JOIN tonkho tk ON sp.masanpham = tk.masanpham
        LEFT JOIN anh a ON sp.masanpham = a.masanpham
        WHERE sp.madanhmuc = ?
        ORDER BY sp.masanpham ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$madanhmuc]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//HÀM TÌM KIẾM
function search_sp_by_name($keyword)
{
    global $conn;
    $sql = "
        SELECT 
            sp.masanpham,
            sp.tensanpham,
            sp.mota,
            sp.gia,
            dm.tendanhmuc,
            hsx.tenhang,
            tk.soluong,
            COALESCE((
                SELECT a.duongdan 
                FROM anh a 
                WHERE a.masanpham = sp.masanpham 
                ORDER BY a.maanh ASC 
                LIMIT 1
            ), 'no_image.png') AS anh_sanpham
        FROM sanpham sp
        INNER JOIN danhmuc dm ON sp.madanhmuc = dm.madanhmuc
        LEFT JOIN hangsanxuat hsx ON sp.mahangsanxuat = hsx.mahangsanxuat
        LEFT JOIN tonkho tk ON sp.masanpham = tk.masanpham
        WHERE sp.tensanpham LIKE ?
        ORDER BY sp.masanpham DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['%' . $keyword . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
