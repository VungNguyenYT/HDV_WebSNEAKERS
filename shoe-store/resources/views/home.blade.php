<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ | Shoe Store</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .banner {
            background: url('https://via.placeholder.com/1920x600') no-repeat center center;
            background-size: cover;
            height: 400px;
            position: relative;
        }
        .banner h1 {
            color: white;
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 3rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-card .card-body {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Shoe Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shoes.index') }}">Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart') }}">Giỏ Hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Đăng Nhập</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner -->
    <div class="banner">
        <h1>Chào mừng đến với Shoe Store</h1>
    </div>

    <!-- Sản phẩm nổi bật -->
    <div class="container">
        <h2 class="mb-4">Sản phẩm nổi bật</h2>
        <div class="row">
            @foreach($shoes as $shoe)
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="{{ $shoe->image }}" alt="{{ $shoe->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $shoe->name }}</h5>
                        <p class="card-text">Giá: {{ number_format($shoe->price, 0, ',', '.') }} VND</p>
                        <a href="#" class="btn btn-primary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
            @endfo
