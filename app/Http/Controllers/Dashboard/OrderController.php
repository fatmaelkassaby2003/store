<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;


class OrderController extends BaseController
{
    public function getorders()
    {
        // هنا هنجيب الطلبات مع المنتجات التابعة لها
        $orders = Order::with(['items.product'])->paginate(9);

        return view('dashboard.orders', compact('orders'));
    }

    public function show($id)//model binding
    {
        $order = Order::with(['items.product', 'user', 'userInfo'])->findOrFail($id);

        return view('dashboard.orderforuser', compact('order'));
    }


    public function ordershow($id)
    {
        $order = OrderItem::where('order_id', $id)->get();
        return view('dashboard.ordershow', compact('order'));
    }


    public function approve($id)
{
    $order = \App\Models\Order::with('userInfo', 'items.product')->findOrFail($id);

    if (! $order->userInfo || ! $order->userInfo->email) {
        return redirect()->route('orders.show', $id)
                         ->with('error', 'لا يوجد بريد إلكتروني مسجل لهذا الطلب.');
    }

    Mail::to($order->userInfo->email)->send(new \App\Mail\OrderApproved($order));

    return redirect()->route('orders.show', $id)
                     ->with('success', ' إلى البريد الإلكتروني بنجاح ✅');
}

}
