<?php
session_start();
include 'includes/db.php';

// Kiểm tra nếu có `id` của sản phẩm được gửi qua GET
if (!isset($_GET['id'])) {
    die("<p style='text-align: center; color: red;'>Không tìm thấy sản phẩm! <a href='index.php'>Quay lại</a></p>");
}

$product_id = intval($_GET['id']);

// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT * FROM shoes WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    die("<p style='text-align: center; color: red;'>Không tìm thấy sản phẩm! <a href='index.php'>Quay lại</a></p>");
}

// Lấy các sản phẩm cùng thương hiệu
$stmt_same_brand = $conn->prepare("SELECT * FROM shoes WHERE brand = ? AND id != ? LIMIT 4");
$stmt_same_brand->execute([$product['brand'], $product_id]);
$same_brand_products = $stmt_same_brand->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - <?php echo $product['name']; ?></title>
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
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product {
            display: flex;
            gap: 20px;
        }

        .product img {
            max-width: 300px;
            border-radius: 10px;
        }

        .product-details {
            flex: 1;
        }

        .product-details h1 {
            margin-bottom: 10px;
        }

        .product-details p {
            margin: 10px 0;
        }

        .product-details button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .product-details button:hover {
            background-color: #555;
        }

        .related-products {
            margin-top: 40px;
        }

        .related-products h3 {
            margin-bottom: 20px;
        }

        .related-products .product {
            display: flex;
            gap: 20px;
        }

        .related-product-card {
            flex: 1;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .related-product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
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
        <!-- Chi tiết sản phẩm -->
        <div class="product">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <div class="product-details">
                <h1><?php echo $product['name']; ?></h1>
                <p><strong>Thương hiệu:</strong> <?php echo $product['brand']; ?></p>
                <p><strong>Giá:</strong> <?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
                <p><strong>Mô tả:</strong> <?php echo $product['description']; ?></p>
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>

        <!-- Các sản phẩm cùng thương hiệu -->
        <div class="related-products">
            <h3>Các sản phẩm cùng thương hiệu</h3>
            <div class="product">
                <?php foreach ($same_brand_products as $same_product): ?>
                    <div class="related-product-card">
                        <img src="<?php echo $same_product['image']; ?>" alt="<?php echo $same_product['name']; ?>">
                        <h4><?php echo $same_product['name']; ?></h4>
                        <p><?php echo number_format($same_product['price'], 0, ',', '.'); ?> VND</p>
                        <a href="product_detail.php?id=<?php echo $same_product['id']; ?>">Xem chi tiết</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>

</html>