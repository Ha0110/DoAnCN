<?php
if (session_status() == PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

function add_to_cart($id, $quantity = 1)
{
    $quantity = (int)$quantity;

    if (empty($id) || $quantity <= 0) return;

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $quantity;
    } else {
        $_SESSION['cart'][$id] = $quantity;
    }
}

function update_cart_quantity($id, $quantity)
{
    $quantity = (int)$quantity;
    if (empty($id)) return;

    if ($quantity > 0) {
        $_SESSION['cart'][$id] = $quantity;
    } else {
        remove_from_cart($id);
    }
}

function remove_from_cart($id)
{
    if (isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);
}

function get_cart_details()
{
    include_once "sanpham.php";
    $items = [];
    $total = 0;

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $qty) {
            $product = get_sp_id($id);

            if ($product && !empty($product)) {
                $product['quantity'] = $qty;
                $product['subtotal'] = $product['gia'] * $qty;
                $items[] = $product;
                $total += $product['subtotal'];
            }
        }
    }
    return ['items' => $items, 'total' => $total];
}

function get_cart_count()
{
    if (empty($_SESSION['cart'])) return 0;
    return array_sum($_SESSION['cart']);
}

function format_currency($amount)
{
    return number_format($amount, 0, ',', '.') . '₫';
}




if (!function_exists('get_cart_count')) {
    function get_cart_count() {
        if (empty($_SESSION['cart'])) {
            return 0;
        }
        return array_sum($_SESSION['cart']);
    }
}

?>