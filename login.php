<?php
include 'includes/db.php'; // Kết nối cơ sở dữ liệu
include 'includes/header.php'; // Header

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Chuẩn bị câu truy vấn để lấy thông tin người dùng
    $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Kiểm tra tên đăng nhập và mật khẩu
    if ($user && password_verify($password, $user['password'])) { // Sửa 'password' theo đúng tên cột trong CSDL
        session_start();
        $_SESSION['username'] = $user['username'];

        // Phân quyền: chuyển hướng dựa trên vai trò
        if ($user['username'] === 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!');</script>";
    }
}
?>

<main style="padding: 20px;">
    <h2 style="text-align: center; font-family: Arial, sans-serif;">Đăng nhập</h2>
    <form method="POST" action=""
        style="max-width: 400px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1);">
        <label for="username" style="display: block; margin-bottom: 10px; font-weight: bold;">Tên đăng nhập:</label>
        <input type="text" name="username" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="password" style="display: block; margin-bottom: 10px; font-weight: bold;">Mật khẩu:</label>
        <input type="password" name="password" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <button type="submit"
            style="width: 100%; padding: 10px; background-color: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">Đăng
            nhập</button>
    </form>
    <p style="text-align: center; margin-top: 20px;">
        Bạn chưa có tài khoản? <a href="register.php" style="color: #007bff; text-decoration: none;">Đăng ký ngay</a>
    </p>
</main>