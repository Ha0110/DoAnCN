<?php
include "includes/config.php";
include "includes/hamgiohang.php";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <title>Cửa hàng linh kiện máy tính</title>
  <meta name="description" content="Cửa hàng linh kiện máy tính - Mua sắm trực tuyến giá rẻ, chất lượng." />
  <meta name="keywords" content="linh kiện máy tính, phụ kiện, cửa hàng, mua sắm" />
  <link href="css/templatemo_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div id="templatemo_body_wrapper">
    <div id="templatemo_wrapper">

      <!-- Header -->
      <?php include "Header&Footer/header.php"; ?>

      <!-- Menu -->
      <div id="templatemo_menu">
        <div id="search_box">
          <form action="index.php" method="get">
            <input type="text" name="q" placeholder="Tìm sản phẩm..." id="input_field" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" />
            <input type="submit" value="Tìm" id="submit_btn" />
          </form>
        </div>
        <ul>
          <li><a href="index.php" class="current">Trang chủ</a></li>
        </ul>
      </div>

      <!-- Nội dung -->
      <div id="templatemo_content_wrapper">

        <!-- Cột trái -->
        <?php
        include "includes/danhmuc.php";
        $dsdm = get_all_danhmuc();
        ?>
        <div class="templatemo_sidebar_wrapper float_l">
          <div class="templatemo_sidebar_top"></div>
          <div class="templatemo_sidebar">
            <div class="sidebar_box">
              <h2><a href="#">Danh mục sản phẩm</a></h2>
              <div class="sidebar_box_content">
                <ul class="categories_list">
                  <li><a href="index.php">Tất cả sản phẩm</a></li>
                  <?php if (!empty($dsdm)): ?>
                    <?php foreach ($dsdm as $dm): ?>
                      <li>
                        <a href="index.php?danhmuc=<?php echo $dm['madanhmuc']; ?>">
                          <?php echo $dm['tendanhmuc']; ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <li>Không có danh mục.</li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="templatemo_sidebar_bottom"></div>
        </div>
        <!-- Giữa - Sản phẩm nổi bật -->
        <div id="templatemo_content">
          <div id="banner">
            <a href="#"><img src="images/banner.jpg" alt="Khuyến mãi hot" /></a>
          </div>

          <div id="content_top"></div>
          <div id="content_middle">
            <h3>Sản phẩm nổi bật</h3>

            <?php
            include_once 'includes/sanpham.php';

            $sp = [];

            //  tìm kiếm
            if (isset($_GET['q']) && trim($_GET['q']) !== '') {
              $keyword = '%' . trim($_GET['q']) . '%';
              $sp = search_sp_by_name($keyword);
            }
            // danh mục
            elseif (isset($_GET['danhmuc'])) {
              $madanhmuc = $_GET['danhmuc'];
              $sp = get_sp_dm($madanhmuc);
            } else {
              $sp = getall_sp();
            }
            ?>

            <?php if (count($sp) > 0): ?>
              <?php $i = 0;
              ?>
              <?php foreach ($sp as $p): ?>
                <?php

                $add_margin = ($i % 2 == 0) ? ' margin_r20' : '';
                $i++;
                ?>

                <div class="product_box<?php echo $add_margin; ?>">
                  <a href="page/chitietsanpham.php?id=<?php echo $p['masanpham']; ?>">
                    <img src="images/<?php echo $p['anh_sanpham']; ?>"
                      alt="<?php echo htmlspecialchars($p['tensanpham']); ?>"
                      width="220" height="165" />
                  </a>
                  <h3><?php echo htmlspecialchars($p['tensanpham']); ?></h3>

                  <p class="price">Giá: <span><?php echo number_format($p['gia'], 0, ',', '.'); ?>đ</span></p>

                  <a href="page/chitietsanpham.php?id=<?php echo $p['masanpham']; ?>" class="detail">Chi tiết</a>
                  <a href="page/themgiohang.php?id=<?php echo $p['masanpham']; ?>" class="addtocard">Thêm vào giỏ</a>

                  <div class="cleaner"></div>
                </div>

                <?php

                if ($i % 2 == 0): ?>
                  <div class="cleaner"></div>
                <?php endif; ?>
              <?php endforeach; ?>

              <?php

              if ($i % 2 != 0): ?>
                <div class="cleaner"></div>
              <?php endif; ?>

            <?php else: ?>
              <p style="text-align:center; padding:50px 0; color:#666;">Không có sản phẩm nào.</p>
            <?php endif; ?>

          </div>
          <div id="content_bottom"></div>
        </div>
        <div class="cleaner"></div>
        <div class="cleaner"></div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include "Header&Footer/footer.php"; ?>
</body>

</html>