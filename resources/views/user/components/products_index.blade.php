@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <h1>Products</h1>
        <div id="messages"></div>
        <div class="row gy-3">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZHVjdHxlbnwwfHwwfHx8MA%3D%3D' }}"
                            class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p><strong>${{ $product->price }}</strong></p>

                            @if (auth()->check())
                                <form action="{{ route('customer.cart.add') }}" method="POST" class="add-to-cart-form"
                                    data-product-id="{{ $product->id }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <!-- Ensure a quantity is set here -->
                                    <button type="submit" class="btn btn-primary mt-2">Add to Cart now</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary mt-2">Add to Cart</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


@push('js')
    <script>
        const messages = document.getElementById('messages');
        const addToCart = document.querySelectorAll('.add-to-cart-form');

        const handleFormSubmit = async (event) => {
            event.preventDefault();

            let formData = new FormData(event.target);

            try {
                const response = await fetch('{{ route('customer.cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                    },
                    body: formData,
                });

                const data = await response.json();

                if (data.success) {
                    messages.textContent = "Product added to cart!";
                    messages.classList.add('alert', 'alert-success');
                    setTimeout(() => {
                        messages.classList.remove('alert', 'alert-success');
                        messages.textContent = '';
                    }, 3000);
                } else {
                    messages.textContent = 'Something went wrong. Please try again.';
                    messages.classList.add('alert', 'alert-danger');
                    setTimeout(() => {
                        messages.classList.remove('alert', 'alert-danger');
                        messages.textContent = '';
                    }, 3000);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error adding product to cart.');
            }
        };

        // Add event listeners to all forms
        addToCart.forEach(function(form) {
            form.addEventListener('submit', handleFormSubmit);
        });
    </script>
@endpush
