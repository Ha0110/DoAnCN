<?php
session_start();
include "../includes/hamgiohang.php"; 
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!empty($id)) {
    add_to_cart($id, 1);
}
header("Location: giohang.php");
exit();
?>