<h1>Giỏ hàng</h1>
<table>
    <tr>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá</th>
        <th>Thành tiền</th>
        <th>Hành động</th>
    </tr>
    @foreach($cartItems as $item)
        <tr>
            <td>{{ $item->shoe->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->shoe->price }}</td>
            <td>{{ $item->shoe->price * $item->quantity }}</td>
            <td>
                <form action="{{ route('cart.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{ $item->id }}">
                    <button type="submit">Xóa</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
<a href="{{ route('checkout') }}">Thanh toán</a>