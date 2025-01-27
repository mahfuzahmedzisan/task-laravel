@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Cart</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($cart->products->isEmpty())
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
                    @foreach ($cart->products as $product)
                        <tr id="product-{{ $product->id }}">
                            <td>{{ $product->name }}</td>
                            <td>
                                <input type="number" class="quantity-input" data-product-id="{{ $product->id }}"
                                    value="{{ $product->pivot->quantity }}" min="1" style="width: 80px;">
                            </td>
                            <td class="product-price">${{ $product->price * $product->pivot->quantity }}</td>
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

@push('js')
    <script>
        const quantityInputs = document.querySelectorAll('.quantity-input');

        const handleQuantityChange = async (event) => {
            const productId = event.target.getAttribute('data-product-id');
            const quantity = event.target.value;

            if (quantity < 1 || isNaN(quantity)) {
                alert('Please enter a valid quantity');
                return;
            }

            // Prepare FormData for the request
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            try {
                const response = await fetch('{{ route('customer.cart.update') }}', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Update the price dynamically
                    const priceCell = document.querySelector(`#product-${productId} .product-price`);
                    priceCell.textContent = `$${data.product_price.toFixed(2)}`;
                } else {
                    alert(data.message || 'Error updating the quantity');
                }
            } catch (error) {
                alert('Error updating the quantity');
                console.error(error);
            }
        };

        quantityInputs.forEach(input => {
            input.addEventListener('change', handleQuantityChange);
        });
    </script>
@endpush
