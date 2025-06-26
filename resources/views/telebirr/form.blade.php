<!DOCTYPE html>
<html>
<head>
    <title>Telebirr Checkout</title>
</head>
<body>
    <h1>Make Payment</h1>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <form method="POST" action="/pay">
        @csrf
        <label>Title:</label>
        <input type="text" name="title" required>
        <br><br>
        <label>Amount:</label>
        <input type="text" name="amount" required>
        <br><br>
        <button type="submit">Pay with Telebirr</button>
    </form>
</body>
</html>
