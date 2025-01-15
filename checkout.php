<?php
session_start();
include 'includes/db.php';

if (empty($_SESSION['cart'])) {
    die("<p style='text-align: center; color: red;'>Giỏ hàng của bạn trống! <a href='cart.php'>Quay lại</a></p>");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - HDV Web Sneakers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
        }

        header nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
        }

        main {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #f4f4f4;
        }

        form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #555;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <h1>HDV Web Sneakers</h1>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="cart.php">Giỏ hàng</a>
        </nav>
    </header>

    <main>
        <h2 style="text-align: center;">Thông tin thanh toán</h2>
        <table>
            <tr>
                <th>Sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
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
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                    <td><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="total">Tổng cộng</td>
                <td class="total"><?php echo number_format($total, 0, ',', '.'); ?> VND</td>
            </tr>
        </table>

        <h3>Điền thông tin</h3>
        <form method="POST" action="process_checkout.php">
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" required>

            <button type="submit">Xác nhận thanh toán</button>
        </form>
    </main>
</body>

</html>