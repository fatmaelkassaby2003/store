<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if (!$request->has('accepted')) {
            $request->merge(['accepted' => 0]); 
        }

        $validated = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'accepted' => ['required', 'in:1'], 
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'accepted' => $validated['accepted'],
        ]);

        Auth::login($user);

        $this->updateCartCount($user->id);

        return redirect()->route('home')->with('success', 'تم التسجيل بنجاح!');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
        $this->updateCartCount(Auth::id());

        if (Auth::user()->role === 'employee') {
            return redirect()->route('cashier')->with('success', 'تم تسجيل الدخول بنجاح كموظف!');
        }

        return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح!');
    }

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        auth()->login($user);
        $request->session()->regenerate();
        $this->updateCartCount(Auth::id());

        if ($user->role === 'employee') {
            return redirect()->route('cashier')->with('success', 'تم تسجيل الدخول بنجاح كموظف!');
        }

        return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح!');
    }

    return back()->withErrors([
        'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',
    ]);
}


private function updateCartCount($userId)
{
    $cartCount = Cart::where('user_id', $userId)->sum('quantity');
    session()->put('cart_count', $cartCount);
}


public function logout(Request $request)
{
    Auth::logout();
    $request->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'تم تسجيل الخروج بنجاح!');
}



}
