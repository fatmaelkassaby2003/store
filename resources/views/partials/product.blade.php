@extends('layouts.layout')
@section('content')

<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0"><a style="color: #3EBA84;" href="{{ route('home') }}">الرئيسية</a> <span class="mx-2 mb-0">/</span> <a
          href="{{ route('shop') }}">المتجر</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">{{ $product->name }}</strong></div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-md-5 mr-auto">
        <div class="border text-center">
          <img src="{{ asset($product->image) }}" alt="Image" class="img-fluid p-5">
        </div>
      </div>
      <div class="col-md-6">
        <h2 class="text-black">{{ $product->name }} {{ $product->size }}</h2>
        <p>{{ $product->description }}</p>

        <p>
          @if($product->old_price)
          <del>${{ $product->old_price }}</del>
          @endif
          <strong class="text-primary h4">${{ $product->price }}</strong>
        </p>

        <p>
          <a href="{{ route('cart.add', $product->id) }}" class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary">
            إضافة للسلة
          </a>
        </p>

        <div class="mt-5">
          <ul class="nav nav-pills mb-3 custom-pill" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home">معلومات عن المنتج</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile">معلومات عن الشركة</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home">
              <table class="table custom-table">
                <thead>
                  <th style="font-weight: bold; font-size: 20px">النوع</th>
                  <th style="font-weight: bold; font-size: 20px">الوصف</th>
                  <th style="font-weight: bold; font-size: 20px">الكود</th>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">{{ $product->type }}</th>
                    <td>{{ $product->content }}</td>
                    <td>{{ $product->code }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="pills-profile">
              <table class="table custom-table">
                <tbody>
                  <tr>
                    <td>اسم الشركة</td>
                    <td class="bg-light">{{ $product->company->name }}</td>
                  </tr>
                  <tr>
                    <td>البريد الالكتروني</td>
                    <td class="bg-light">{{ $product->company->email }}</td>
                  </tr>
                  <tr>
                    <td>الكود</td>
                    <td class="bg-light">{{ $product->company->code }}</td>
                  </tr>
                  <tr>
                    <td>النوع</td>
                    <td class="bg-light">{{ $product->company->type }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>



@include('layouts.info')
@endsection