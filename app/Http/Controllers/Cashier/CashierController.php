<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Bill;
use App\Models\User;

class CashierController extends Controller
{

    
    public function index()
    {
        return view('cashier');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'total_price' => 'required|numeric|min:1',
        ]);

        $bill = new Bill();
        $bill->user_id = $user->id;
        $bill->total_price = $request->total_price;
        $bill->save();
        if ($user && Schema::hasColumn('users', 'bill_count')) {
            User::where('id', $user->id)->increment('bill_count');
        }

        return redirect()->route('cashier')->with('success', 'تم إنشاء الفاتورة بنجاح');
    }
}
