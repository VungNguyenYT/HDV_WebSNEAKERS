<?php
session_start();
session_destroy(); // Hủy tất cả session
header("Location: index.php"); // Chuyển hướng về trang chủ
exit;
?>