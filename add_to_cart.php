<?php
session_start();

$product_id = $_POST['product_id'];
$quantity = 1; // Mặc định số lượng là 1

// Kiểm tra giỏ hàng trong session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Khởi tạo giỏ hàng nếu chưa tồn tại
}

// Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity; // Tăng số lượng nếu đã tồn tại
} else {
    $_SESSION['cart'][$product_id] = $quantity; // Thêm mới sản phẩm
}

header("Location: cart.php"); // Chuyển hướng đến trang giỏ hàng
exit;
?>