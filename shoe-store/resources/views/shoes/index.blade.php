<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
</head>

<body>
    <!-- Form tìm kiếm -->
    <form action="{{ route('shoes.search') }}" method="GET">
        <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}">
        <button type="submit">Tìm kiếm</button>
    </form>

    <!-- Form lọc sản phẩm -->
    <form action="{{ route('shoes.filter') }}" method="GET">
        <div>
            <label for="brand">Thương hiệu:</label>
            <select name="brand" id="brand">
                <option value="">Tất cả</option>
                <option value="Vans" {{ request('brand') == 'Vans' ? 'selected' : '' }}>Vans</option>
                <option value="Converse" {{ request('brand') == 'Converse' ? 'selected' : '' }}>Converse</option>
                <option value="Nike" {{ request('brand') == 'Nike' ? 'selected' : '' }}>Nike</option>
                <option value="Adidas" {{ request('brand') == 'Adidas' ? 'selected' : '' }}>Adidas</option>
                <option value="Bitis" {{ request('brand') == 'Bitis' ? 'selected' : '' }}>Bitis</option>
            </select>
        </div>
        <div>
            <label for="min_price">Giá tối thiểu:</label>
            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="0">
        </div>
        <div>
            <label for="max_price">Giá tối đa:</label>
            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                placeholder="1000000">
        </div>
        <button type="submit">Lọc sản phẩm</button>
    </form>

    <!-- Danh sách sản phẩm -->
    <h1>Danh sách sản phẩm</h1>

    @if(isset($keyword))
        <p>Kết quả tìm kiếm cho từ khóa: "{{ $keyword }}"</p>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        @forelse($shoes as $shoe)
            <div style="border: 1px solid #ccc; padding: 10px; width: 200px;">
                <img src="{{ $shoe->image }}" alt="{{ $shoe->name }}" style="width: 100%; height: auto;">
                <h3>{{ $shoe->name }}</h3>
                <p>Thương hiệu: {{ $shoe->brand }}</p>
                <p>Giá: {{ number_format($shoe->price, 0, ',', '.') }} VND</p>
            </div>
        @empty
            <p>Không tìm thấy sản phẩm nào phù hợp.</p>
        @endforelse
    </div>

    <div>
        {{ $shoes->links() }} <!-- Hiển thị phân trang -->
    </div>
</body>

</html>