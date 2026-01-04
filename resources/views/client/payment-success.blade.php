<!-- @extends('client.layout') -->

<!-- @section('content') -->
<div class="container" style="padding:50px;text-align:center;">
    <h2>Payment Successful ✅</h2>
    <p>Thank you! Your order has been received.</p>
    <a href="{{ route('orders') }}" class="btn btn-primary">Back to Orders</a>
</div>
<!-- @endsection -->
<script>
    // Clear cart after successful payment
    localStorage.removeItem('cart');

    // Optionally, update cart box UI if it exists on this page
    const cartBox = document.getElementById('cartBox');
    if(cartBox){
        cartBox.style.display = 'none';
        document.getElementById('cartTotal').innerText = '0.00';
    }
</script>