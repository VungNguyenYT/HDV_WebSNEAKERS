<?php
session_start(); // Bắt đầu session
include 'includes/header.php';

include 'includes/db.php';

// Tiêu đề cho trang
$title = 'Trang chủ - HDV Web Sneakers';

// Lấy danh sách sản phẩm từ bảng shoes
$query = "SELECT * FROM shoes";
if (isset($_GET['brand'])) {
    $brand = $_GET['brand'];
    $query .= " WHERE brand = '$brand'";
} elseif (isset($_GET['query'])) {
    $search = $_GET['query'];
    $query .= " WHERE name LIKE '%$search%'";
}
$stmt = $conn->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!-- Nội dung chính -->
<main style="padding: 20px;">
    <h2 style="text-align: center;">Danh sách sản phẩm</h2>

    <!-- Bộ lọc thương hiệu -->
    <form method="GET" action="" style="margin-bottom: 20px; text-align: center;">
        <label for="brand">Lọc theo thương hiệu:</label>
        <select name="brand" onchange="this.form.submit()">
            <option value="">Tất cả</option>
            <option value="Vans">Vans</option>
            <option value="Nike">Nike</option>
            <option value="Adidas">Adidas</option>
            <option value="Bitis">Bitis</option>
            <option value="Converse">Converse</option>
        </select>
    </form>

    <!-- Hiển thị sản phẩm -->
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
        <?php foreach ($products as $product): ?>
            <div style="border: 1px solid #ddd; padding: 10px; width: 200px; text-align: center;">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"
                    style="width: 100%; height: auto;">
                <h3><?php echo $product['name']; ?></h3>
                <p>Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
                <a href="product_detail.php?id=<?php echo $product['id']; ?>"
                    style="display: block; margin: 10px 0; color: #333;">Xem chi tiết</a>
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit"
                        style="background-color: #333; color: #fff; padding: 10px; border: none; cursor: pointer;">Thêm vào
                        giỏ hàng</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>