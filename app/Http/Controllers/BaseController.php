<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function __construct()
    {
        $authId = auth()->id();

        $users = User::where('id', '!=', $authId)->get();
        $orders = Order::all();
        $products = Product::all();
        $companies = Company::all();

        view()->share([
            'users' => $users,
            'orders' => $orders,
            'products' => $products,
            'companies' => $companies,
        ]);
    }
}
