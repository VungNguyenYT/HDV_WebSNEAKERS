<?php

include 'includes/db.php';
include 'includes/header.php';



if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p style='text-align: center; margin-top: 20px;'>Giỏ hàng của bạn trống!</p>";
} else {
    echo "<div style='padding: 20px;'>";
    echo "<h2 style='text-align: center;'>Giỏ hàng của bạn</h2>";
    echo "<table style='width: 100%; border-collapse: collapse;'>";
    echo "<tr><th>Sản phẩm</th><th>Số lượng</th><th>Giá</th></tr>";

    foreach ($_SESSION['cart'] as $item) {
        $shoe_stmt = $conn->prepare("SELECT * FROM shoes WHERE id = ?");
        $shoe_stmt->execute([$item['shoe_id']]);
        $shoe = $shoe_stmt->fetch();

        echo "<tr style='border-bottom: 1px solid #ddd;'>";
        echo "<td>{$shoe['name']}</td>";
        echo "<td>{$item['quantity']}</td>";
        echo "<td>" . number_format($shoe['price'] * $item['quantity'], 0, ',', '.') . " VND</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
}


?>