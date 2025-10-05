<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends BaseController
{
        public function getUsers()
    {
        $userss = User::where('id', '!=', auth()->id())->paginate(9);
        return view('dashboard.dashboard', compact('userss'));
    }
           public function adduser(Request $request) {

        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'branch' => 'required',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'branch' => $validated['branch'],
            'accepted' => '1',
            'role' => 'employee',
        ]);
        return redirect(route('dashboard.users'))->with('success', 'تم اضافة المستخدم بنجاح');
    }
            public function userShow($id)
    {
        $user = User::findOrFail($id);
        $data = DB::table('bills')
            ->where('user_id', $id)
            ->selectRaw('COUNT(*) as total_invoices, SUM(total_price) as total_price')
            ->first();
        $total_invoices = $data->total_invoices;
        $total_price = $data->total_price;           
        return view('dashboard.usershow', compact('user', 'total_invoices', 'total_price'));
    }

    

    public function getemployees()
    {
        $employees = User::where('role', 'employee')->get();
        $employeess = User::where('role', 'employee')->paginate(9);
        return view('dashboard.employees', compact('employees', 'employeess'));
    }
    public function employees(Request $request)
    {
        $search = $request->input('search');

        $employees = User::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->get();

        $employeess = User::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->paginate(9);   

        return view('dashboard.employees', compact('employees', 'employeess'));
    }
        public function deleteemployee($id) {
        $user = User::where('id', $id)->first();
        $user->delete();
        return redirect(route('dashboard.employees'))->with('success', 'تم حذف المستخدم بنجاح');
    }
}
