@extends('layouts.layout')
@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row" style=" margin-Top: 90px;">
      <div class="col-md-12 mb-0">
        <a style="color: #3EBA84;" href="{{ route('home') }}">الرئيسية</a> <span class="mx-2 mb-0">/</span>
        <strong class="text-black">اتصل بنا</strong>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="h3 mb-5 text-black">اتصل بنا</h2>
      </div>
      <div class="col-md-12">

      <form action="https://formsubmit.co/fatmamaged3152003ff@gmail.com" method="post">
          @csrf
          <div class="p-3 p-lg-5 border">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="form-group row">
              <div class="col-md-6">
                <label for="c_fname" class="text-black">الاسم الأول <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="c_fname" name="c_fname" required>
              </div>
              <div class="col-md-6">
                <label for="c_lname" class="text-black">الاسم الأخير <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="c_lname" name="c_lname" required>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label for="c_email" class="text-black">البريد الإلكتروني <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="c_email" name="c_email" required>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label for="c_subject" class="text-black">الموضوع</label>
                <input type="text" class="form-control" id="c_subject" name="c_subject">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label for="c_message" class="text-black">الرسالة <span class="text-danger">*</span></label>
                <textarea name="c_message" id="c_message" cols="30" rows="7" class="form-control" required></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-lg-12">
                <input style="background-color: #3EBA84; border-color: #3EBA84; margin-top: 20px;" type="submit" class="btn btn-success btn-lg btn-block" value="إرسال الرسالة">
              </div>
            </div>
          </div>
        </form>

      </div>

    </div>
  </div>
</div>

<div style="background-color: #3EBA84;" class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="text-white mb-4">خدماتنا</h2>
      </div>
      <div class="col-lg-4">
        <div class="p-4 bg-white mb-3 rounded">
          <span class="d-block text-black h6 text-uppercase">مصر</span>
          <p class="mb-0"> شارع الملك عبدالعزيز، القاهرة ✨</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="p-4 bg-white mb-3 rounded">
          <span class="d-block text-black h6 text-uppercase">الامارات</span>
          <p class="mb-0">أبوظبي: شارع الشيخ زايد. 🚀</p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="p-4 bg-white mb-3 rounded">
          <span class="d-block text-black h6 text-uppercase">السعودية</span>
          <p class="mb-0">السعودية، الرياض: شارع التحلية . 🚗</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection