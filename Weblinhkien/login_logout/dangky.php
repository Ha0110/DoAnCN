<?php
session_start();
include "../includes/config.php";
include "../includes/auth.php";

$thongbao = "";
if ($_POST) {
    $ketqua = dangky($_POST['hoten'], $_POST['email'], $_POST['sodienthoai'], $_POST['matkhau'], $_POST['matkhau2']);
    if ($ketqua === "success") {
        $thongbao = "<div style='color:green; text-align:center; padding:15px; background:#d4edda; border-radius:5px;'>
                        Đăng ký thành công! <a href='dangnhap.php'>Đăng nhập ngay</a>
                     </div>";
    } else {
        $thongbao = "<div class='error'>$ketqua</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng ký</title>
    <link href="../css/templatemo_style.css" rel="stylesheet">
    <style>
        .register_container { max-width:500px; margin:50px auto; padding:30px; background:#fff; border-radius:10px; box-shadow:0 0 20px rgba(0,0,0,0.1); }
        input { width:100%; padding:12px; margin:8px 0; border:1px solid #ddd; border-radius:5px; box-sizing:border-box; }
        input[type=submit] { background:#27ae60; color:#fff; font-size:18px; cursor:pointer; }
        .error { background:#ffebee; color:#c62828; padding:12px; border-radius:5px; text-align:center; margin:15px 0; }
    </style>
</head>
<body>
<div id="templatemo_body_wrapper"><div id="templatemo_wrapper">
    

    <div id="templatemo_content_wrapper">
        <div class="register_container">
            <h2>Đăng ký tài khoản mới</h2>
            <?php echo $thongbao; ?>
            <form method="post">
                <input type="text" name="hoten" placeholder="Họ và tên" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="sodienthoai" placeholder="Số điện thoại" required>
                <input type="password" name="matkhau" placeholder="Mật khẩu" required>
                <input type="password" name="matkhau2" placeholder="Nhập lại mật khẩu" required>
                <input type="submit" value="ĐĂNG KÝ">
            </form>
        </div>
    </div>
</div></div>
<?php include "../Header&Footer/footer.php"; ?>
</body>
</html>