@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

    @if($cart->products->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>${{ $product->price * $product->pivot->quantity }}</td>
                        <td>
                            <form action="{{ route('customer.cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('customer.order.place') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Place Order</button>
        </form>
    @endif
</div>
@endsection
