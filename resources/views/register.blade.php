@extends('layouts.auth')
@section('content')
<div class="wrapper">
  <h2>التسجيل</h2>
  <form method="POST" action="{{ route('register-form') }}">
    @csrf
    @method("POST")
    <div class="input-box">
      <input name="name" type="text" placeholder="ادخل الاسم">
    </div>
    @error('name')
    <span class="text-danger" style="color: red; margin-top: 10px">{{ $message }}</span>
    @enderror
    <div class="input-box">
      <input name="email" type="email" placeholder="ادخل البريد الالكتروني">
    </div>
    @error('email')
    <span class="text-danger" style="color: red;">{{ $message }}</span>
    @enderror
    <div class="input-box">
      <input name="password" type="password" placeholder="ادخل كلمة المرور">
    </div>
    @error('password')
    <span class="text-danger" style="color: red;">{{ $message }}</span>
    @enderror
    <div class="input-box">
      <input name="password_confirmation" type="password" placeholder="تأكيد كلمة المرور">
    </div>
    @error('password_confirmation')
    <span class="text-danger" style="color: red;">{{ $message }}</span>
    <br>
    @enderror
    <div class="policy">
      <input type="checkbox" name="accepted" id="accepted" value="1">
      <label for="accepted">انا اوافق على <strong>الشروط والاحكام</strong></label>
    </div>
    @error('accepted')
    <span class="text-danger" style="color: red;">{{ $message }}</span>
    @enderror
    <div class="input-box button">
      <input type="submit" value="تسجيل الدخول">
    </div>
    <div class="text">
      <h3>لديك حساب ؟ <a href="{{ route('login') }}">تسجيل دخول الان</a></h3>
    </div>
  </form>
</div>
<div class="image-box">
  <img src="{{ asset('front/images/1.avif') }}" alt="التسجيل">
</div>
@endsection
