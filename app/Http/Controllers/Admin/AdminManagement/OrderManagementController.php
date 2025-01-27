<?php

namespace App\Http\Controllers\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderManagementController extends Controller
{
    /**
     * Display the list of orders
     */
    public function index()
    {
        $orders = Order::latest()->with('products')->get();  // Eager load products relationship
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the details of a specific order
     */
    public function show($id)
    {
        $order = Order::with('products')->findOrFail($id);  // Eager load products
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of an order (approve, decline)
     */
    public function updateStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->status = $status;  // 'approved', 'declined', etc.
        $order->save();
        return redirect()->route('om.orders.index')->with('status', 'Order status updated!');
    }
}
