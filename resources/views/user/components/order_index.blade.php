@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <p>You haven't placed any orders yet.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Products</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            <ul>
                                @foreach($order->products as $product)
                                    <li>{{ $product->name }} (x{{ $product->pivot->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @php
                                $total = $order->orderProducts->sum(function($orderProduct) {
                                    return $orderProduct->product->price * $orderProduct->quantity;
                                });
                            @endphp
                            ${{ number_format($total, 2) }}
                        </td>
                        <td>
                            <a href="{{ route('customer.order.details', $order->id) }}" class="btn btn-info">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
