<?php
session_start(); // Bắt đầu session
if (empty($_SESSION['cart'])) {
    echo "<p style='text-align: center; margin-top: 20px;'>Giỏ hàng của bạn trống!</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - HDV Web Sneakers</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <header style="background-color: #333; color: #fff; padding: 1rem; text-align: center;">
        <h1>HDV Web Sneakers</h1>
        <nav>
            <a href="index.php" style="color: #fff; margin: 0 15px; text-decoration: none;">Trang chủ</a>
            <a href="cart.php" style="color: #fff; margin: 0 15px; text-decoration: none;">Giỏ hàng</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <h2 style="text-align: center;">Thông tin thanh toán</h2>
        <form method="POST" action="process_checkout.php"
            style="max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1);">
            <label for="name" style="display: block; margin-bottom: 10px; font-weight: bold;">Họ và tên:</label>
            <input type="text" id="name" name="name" required
                style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

            <label for="address" style="display: block; margin-bottom: 10px; font-weight: bold;">Địa chỉ:</label>
            <input type="text" id="address" name="address" required
                style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

            <label for="phone" style="display: block; margin-bottom: 10px; font-weight: bold;">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" required
                style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

            <p style="text-align: right; font-weight: bold; margin-bottom: 20px;">Tổng cộng:
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    // Giả sử $conn đã được kết nối với cơ sở dữ liệu
                    include 'includes/db.php';
                    $stmt = $conn->prepare("SELECT * FROM shoes WHERE id = ?");
                    $stmt->execute([$product_id]);
                    $product = $stmt->fetch();
                    $total += $product['price'] * $quantity;
                }
                echo number_format($total, 0, ',', '.'); ?> VND
            </p>

            <button type="submit"
                style="width: 100%; padding: 10px; background-color: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">Xác
                nhận thanh toán</button>
        </form>
    </main>
</body>

</html>