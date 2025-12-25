<?php


function connect_db() {
    $host = 'localhost';
    $dbname = 'db_linhkien';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Lỗi kết nối CSDL: " . $e->getMessage());
    }
}


global $conn;
$conn = connect_db();


?>