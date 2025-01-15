<?php
include 'includes/db.php'; // Kết nối cơ sở dữ liệu
include 'includes/header.php'; // Header



$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = 'Mật khẩu và Nhập lại mật khẩu không khớp!';
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Lưu thông tin vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO nguoi_dung (USERNAME, PASSWORD) VALUES (?, ?)");
        $stmt->execute([$username, $hashed_password]);

        echo "<script>alert('Đăng ký thành công! Hãy đăng nhập.'); window.location='login.php';</script>";
    }
}
?>

<main style="padding: 20px;">
    <h2 style="text-align: center; font-family: Arial, sans-serif;">Đăng ký</h2>
    <?php if ($error): ?>
        <p style="color: red; text-align: center;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action=""
        style="max-width: 400px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1);">
        <label for="username" style="display: block; margin-bottom: 10px; font-weight: bold;">Tên đăng nhập:</label>
        <input type="text" name="username" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="password" style="display: block; margin-bottom: 10px; font-weight: bold;">Mật khẩu:</label>
        <input type="password" name="password" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="confirm_password" style="display: block; margin-bottom: 10px; font-weight: bold;">Nhập lại mật
            khẩu:</label>
        <input type="password" name="confirm_password" required
            style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">

        <button type="submit"
            style="width: 100%; padding: 10px; background-color: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">Đăng
            ký</button>
    </form>
    <p style="text-align: center; margin-top: 20px;">
        Đã có tài khoản? <a href="login.php" style="color: #007bff; text-decoration: none;">Đăng nhập</a>
    </p>
</main>