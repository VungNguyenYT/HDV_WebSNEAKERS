<?php
// File: db.php (Kết nối cơ sở dữ liệu)

$host = '127.0.0.1'; // Địa chỉ máy chủ
$dbname = 'hdv_bangiay'; // Tên cơ sở dữ liệu
$username = 'root'; // Tên người dùng MySQL
$password = ''; // Mật khẩu (để trống nếu không có)

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>