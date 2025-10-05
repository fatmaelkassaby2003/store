@extends('layouts.auth')
@section('content')

<div class="wrapper">
      <h2>تسجيل الدخول</h2>
      <form action="{{ route('login-form') }}" method="POST">
        @csrf
        @method('POST')
        <div class="input-box">
          <input name="email" type="text" placeholder="ادخل البريد الالكتروني" required>
        </div>
        @error('email')
        <span class="text-danger" style="color: red;">{{ $message }}</span>
        @enderror
        <div class="input-box">
          <input name="password" type="password" placeholder="ادخل كلمة المرور" required>
        </div>
        @error('password')
        <span class="text-danger" style="color: red;">{{ $message }}</span>
        @enderror
        <div class="input-box button">
          <input type="Submit" value="تسجيل الدخول">
        </div>
        <div class="text">
          <h3>ليس لديك حساب ؟ <a href="{{ route('register') }}"> التسجيل الان</a></h3>
        </div>
      </form>
    </div>
    <div class="image-box">
      <img src="{{asset('front/')}}/images/login.jpg" alt="التسجيل">
    </div>
@endsection