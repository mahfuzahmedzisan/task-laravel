<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Add a product to the cart
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = auth()->user()->cart()->firstOrCreate([]);

        $cart->products()->attach($product->id, ['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Product added to cart.');
    }

    // Remove a product from the cart
    public function removeFromCart(Request $request)
    {
        $cart = auth()->user()->cart;
        $cart->products()->detach($request->product_id);

        return redirect()->back()->with('success', 'Product removed from cart.');
    }

    // View the products in the cart
    public function viewCart()
    {
        $cart = auth()->user()->cart;
        return view('user.components.cart_index', compact('cart'));
    }

    public function order()
    {
        $orders = auth()->user()->orders()->with('products')->latest()->get();
        return view('user.components.order_index', compact('orders'));
    }

    public function orderDetails(Order $order)
    {
        return view('user.components.order_details', compact('order'));
    }

    public function orderShow(){
        return redirect()->route('customer.order.index');
    }
    // Place an order for the products in the cart
    public function placeOrder()
    {
        $cart = auth()->user()->cart;

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        // Add products to the order
        foreach ($cart->products as $product) {
            $order->products()->attach($product->id, ['quantity' => $product->pivot->quantity]);
        }

        // Clear the cart after placing the order
        $cart->products()->detach();

        return redirect()->route('customer.order.index')->with('success', 'Order placed successfully.');
    }
}
