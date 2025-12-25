<?php
session_start();
include "../includes/config.php";
include "../includes/auth.php";

$thongbao = "";
if ($_POST) {
    $ketqua = dangnhap($_POST['email'], $_POST['matkhau']);
    if ($ketqua === "success") {
        $role = $_SESSION['user']['role'] ?? 'customer';
        header("Location: " . ($role === 'admin' ? "../admin/index.php" : "../index.php"));
        exit();
    } else {
        $thongbao = "<div class='error'>$ketqua</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng nhập</title>
    <link href="../css/templatemo_style.css" rel="stylesheet">
    <style>
        .login_container { max-width:400px; margin:60px auto; padding:30px; background:#fff; border-radius:10px; box-shadow:0 0 20px rgba(0,0,0,0.1); }
        input[type=email], input[type=password] { width:100%; padding:12px; margin:8px 0; border:1px solid #ddd; border-radius:5px; }
        input[type=submit] { width:100%; padding:14px; background:#e74c3c; color:#fff; border:none; border-radius:5px; font-size:18px; cursor:pointer; }
        .error { background:#ffebee; color:#c62828; padding:12px; border-radius:5px; text-align:center; margin:15px 0; }
    </style>
</head>
<body>
<div id="templatemo_body_wrapper"><div id="templatemo_wrapper">
    

    <div id="templatemo_content_wrapper">
        <div class="login_container">
            <h2>Đăng nhập tài khoản</h2>
            <?php echo $thongbao; ?>
            <form method="post">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="matkhau" placeholder="Mật khẩu" required>
                <input type="submit" value="ĐĂNG NHẬP">
            </form>
            <p style="text-align:center; margin-top:20px;">
                Chưa có tài khoản? <a href="dangky.php">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</div></div>
<?php include "../Header&Footer/footer.php"; ?>
</body>
</html>