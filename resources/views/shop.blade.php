@extends('layouts.layout')
@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row" style="margin-Top: 90px;">
      <div class="col-md-12 mb-0"><a style="color: #3EBA84; margin-Top: 500px;" href="{{ route('home') }}">الرئيسية</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">المتجر</strong></div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row">
      @foreach($products as $product)
      <div class="col-sm-6 col-lg-4 text-center item mb-4">
        @if($product->old_price)
        <span class="tag">خصم</span>
        @endif
        <a href="{{ route('shop-single', ['id' => $product->id]) }}">
          <img src="{{ $product->image ? $product->image : asset('front/images/default.jpg') }}" alt="Image">
        </a>
        <h3 class="text-dark">
          <a href="{{ route('shop-single', ['id' => $product->id]) }}">{{ $product->name }}</a>
        </h3>
        <p class="price">
          @if($product->old_price)
          <del>${{ $product->old_price }}</del> &mdash;
          @endif
          ${{ $product->price }}
        </p>
      </div>
      @endforeach
    </div>

    <div class="row mt-5">
      <div class="col-md-12 text-center">
        <div class="site-block-27">
          {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>

  </div>
</div>

@include('layouts.info')
@endsection