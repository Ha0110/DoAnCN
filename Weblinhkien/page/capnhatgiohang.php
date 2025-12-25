<?php
session_start();
include "../includes/hamgiohang.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';
$op = isset($_GET['op']) ? $_GET['op'] : '';

if (!empty($id) && in_array($op, ['inc', 'dec'])) {
    // Tăng
    if ($op === 'inc') {
        // Nếu chưa đạt giới hạn 10 sản phẩm, mới cho tăng
        if (function_exists('get_cart_count')) {
            $currentTotal = get_cart_count();
            if ($currentTotal < 10) {
                add_to_cart($id, 1);
            }
        } else {
            add_to_cart($id, 1);
        }
    }

    // Giảm
    if ($op === 'dec') {
        // Nếu tồn tại trong giỏ hàng, giảm 1
        if (isset($_SESSION['cart'][$id])) {
            $current = (int)$_SESSION['cart'][$id];
            $new = $current - 1;
            if ($new > 0) {
                update_cart_quantity($id, $new);
            } else {
                remove_from_cart($id);
            }
        }
    }
}

header('Location: giohang.php');
exit();

?>
