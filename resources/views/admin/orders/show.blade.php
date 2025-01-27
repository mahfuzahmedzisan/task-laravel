@extends('admin.layouts.master')

@section('content')
<div class="container">
    <a href="{{ route('om.orders.index') }}" class="btn btn-primary">Back to Order List</a>
    <h2>Order Details - Order #{{ $order->id }}</h2>
    <p><strong>User:</strong> {{ $order->user->name }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>

    <h4>Ordered Products</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
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
</div>
@endsection
