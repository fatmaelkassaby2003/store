<?php

namespace App\Http\Controllers\E_commerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'c_fname' => 'required|string|max:255',
            'c_lname' => 'required|string|max:255',
            'c_email' => 'required|email|max:255',
            'c_subject' => 'nullable|string|max:255',
            'c_message' => 'required|string',
        ]);

        Contact::create([
            'fname' => $request->c_fname,
            'lname' => $request->c_lname,
            'email' => $request->c_email,
            'subject' => $request->c_subject ?? '',
            'message' => $request->c_message,
            'user_id' => Auth::id(), // حفظ معرّف المستخدم المسجل
        ]);

        return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح!');
    }
}
