<?php

namespace App\Http\Controllers\E_commerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\UserInfo;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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
    

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول لإتمام العملية.');
        }

        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'السلة فارغة!');
        }

        $request->validate([
            'c_country'      => 'required|string',
            'c_fname'        => 'required|string|max:255',
            'c_lname'        => 'required|string|max:255',
            'c_email_address' => 'required|email|max:255',
            'c_companyname'  => 'nullable|string|max:255',
            'c_phone'        => 'required|string|max:20',
            'c_address'      => 'required|string|max:255',
            'c_street'       => 'nullable|string|max:255',
            'c_state_country' => 'required|string|max:255',
            'c_postal_zip'   => 'required|string|max:10',
            'c_order_notes'  => 'nullable|string',
            'payment_method'  => 'required|in:cash,visa', // اضفت هنا
        ]);

        DB::beginTransaction();

        try {
            UserInfo::updateOrCreate(
                ['user_id' => $userId],
                [
                    'country'  => $request->c_country,
                    'fname'    => $request->c_fname,
                    'lname'    => $request->c_lname,
                    'email'    => $request->c_email_address,
                    'company'  => $request->c_companyname ?? '',
                    'phone'    => $request->c_phone,
                    'address'  => $request->c_address,
                    'street'   => $request->c_street ?? '',
                    'state'    => $request->c_state_country,
                    'zip_code' => $request->c_postal_zip,
                    'message'  => $request->c_order_notes ?? '',
                ]
            );

            $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $discountAmount = session('discount_amount', 0);
            $totalAfterDiscount = max($subtotal - $discountAmount, 0);
            $order = Order::create([
                'user_id'     => $userId,
                'total_price' => $totalAfterDiscount,
                'payment_method' => $request->payment_method,
                'payment_status'      => 'pending',
            ]);



            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);

                if (!$product) {
                    throw new \Exception("المنتج غير موجود.");
                }

                if ($product->quantity < $item->quantity) {
                    throw new \Exception("الكمية المطلوبة من المنتج {$product->name} غير متاحة.");
                }

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product_name,
                    'quantity'     => $item->quantity,
                ]);

                $product->decrement('quantity', $item->quantity);
            }

            Cart::where('user_id', $userId)->delete();
            session()->forget(['cart_count', 'discount_amount']);


            if ($request->payment_method === 'visa') {
                DB::commit();
                return redirect()->route('paymob.pay', ['order_id' => $order->id]);
            }
            DB::commit();
            
            return redirect()->route('thankyou')->with('success', 'تم تأكيد الطلب بنجاح!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('cart')->with('error', 'حدث خطأ أثناء تأكيد الطلب: ' . $e->getMessage());
        }
    }

    public function thankYou()
    {
        return view('thankyou');
    }
}