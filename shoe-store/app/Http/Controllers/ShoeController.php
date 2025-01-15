<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ | Shoe Store</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">

    <!-- Navbar -->
    <div
        style="background-color: #f8f9fa; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd;">
        <div>
            <a href="#" style="text-decoration: none; font-size: 24px; font-weight: bold; color: #333;">Shoe Store</a>
        </div>
        <div>
            <a href="{{ route('shoes.index') }}" style="margin-right: 20px; text-decoration: none; color: #007bff;">Sản
                Phẩm</a>
            <a href="{{ route('cart') }}" style="margin-right: 20px; text-decoration: none; color: #007bff;">Giỏ
                Hàng</a>
            <a href="{{ route('login') }}" style="text-decoration: none; color: #007bff;">Đăng Nhập</a>
        </div>
    </div>

    <!-- Banner -->
    <div
        style="background: url('https://via.placeholder.com/1920x600') no-repeat center center; background-size: cover; height: 400px; position: relative;">
        <h1
            style="color: white; position: absolute; bottom: 20px; left: 20px; font-size: 3rem; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); margin: 0;">
            Chào mừng đến với Shoe Store</h1>
    </div>

    <!-- Sản phẩm nổi bật -->
    <div style="padding: 20px;">
        <h2 style="margin-bottom: 20px;">Sản phẩm nổi bật</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            @foreach($shoes as $shoe)
            <div
                style="border: 1px solid #ddd; border-radius: 5px; overflow: hidden; width: calc(25% - 20px); box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                <img src="{{ $shoe->image }}" alt="{{ $shoe->name }}"
                    style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 10px; text-align: center;">
                    <h5 style="margin: 0 0 10px;">{{ $shoe->name }}</h5>
                    <p style="margin: 0 0 10px; color: #333;">Giá: {{ number_format($shoe->price, 0, ',', '.') }} VND
                    </p>
                    <a href="#"
                        style="display: inline-block; padding: 8px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Xem
                        Chi Tiết</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <div style="background-color: #f8f9fa; text-align: center; padding: 10px; border-top: 1px solid #ddd;">
        <p style="margin: 0;">© 2025 Shoe Store. All rights reserved.</p>
    </div>

</body>

</html>