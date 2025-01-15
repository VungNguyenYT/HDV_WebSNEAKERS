<?php
session_start(); // Bắt đầu session
include 'includes/db.php'; // Kết nối cơ sở dữ liệu
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - HDV Web Sneakers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }

        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
        }

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .action-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .update-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .checkout-btn {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <h1>HDV Web Sneakers</h1>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="login.php">Đăng nhập</a>
            <a href="register.php">Đăng ký</a>
            <a href="cart.php">Giỏ hàng</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <h2 style="text-align: center;">Giỏ hàng của bạn</h2>

        <?php if (empty($_SESSION['cart'])): ?>
            <p style="text-align: center;">Giỏ hàng của bạn trống!</p>
        <?php else: ?>
            <form method="POST" action="update_cart.php">
                <table>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $product_id => $quantity):
                        $stmt = $conn->prepare("SELECT * FROM shoes WHERE id = ?");
                        $stmt->execute([$product_id]);
                        $product = $stmt->fetch();
                        $subtotal = $product['price'] * $quantity;
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td><img src="<?php echo $product['image']; ?>" style="width: 80px; height: auto;"></td>
                            <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                            <td>
                                <input type="number" name="quantity[<?php echo $product_id; ?>]"
                                    value="<?php echo $quantity; ?>" min="1" style="width: 60px; text-align: center;">
                            </td>
                            <td><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</td>
                            <td>
                                <a href="remove_from_cart.php?product_id=<?php echo $product_id; ?>" class="action-btn">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p style="text-align: right; margin-top: 20px;">Tổng cộng:
                    <strong><?php echo number_format($total, 0, ',', '.'); ?> VND</strong>
                </p>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="submit" class="update-btn">Cập nhật giỏ hàng</button>
                </div>
            </form>
            <div style="text-align: center;">
                <a href="checkout.php" class="checkout-btn">Thanh toán</a>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>