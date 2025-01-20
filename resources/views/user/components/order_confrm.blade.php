@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Confirmation</h1>
    <p>Your order has been placed successfully! We will notify you once it's processed.</p>
    <a href="{{ route('customers.products.index') }}" class="btn btn-primary">Continue Shopping</a>
</div>
@endsection
