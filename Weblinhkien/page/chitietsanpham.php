<?php
include "../includes/config.php";
include "../includes/sanpham.php";
include "../includes/hamgiohang.php";

// Lấy ID sản phẩm từ URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sp = get_sp_id($id);

    if (!$sp) {
        echo "<p>Không tìm thấy sản phẩm.</p>";
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $sp['tensanpham']; ?> | Linh Kiện 24h</title>
<link href="../css/templatemo_style.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div id="templatemo_body_wrapper">
  <div id="templatemo_wrapper">

    <!-- Header -->
    <?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div id="templatemo_header">
    <div id="site_title">
        <a href="../index.php">
            <img src="../images/templatemo_logo.png" alt="logo" />
            <span>Cửa hàng linh kiện máy tính trực tuyến</span>
        </a>
    </div>

    <!-- Phần giỏ hàng + thông tin người dùng -->
    <div id="shopping_cart_box">
        <a href="../page/giohang.php"><h3>Giỏ hàng</h3></a>
        <p>Tổng cộng <span><?php echo get_cart_count(); ?> sản phẩm</span></p>

        <!-- Hiển thị thông tin đăng nhập / đăng ký -->
        <div style="margin-top: 15px; font-size: 14px; text-align: center;">
            <?php if (isset($_SESSION['user'])): ?>
                <strong>Xin chào <?php echo htmlspecialchars($_SESSION['user']['hoten']); ?>!</strong><br>
                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                    <a href="../admin/index.php" style="color:#ffeb3b; font-weight:bold;">Quản trị</a> | 
                <?php endif; ?>
                <a href="../login_logout/taikhoan.php" style="color:#a8e6cf;">Tài khoản</a> | 
                <a href="../login_logout/dangxuat.php" style="color:#ff9999;">Đăng xuất</a>
            <?php else: ?>
                <a href="../login_logout/dangnhap.php" style="color:#fff;">Đăng nhập</a> | 
                <a href="../login_logout/dangky.php" style="color:#a8e6cf;">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>
</div>

    <!-- Menu -->
    <div id="templatemo_menu">
        <div id="search_box">
          <form action="../index.php" method="get">
            <input type="text" name="q" placeholder="Tìm sản phẩm..." id="input_field" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" />
            <input type="submit" value="Tìm" id="submit_btn" />
          </form>
        </div>
        <ul>
          <li><a href="../index.php" class="current">Trang chủ</a></li>
        </ul>
      </div>

    <!-- Nội dung -->
    <div id="templatemo_content_wrapper" >
        <div id="templatemo_content" style="width:970px; margin:0 auto; float:none;">
          <div id="content_middle" style="width:930px; padding:20px; background:#fff; min-height:400px; border-radius:6px; box-shadow:0 0 6px rgba(0,0,0,0.1);">
              <h3><?php echo $sp['tensanpham']; ?></h3>
              <div style="display: flex; gap: 20px;">
                  <img src="../images/<?php echo $sp['anh_sanpham']; ?>" alt="<?php echo $sp['tensanpham']; ?>" width="300" height="225" />
                  <div>
                  <p><strong>Mã sản phẩm:</strong> <?php echo $sp['masanpham']; ?></p>
                  <p><strong>Danh mục:</strong> <?php echo $sp['tendanhmuc']; ?></p>
                  <p><strong>Hãng sản xuất:</strong> <?php echo $sp['tenhang']; ?></p>
                  <p><strong>Giá:</strong> <?php echo number_format($sp['gia'], 0, ',', '.'); ?>đ</p>
                  <p><strong>Mô tả:</strong> <?php echo nl2br($sp['mota']); ?></p>
                  <a href="themgiohang.php?id=<?php echo $sp['masanpham']; ?>" class="addtocard">🛒 Thêm vào giỏ</a>                        
                  </div>                        
              </div>             
              <div class="cleaner_h40" style="height: 120px;"></div>                                                          
              <a href="../index.php">← Quay lại trang chủ</a>                  
          </div>                                   
        </div>     
    </div>
    
  </div>
  <div class="cleaner_h30"style="height: 200px;"></div>
</div>

<!-- Footer -->
<?php include "../Header&Footer/footer.php"; ?>
</body>
</html>
