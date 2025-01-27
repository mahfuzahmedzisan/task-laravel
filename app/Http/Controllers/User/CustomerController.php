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
        // Validate the request
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = auth()->user()->cart()->firstOrCreate([]);

        // If the product is already in the cart, update its quantity
        if ($cart->products()->where('product_id', $product->id)->exists()) {
            $cart->products()->updateExistingPivot($product->id, [
                'quantity' => $request->quantity
            ]);
        } else {
            // If the product is not in the cart, attach it with the specified quantity
            $cart->products()->attach($product->id, ['quantity' => $request->quantity]);
        }

        // Return a JSON response for AJAX
        return response()->json(['success' => true]);
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

    public function orderShow()
    {
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

    public function updateCartQuantity(Request $request)
    {
        // Validate the request
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
        ]);

        // Get the user's cart
        $cart = auth()->user()->cart;

        // Find the product in the cart
        $product = $cart->products()->where('product_id', $request->product_id)->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found in the cart.']);
        }

        // Update the quantity in the pivot table
        $cart->products()->updateExistingPivot($request->product_id, ['quantity' => $request->quantity]);

        // Recalculate the total price for the updated product
        $updatedProduct = Product::find($request->product_id);

        return response()->json([
            'success' => true,
            'product_price' => $updatedProduct->price * $request->quantity, // Send the updated price
        ]);
    }
}
