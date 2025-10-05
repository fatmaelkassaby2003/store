<?php

namespace App\Http\Controllers\E_commerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $discountAmount = session('discount_amount', 0);
        $totalAfterDiscount = $subtotal - $discountAmount;
        $totalWithTax = $totalAfterDiscount * 1.2; 

        return view('checkout', compact('cartItems', 'subtotal', 'discountAmount', 'totalAfterDiscount', 'totalWithTax'));
    }

    
}
