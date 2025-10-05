<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{
    public function getcompanies()
    {
        $companiess = Company::paginate(9);
        return view('dashboard.companies', compact('companiess'));
    }

    public function companies(Request $request)
    {
        $search = $request->input('search');

        $companies = Company::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->get();
        //scout

        $companiess = Company::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->paginate(9);

        return view('dashboard.companies', compact('companies', 'companiess'));
    }
    
    public function addcompany(Request $request)
    {

        
        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|',
        ]);
        $part1 = rand(10, 99);
        $part2 = rand(10, 99);
        $part3 = rand(100, 999);
        $code = "$part1-$part2-$part3";
        $company = Company::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'type' => 'حلو',
            'code' => $code

        ]);
        return redirect(route('dashboard.products'))->with('success', 'تم اضافة المنتج بنجاح');
    }
}
