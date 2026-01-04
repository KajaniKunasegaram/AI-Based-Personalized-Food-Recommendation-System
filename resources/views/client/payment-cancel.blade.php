@extends('client.layout')

@section('content')
<div class="container" style="padding:50px;text-align:center;">
    <h2>Payment Cancelled ❌</h2>
    <p>Your payment was not completed.</p>
    <a href="{{ route('checkout') }}" class="btn btn-primary">Back to Checkout</a>
</div>
@endsection
