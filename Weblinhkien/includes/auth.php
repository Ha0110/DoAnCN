<?php
if (!isset($conn)) {
    include_once "config.php";
}
// Tạo mã người dùng dạng A + 8 ký tự hexa ngẫu nhiên (luôn unique)
function taomanguoidung() {
    return 'US' . strtoupper(substr(uniqid(), -8));
}
function dangnhap($email, $matkhau) {
    global $conn;

    if (empty($email) || empty($matkhau)) {
        return "Vui lòng nhập đầy đủ!";
    }

    $sql = "SELECT * FROM nguoidung WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($matkhau, $user['matkhau'])) {
        $_SESSION['user'] = [
            'manguoidung' => $user['manguoidung'],
            'hoten'       => $user['hoten'],
            'email'       => $user['email'],
            'sodienthoai' => $user['sodienthoai'],
            'role'        => $user['role']
        ];
        return "success";
    }
    return "Sai email hoặc mật khẩu!";
}

function dangky($hoten, $email, $sodienthoai, $matkhau, $matkhau2) {
    global $conn;

    // Validate
    if (empty(trim($hoten)) || empty(trim($email)) || empty(trim($sodienthoai)) || empty($matkhau) || empty($matkhau2)) {
        return "Vui lòng điền đầy đủ thông tin!";
    }
    if ($matkhau !== $matkhau2) return "Mật khẩu không khớp!";
    if (strlen($matkhau) < 4) return "Mật khẩu phải ít nhất 4 ký tự!";

    // Kiểm tra email đã tồn tại chưa
    $check = $conn->prepare("SELECT manguoidung FROM nguoidung WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) return "Email này đã được sử dụng!";

    // Tạo mã người dùng đẹp
    $manguoidung = taomanguoidung();

    // Mã hóa mật khẩu
    $hash = password_hash($matkhau, PASSWORD_DEFAULT);

    // INSERT với manguoidung tự sinh
    $sql = "INSERT INTO nguoidung (manguoidung, hoten, email, matkhau, sodienthoai, role) 
            VALUES (?, ?, ?, ?, ?, 'customer')";

    $stmt = $conn->prepare($sql);
    $ketqua = $stmt->execute([$manguoidung, $hoten, $email, $hash, $sodienthoai]);

    return $ketqua ? "success" : "Lỗi hệ thống, vui lòng thử lại!";
}
// ĐĂNG XUẤT
function dangxuat() {
    unset($_SESSION['user']);
    session_destroy();
    header("Location: ../index.php");
    exit();
}

?>