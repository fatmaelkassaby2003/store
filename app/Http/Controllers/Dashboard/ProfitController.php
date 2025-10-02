<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;

class ProfitController extends BaseController
{
        public function gerProfits()
    {
        $total_egypt = DB::table('bills')
            ->join('users', 'users.id', '=', 'bills.user_id')
            ->where('users.branch', 'مصر')
            ->sum('bills.total_price');
        $total_emirates = DB::table('bills')
            ->join('users', 'users.id', '=', 'bills.user_id')
            ->where('users.branch', 'الإمارات')
            ->sum('bills.total_price'); 
        $total_saudi = DB::table('bills')
            ->join('users', 'users.id', '=', 'bills.user_id')
            ->where('users.branch', 'السعودية')
            ->sum('bills.total_price');
        $total_ecommerce = DB::table('orders')->sum('total_price');
        return view('dashboard.profits', compact(
            'total_egypt', 'total_emirates', 'total_saudi', 'total_ecommerce'
        ));
    }
}
