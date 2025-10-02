<?php

namespace App\Http\Controllers\E_commerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
{
    $cartItems = [];
    $cartCount = 0;
    $total = 0;
    $discountAmount = session('discount_amount', 0);

    if (Auth::check()) {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();
        $cartCount = Cart::where('user_id', $userId)->sum('quantity');
        $total = Cart::where('user_id', $userId)->sum(DB::raw('price * quantity'));
    } else {
        $cartItems = session('cart', []);
        $cartCount = array_sum(array_column($cartItems, 'quantity'));
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
    }

    $totalAfterDiscount = $total - $discountAmount;
    $totalWithTax = $totalAfterDiscount * 1.2;

    return view('cart', compact('cartItems', 'cartCount', 'total', 'discountAmount', 'totalAfterDiscount', 'totalWithTax'));
}


public function addToCart($id)
{
    $product = Product::findOrFail($id);
    
    // استخدام session() للسلة إذا لم يكن المستخدم مسجلاً
    if (!Auth::check()) {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'product_id'    => $product->id,
                'product_name'  => $product->name,
                'price'         => $product->price,
                'quantity'      => 1,
                'product_image' => $product->image
            ];
        }

        session()->put('cart', $cart);
        session()->put('cart_count', array_sum(array_column($cart, 'quantity')));

        return redirect()->route('cart')->with('success', 'تمت إضافة المنتج إلى السلة!');
    }

    // للمستخدمين المسجلين
    $userId = Auth::id();
    $cartItem = Cart::where('product_id', $id)->where('user_id', $userId)->first();

    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        Cart::create([
            'user_id'       => $userId,
            'product_id'    => $product->id,
            'product_name'  => $product->name,
            'price'         => $product->price,
            'quantity'      => 1,
            'product_image' => $product->image
        ]);
    }

    $this->updateCartCount($userId);

    return redirect()->route('cart')->with('success', 'تمت إضافة المنتج إلى السلة بنجاح!');
}



public function removeFromCart($id)
{
    if (Auth::check()) {
        // للمستخدم المسجل: حذف المنتج من قاعدة البيانات
        $userId = Auth::id();
        Cart::where('id', $id)->where('user_id', $userId)->delete();
        $this->updateCartCount($userId);
    } else {
        // للمستخدم غير المسجل: حذف المنتج من `session`
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);
        session()->put('cart_count', array_sum(array_column($cart, 'quantity')));
    }

    return redirect()->route('cart')->with('success', 'تم حذف المنتج من السلة.');
}


public function updateQuantity($id, $change)
{
    if (Auth::check()) {
        // للمستخدم المسجل: تحديث الكمية في قاعدة البيانات
        $userId = Auth::id();
        $cartItem = Cart::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $cartItem->quantity = max(1, $cartItem->quantity + $change);
        $cartItem->save();
        $this->updateCartCount($userId);
    } else {
        // للمستخدم غير المسجل: تحديث الكمية في `session`
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, $cart[$id]['quantity'] + $change);
        }

        session()->put('cart', $cart);
        session()->put('cart_count', array_sum(array_column($cart, 'quantity')));
    }

    return redirect()->route('cart')->with('success', 'تم تحديث الكمية بنجاح.');
}


public function applyDiscount(Request $request)
{
    $discountAmount = 0;
    $discountCode = $request->input('coupon');
    $total = 0;

    if (Auth::check()) {
        $userId = Auth::id();
        $total = Cart::where('user_id', $userId)->sum(DB::raw('price * quantity'));
    } else {
        $cart = session('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
    }

    if ($discountCode) {
        $discount = Discount::where('code', $discountCode)->first();
        if ($discount) {
            $discountAmount = ($total * $discount->percentage) / 100;
            session()->put('discount_amount', $discountAmount);
        } else {
            return redirect()->route('cart')->with('error', 'كود الخصم غير صالح.');
        }
    }

    return redirect()->route('cart')->with('success', 'تم تطبيق الخصم بنجاح!');
}

private function updateCartCount($userId = null)
{
    if ($userId) {
        $cartCount = Cart::where('user_id', $userId)->sum('quantity');
    } else {
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));
    }

    session()->put('cart_count', $cartCount);
}


}
