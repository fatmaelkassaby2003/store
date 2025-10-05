@extends('layouts.layout')

@section('content')

<div class="bg-light py-3">
  <div class="container">
    <div class="row" style="margin-Top: 90px;">
      <div class="col-md-12 mb-0">
        <a style="color: #3EBA84;" href="{{ route('home') }}">الرئيسية</a> <span class="mx-2 mb-0">/</span>
        <strong class="text-black">السلة</strong>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row mb-5">
      <form class="col-md-12" method="post">
        <div class="site-blocks-table">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="product-thumbnail">الصورة</th>
                <th class="product-name">المنتج</th>
                <th class="product-price">السعر</th>
                <th class="product-quantity">الكمية</th>
                <th class="product-total">المجموع</th>
                <th class="product-remove">حذف</th>
              </tr>
            </thead>
            <tbody>
              @php $total = 0; @endphp



              @foreach($cartItems as $item)
              @php
              $price = is_object($item) ? $item->price : ($item['price'] ?? 0);
              $quantity = is_object($item) ? $item->quantity : ($item['quantity'] ?? 1);
              $productName = is_object($item) ? $item->product_name : ($item['product_name'] ?? 'منتج غير معروف');
              $productImage = is_object($item) ? $item->product_image : ($item['product_image'] ?? 'default.jpg');
              $itemId = is_object($item) ? $item->id : ($item['id'] ?? 0);

              $subtotal = $price * $quantity;
              $total += $subtotal;
              @endphp
              <tr>
                <td><img src="{{ $productImage }}" width="80" class="img-fluid"></td>
                <td class="product-name">
                  <h2 class="h5 text-black">{{ $productName }}</h2>
                </td>
                <td>${{ number_format($price, 2) }}</td>
                <td>
                  <div class="input-group mb-3" style="max-width: 120px;">
                    <div class="input-group-prepend">
                      <a href="{{ route('cart.update', ['id' => $itemId, 'change' => -1]) }}" class="btn btn-outline-success">&minus;</a>
                    </div>
                    <input type="text" class="form-control text-center" value="{{ $quantity }}" readonly>
                    <div class="input-group-append">
                      <a href="{{ route('cart.update', ['id' => $itemId, 'change' => 1]) }}" class="btn btn-outline-success">&plus;</a>
                    </div>
                  </div>
                </td>
                <td>${{ number_format($subtotal, 2) }}</td>
                <td><a href="{{ route('cart.remove', $itemId) }}" class="btn btn-danger btn-sm">X</a></td>
              </tr>
              @endforeach

              <tr>
                <td colspan="4"><strong>الإجمالي</strong></td>
                <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
              </tr>

            </tbody>
          </table>
        </div>
      </form>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <label class="text-black h4" for="coupon">كود الخصم</label>
            <p>من فضلك ادخل كود الخصم</p>
          </div>
          <form action="{{ route('apply.discount') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-8 mb-3 mb-md-0">
                <input type="text" name="coupon" class="form-control-1 py-3" id="coupon" placeholder="كود الخصم">
              </div>
              <div class="col-md-4">
                <button type="submit" style="background-color: #3EBA84; border-color: #3EBA84" class="btn btn-success btn-md px-4">تطبيق الخصم</button>
              </div>
            </div>
          </form>

          @if(session()->has('error'))
          <div class="alert alert-danger mt-2">
            {{ session('error') }}
          </div>
          @endif




        </div>
      </div>
      <div class="col-md-6 pl-5">
        <div class="row justify-content-end">
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-12 text-right border-bottom mb-5">
                <h3 class="text-black h4 text-uppercase"> مجموع المنتجات</h3>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <span class="text-black">مجموع المنتجات</span>
              </div>
              <div class="col-md-6 text-right">
                <strong class="text-black">${{ number_format($total, 2) }}</strong>
              </div>
            </div>

            @if(isset($discountAmount) && $discountAmount > 0)
            <div class="row mb-3">
              <div class="col-md-6">
                <span class="text-black">قيمة الخصم</span>
              </div>
              <div class="col-md-6 text-right">
                <strong class="text-black">-${{ number_format($discountAmount, 2) }}</strong>
              </div>
            </div>
            @endif

            <div class="row mb-5">
              <div class="col-md-6">
                <span class="text-black">الإجمالي بعد الضريبة (20%)</span>
              </div>
              <div class="col-md-6 text-right">
                <strong class="text-black">${{ number_format($totalWithTax, 2) }}</strong>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                @if(auth()->check())
                <a href="{{ route('checkout') }}" style="background-color: #3EBA84; border-color: #3EBA84" class="btn btn-success btn-lg btn-block">تأكيد الطلب</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-secondary">سجّل الدخول لإتمام الطلب</a>
                @endif

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('layouts.info')
@endsection