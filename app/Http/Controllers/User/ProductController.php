<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $data['cart'] = auth()->user()->cart;
        } else {
            $data['cart'] = null;  // or handle accordingly if no cart is found
        }
        $data['products'] = Product::with('category')->latest()->get();
        return view('user.components.products_index', $data);
    }
}
