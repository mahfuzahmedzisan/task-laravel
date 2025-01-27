@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h2>Orders List</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Products</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @foreach ($order->products as $product)
                                <p>{{ $product->name }} (Quantity: {{ $product->pivot->quantity }})</p>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('om.orders.show', $order->id) }}" class="btn btn-primary">View</a>
                            <a href="{{ route('om.orders.updateStatus', ['id' => $order->id, 'status' => 'approved']) }}"
                                class="btn btn-success">Approve</a>
                            <a href="{{ route('om.orders.updateStatus', ['id' => $order->id, 'status' => 'declined']) }}"
                                class="btn btn-danger">Decline</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
