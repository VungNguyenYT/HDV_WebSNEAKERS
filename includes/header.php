<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'HDV Web Sneakers'; ?></title>
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
    </style>
</head>

<body>
    <header>
        <h1>HDV Web Sneakers</h1>
        <nav>
            <a href="index.php">Trang chủ</a>
            <a href="login.php">Đăng nhập</a>
            <a href="register.php">Đăng ký</a>
            <a href="cart.php">Giỏ hàng</a> <!-- Nút giỏ hàng -->
        </nav>
    </header>