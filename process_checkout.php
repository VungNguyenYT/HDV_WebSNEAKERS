<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("<p>Bạn phải đăng nhập để thanh toán! <a href='login.php'>Đăng nhập</a></p>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $user_id = $_SESSION['user_id'];

    include 'includes/db.php';

    // Tính tổng giá trị đơn hàng
    $total = 0;
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $stmt = $conn->prepare("SELECT price FROM shoes WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        $total += $product['price'] * $quantity;
    }

    // Lưu đơn hàng
    $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, address, phone, total_price) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $name, $address, $phone, $total]);

    // Xóa giỏ hàng
    unset($_SESSION['cart']);

    echo "<p>Thanh toán thành công! Cảm ơn bạn đã mua sắm tại HDV Web Sneakers.</p>";
}
?>