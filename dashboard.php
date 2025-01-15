<?php
session_start();
include 'includes/db.php';

// Kiểm tra xem admin đã đăng nhập chưa
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    die("<p style='text-align: center; color: red;'>Bạn không có quyền truy cập trang này! <a href='login.php'>Đăng nhập</a></p>");
}

// Lấy tổng số đơn hàng
$order_count_stmt = $conn->prepare("SELECT COUNT(*) AS total_orders FROM orders");
$order_count_stmt->execute();
$total_orders = $order_count_stmt->fetch()['total_orders'];

// Lấy tổng doanh thu
$revenue_stmt = $conn->prepare("SELECT SUM(total_price) AS total_revenue FROM orders");
$revenue_stmt->execute();
$total_revenue = $revenue_stmt->fetch()['total_revenue'] ?? 0;

// Lấy tổng số sản phẩm
$product_count_stmt = $conn->prepare("SELECT COUNT(*) AS total_products FROM shoes");
$product_count_stmt->execute();
$total_products = $product_count_stmt->fetch()['total_products'];

// Lấy tổng số người dùng
$user_count_stmt = $conn->prepare("SELECT COUNT(*) AS total_users FROM nguoi_dung");
$user_count_stmt->execute();
$total_users = $user_count_stmt->fetch()['total_users'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HDV Web Sneakers</title>
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
            padding: 1rem;
            text-align: center;
        }

        header nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: #fff;
            text-align: center;
            flex: 1;
            margin: 10px;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .dashboard {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .table-section {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <header>
        <h1>HDV Web Sneakers - Dashboard</h1>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="logout.php">Đăng xuất</a>
        </nav>
    </header>

    <main>
        <h2>Chào mừng, Admin</h2>
        <div class="dashboard">
            <div class="card">
                <h3>Tổng số đơn hàng</h3>
                <p><?php echo $total_orders; ?></p>
            </div>
            <div class="card">
                <h3>Tổng doanh thu</h3>
                <p><?php echo number_format($total_revenue, 0, ',', '.'); ?> VND</p>
            </div>
            <div class="card">
                <h3>Tổng số sản phẩm</h3>
                <p><?php echo $total_products; ?></p>
            </div>
            <div class="card">
                <h3>Tổng số người dùng</h3>
                <p><?php echo $total_users; ?></p>
            </div>
        </div>

        <!-- Quản lý đơn hàng -->
        <div class="table-section">
            <h3>Danh sách đơn hàng</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Tổng tiền</th>
                    <th>Thời gian</th>
                </tr>
                <?php
                $orders_stmt = $conn->prepare("SELECT * FROM orders ORDER BY created_at DESC");
                $orders_stmt->execute();
                $orders = $orders_stmt->fetchAll();
                foreach ($orders as $order):
                    ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['customer_name']; ?></td>
                        <td><?php echo $order['address']; ?></td>
                        <td><?php echo $order['phone']; ?></td>
                        <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?> VND</td>
                        <td><?php echo $order['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>

</html>