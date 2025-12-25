<?php
session_start();
include "../includes/config.php";
include "../includes/hamgiohang.php";
include "../includes/sanpham.php";



$cart_data = get_cart_details();
$cart_items = $cart_data['items'];
$total_amount = $cart_data['total'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Giỏ hàng | Linh Kiện 24h</title>
<link href="../css/templatemo_style.css" rel="stylesheet" type="text/css" />
<link href="../css/giohang.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="templatemo_body_wrapper">
  <div id="templatemo_wrapper">
<!--header-->

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
    <!--menu-->
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
    <!--giua-->
    <div id="templatemo_content_wrapper">
        <div id="templatemo_content" style="width:970px; margin:0 auto; float:none;">
          <div id="content_middle" style="width:930px; padding:20px; background:#fff; min-height:500px; border-radius:6px; box-shadow:0 0 6px rgba(0,0,0,0.1);">
              <h3>Giỏ hàng của bạn (<?php echo count($cart_items); ?> sản phẩm)</h3>
              
              <?php if (count($cart_items) > 0): ?>
                  <?php foreach ($cart_items as $item): ?>
                  <div class="cart-item">
                      <img src="../images/<?php echo $item['anh_sanpham']; ?>" alt="<?php echo $item['tensanpham']; ?>" width="100" height="75"/>                   
                      <div class="item-info">
                          <h4><?php echo $item['tensanpham']; ?></h4>                         
                      </div>
                      <div class="item-price">
                          Giá: <?php echo format_currency($item['gia']); ?>
                      </div>
                      <div class="item-quantity">
                          Số lượng:
                          <a href="capnhatgiohang.php?id=<?php echo urlencode($item['masanpham']); ?>&amp;op=dec" class="qty-btn">-</a>
                          <span class="qty-num"><?php echo $item['quantity']; ?></span>
                          <a href="capnhatgiohang.php?id=<?php echo urlencode($item['masanpham']); ?>&amp;op=inc" class="qty-btn">+</a>
                          <a href="xoagiohang.php?id=<?php echo urlencode($item['masanpham']); ?>" class="delete-item">🗑️ Xóa</a>
                      </div>
                  </div>
                  <?php endforeach; ?>

                  <div class="total-box" style="margin-top:20px; font-size:1.2em;">
                      <strong>Tổng tiền: <?php echo format_currency($total_amount); ?></strong>
                  </div>

                  <?php if (isset($_SESSION['user'])): ?>
                      <a href="dathang.php" class="btn-order">ĐẶT HÀNG NGAY</a>
                  <?php else: ?>
                      <p style="color:#e74c3c; font-weight:bold;">Vui lòng <a href="../login_logout/dangnhap.php">đăng nhập</a> để đặt hàng.</p>
                  <?php endif; ?>

              <?php else: ?>
                  <p style="text-align: center; font-size: 1.1em; color: #666;">
                      Giỏ hàng của bạn hiện đang trống. <a href="../index.php">Quay lại trang chủ để mua sắm.</a>
                  </p>
              <?php endif; ?>
          </div>                                   
        </div>     
    </div>

  </div>
</div>
<!-- Footer -->
<?php include "../Header&Footer/footer.php"; ?>
</body>
</html>
