<?php
session_start();
include "../includes/hamgiohang.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id)) {
    remove_from_cart($id);
}

header("Location: giohang.php");
exit();
?>