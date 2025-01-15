<h1>Thanh toán</h1>
<form action="{{ route('checkout.placeOrder') }}" method="POST">
    @csrf
    <div>
        <label for="fullname">Họ và tên:</label>
        <input type="text" id="fullname" name="fullname" required>
    </div>
    <div>
        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" required>
    </div>
    <div>
        <label for="address">Địa chỉ:</label>
        <textarea id="address" name="address" required></textarea>
    </div>
    <button type="submit">Đặt hàng</button>
</form>