<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('auth.password');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'كلمة المرور الحالية غير صحيحة');
        }

        $user->password = Hash::make($request->new_password);
        $user=User::where('id', auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);
        return redirect()->route('profile')
            ->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}