@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Order #{{ $order->id }} Details</h2>

        <div class="order-details">
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>
            <p><strong>Total Amount:</strong> ${{ $order->products->sum(function($product) { return $product->price * $product->pivot->quantity; }) }}</p>

            <h4>Products in this Order:</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>${{ $product->price }}</td>
                            <td>${{ $product->price * $product->pivot->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('customer.order.show') }}" class="btn btn-primary">Back to Orders</a>
        </div>
    </div>
@endsection
