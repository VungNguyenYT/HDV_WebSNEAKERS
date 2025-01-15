<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $user_id = $_SESSION['user_id']; // Giả sử user_id đã được lưu khi đăng nhập

    // Tính tổng giá trị giỏ hàng
    $total = 0;
    include 'includes/db.php';
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $conn->prepare("SELECT price FROM shoes WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        $total += $product['price'] * $quantity;
    }

    // Lưu thông tin đơn hàng vào bảng orders
    $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, address, phone, total_price) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $name, $address, $phone, $total]);

    // Xóa giỏ hàng sau khi thanh toán thành công
    unset($_SESSION['cart']);

    echo "<p style='text-align: center; margin-top: 20px;'>Thanh toán thành công! Cảm ơn bạn đã mua sắm tại HDV Web Sneakers.</p>";
}
?>