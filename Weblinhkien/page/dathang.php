<?php
session_start();
include "../includes/config.php";
include "../includes/hamgiohang.php";
include "../includes/donhang.php";
include "../includes/sanpham.php";

// Kiểm tra đăng nhập
if (!isset($_SESSION['user'])) {
    header('Location: ../login_logout/dangnhap.php');
    exit();
}

$manguoidung = $_SESSION['user']['manguoidung'];

// Lấy thông tin giỏ hàng
$cart_data = get_cart_details();
$cart_items = $cart_data['items'];
$total_amount = $cart_data['total'];

// Nếu giỏ hàng trống, chuyển về trang chủ
if (empty($cart_items)) {
    header('Location: giohang.php');
    exit();
}

// Lấy danh sách địa chỉ của người dùng
$diachilist = get_diachi_by_user($manguoidung);

// Thêm địa chỉ mới nếu form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_address'])) {
    $tennguoinhan = trim($_POST['tennguoinhan']);
    $sodienthoai = trim($_POST['sodienthoai']);
    $diachi = trim($_POST['diachi']);
    $thanhpho = trim($_POST['thanhpho']);
    
    if (!empty($tennguoinhan) && !empty($sodienthoai) && !empty($diachi) && !empty($thanhpho)) {
        if (them_diachi($manguoidung, $tennguoinhan, $sodienthoai, $diachi, $thanhpho)) {
            $diachilist = get_diachi_by_user($manguoidung);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đặt hàng | Linh Kiện 24h</title>
<link href="../css/templatemo_style.css" rel="stylesheet" type="text/css" />
<style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 0; }
        .order-wrapper { width: 100%; max-width: 100%; }
        .order-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .order-container h2 { font-size: 1.8em; color: #222; margin-bottom: 20px; }
        
        .order-row { display: flex; gap: 20px; margin-top: 20px; }
        .order-left { flex: 1; min-width: 0; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .order-right { width: 320px; padding: 20px; background: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        
        .order-left h3, .order-right h3 { margin-top: 0; color: #222; font-size: 1.2em; }
        
        .form-group { margin: 12px 0; }
        label { font-weight: bold; display: block; margin-bottom: 6px; color: #333; font-size: 0.95em; }
        input[type="text"], input[type="tel"], select, textarea { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            font-size: 14px; 
            font-family: Arial, sans-serif;
            margin-bottom: 8px;
        }
        textarea { height: 80px; resize: vertical; }
        input[type="text"]:focus, input[type="tel"]:focus, select:focus, textarea:focus { 
            outline: none; 
            border-color: #27ae60; 
            box-shadow: 0 0 4px rgba(39, 174, 96, 0.2);
        }
        
        .btn { 
            padding: 11px 18px; 
            background: #27ae60; 
            color: #fff; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
            text-align: center;
            transition: background 0.2s;
        }
        .btn:hover { background: #229954; }
        .btn-secondary { background: #95a5a6; }
        .btn-secondary:hover { background: #7f8c8d; }
        
        .address-box { 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            margin: 10px 0; 
            cursor: pointer;
            transition: all 0.2s;
            background: #fff;
        }
        .address-box:hover { border-color: #27ae60; background: #f5f5f5; }
        .address-box.selected { border: 2px solid #27ae60; background: #eafef2; }
        .address-box input[type="radio"] { margin-top: 8px; }
        
        .summary-box { background: #fff; padding: 15px; border-radius: 8px; border: 1px solid #eee; }
        .summary-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; font-size: 0.95em; }
        .summary-item:last-child { border-bottom: none; }
        .summary-total { 
            font-size: 1.25em; 
            font-weight: bold; 
            color: #27ae60; 
            text-align: right; 
            padding: 12px 0 0 0; 
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 12px;
        }
        
        .tab { display: none; }
        .tab.active { display: block; }
        .tabs { display: flex; gap: 10px; margin-bottom: 20px; }
        .tab-btn { 
            padding: 10px 16px; 
            background: #e8e8e8; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold;
            font-size: 14px;
            transition: all 0.2s;
        }
        .tab-btn:hover { background: #d0d0d0; }
        .tab-btn.active { background: #27ae60; color: #fff; }
        
        @media (max-width: 768px) {
            .order-row { flex-direction: column; }
            .order-right { width: 100%; }
            .order-left, .order-right { padding: 15px; }
        }
    </style>
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
              <h3>ĐẶT HÀNG</h3>
              
            <div class="order-row" style="display:flex; gap:20px; margin-top:15px;">
                <div class="order-left" style="flex:1;">

                    <!-- Tabs -->
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(0)">Chọn địa chỉ</button>
                        <button class="tab-btn" onclick="switchTab(1)">Thêm địa chỉ mới</button>
                    </div>

                    <!-- Tab 1: Chọn địa chỉ hiện có -->
                    <div class="tab active">
                        <h3>Địa chỉ giao hàng</h3>
                        <?php if (!empty($diachilist)): ?>
                            <form method="post" action="xulydathang.php">
                                <?php foreach ($diachilist as $dc): ?>
                                    <div class="address-box" onclick="selectAddress(this, '<?= $dc['madiachi'] ?>')">
                                        <strong><?= htmlspecialchars($dc['tennguoinhan']); ?></strong><br/>
                                        Điện thoại: <?= htmlspecialchars($dc['sodienthoai']); ?><br/>
                                        Địa chỉ: <?= htmlspecialchars($dc['diachi']); ?>, <?= htmlspecialchars($dc['thanhpho']); ?><br/>
                                        <input type="radio" name="madiachi" value="<?= $dc['madiachi']; ?>" style="margin-top:8px;" />
                                    </div>
                                <?php endforeach; ?>
                                <button type="submit" class="btn" style="width:100%; margin-top:15px;">Tiếp tục</button>
                            </form>
                        <?php else: ?>
                            <p style="color:#666;">Bạn chưa có địa chỉ nào. Vui lòng <strong>thêm địa chỉ mới</strong>.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Tab 2: Thêm địa chỉ mới -->
                    <div class="tab">
                        <h3>Thêm địa chỉ giao hàng mới</h3>
                        <form method="post">
                            <div class="form-group">
                                <label>Họ tên người nhận *</label>
                                <input type="text" name="tennguoinhan" required />
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại *</label>
                                <input type="tel" name="sodienthoai" required />
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ chi tiết *</label>
                                <textarea name="diachi" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Thành phố/Tỉnh *</label>
                                <input type="text" name="thanhpho" required />
                            </div>
                            <button type="submit" name="add_address" class="btn" style="width:100%;">Thêm địa chỉ</button>
                        </form>
                    </div>
                </div>

                <!-- Cột phải: Tóm tắt đơn hàng -->
                <div class="order-right" style="width:250px;">
                    <div style="background:#f9f9f9; padding:15px; border-radius:5px;">
                        <h4 style="margin-top:0;">Tóm tắt đơn hàng</h4>
                        <?php foreach ($cart_items as $item): ?>
                            <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #eee; font-size:0.9em;">
                                <span><?= htmlspecialchars($item['tensanpham']); ?> x<?= $item['quantity']; ?></span>
                                <span><?= number_format($item['subtotal'], 0, ',', '.'); ?>₫</span>
                            </div>
                        <?php endforeach; ?>
                        <div style="font-size:1.2em; font-weight:bold; color:#e74c3c; text-align:right; padding:12px 0; border-top:1px solid #ddd; margin-top:8px;">
                            Tổng: <?= number_format($total_amount, 0, ',', '.'); ?>₫
                        </div>
                    </div>
                </div>
            </div>
          </div>                                   
        </div>     
    </div>

  </div>
</div>
<!-- Footer -->
<?php include "../Header&Footer/footer.php"; ?>

<script>
function switchTab(index) {
    const tabs = document.querySelectorAll('.tab');
    const btns = document.querySelectorAll('.tab-btn');
    
    tabs.forEach(tab => tab.classList.remove('active'));
    btns.forEach(btn => btn.classList.remove('active'));
    
    tabs[index].classList.add('active');
    btns[index].classList.add('active');
}

function selectAddress(el, id) {
    const radio = el.querySelector('input[type="radio"]');
    radio.checked = true;
    
    // Bỏ class selected từ tất cả
    document.querySelectorAll('.address-box').forEach(box => {
        box.classList.remove('selected');
    });
    
    // Thêm class selected vào phần tử được chọn
    el.classList.add('selected');
}
</script>
</body>
</html>
