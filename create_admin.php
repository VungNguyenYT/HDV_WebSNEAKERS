<?php
session_start();
include 'includes/db.php'; // Kết nối cơ sở dữ liệu

// Xử lý khi người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Kiểm tra mật khẩu có khớp không
    if ($password !== $confirm_password) {
        $error_message = "Mật khẩu và xác nhận mật khẩu không khớp!";
    } else {
        // Kiểm tra xem tên đăng nhập đã tồn tại chưa
        $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE username = ?");
        $stmt->execute([$username]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error_message = "Tên đăng nhập đã tồn tại!";
        } else {
            // Mã hóa mật khẩu và lưu tài khoản vào cơ sở dữ liệu
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO nguoi_dung (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashed_password]);

            $success_message = "Tài khoản admin đã được tạo thành công!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo tài khoản Admin</title>
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

        form {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form h2 {
            text-align: center;
            margin-bottom: 20px;
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

        .message {
            text-align: center;
            font-weight: bold;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <header>
        <h1>Tạo tài khoản Admin</h1>
    </header>

    <main>
        <form method="POST" action="">
            <h2>Tạo Admin</h2>
            <?php if (!empty($error_message)): ?>
                <p class="message error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <?php if (!empty($success_message)): ?>
                <p class="message success"><?php echo $success_message; ?></p>
            <?php endif; ?>

            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Xác nhận mật khẩu:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Tạo tài khoản</button>
        </form>
    </main>
</body>

</html>