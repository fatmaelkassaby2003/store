@extends('layouts.layout')

@section('content')

@php
$bgImage = asset('front/images/image 10.png');
@endphp

<div class="site-blocks-cover" style="background-image: url('{{ $bgImage }}');">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 mx-auto order-lg-2 align-self-center">
        <div class="site-block-cover-content text-center">
          <h2 class="sub-title">مرحبًا بك في الزهراء ماركت <br>
            كل ما تحتاجه في مكان واحد!</h2>
          <p>
            <a href="{{route('shop')}}"
              class="btn btn-primary px-5 py-3"
              style="background-color: #3EBA84; border-color: #3EBA84; color: #fff;"
              onmouseover="this.style.backgroundColor='#fff'; this.style.borderColor='#fff'; this.style.color='#3EBA84';"
              onmouseout="this.style.backgroundColor='#3EBA84'; this.style.borderColor='#3EBA84'; this.style.color='#fff';">
              تسوق الآن
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row align-items-stretch section-overlap">
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
        <div class="banner-wrap h-100">
          <a href="#" class="h-100">
            <h5>مجانى <br> التوصيل</h5>
            <p>
              منتجات متنوعة
              <strong> منتجات افضل توصيل اسرع</strong>
            </p>
          </a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
        <div class="banner-wrap h-100">
          <a href="#" class="h-100">
            <h5> العروض <br> تصل ل 50%</h5>
            <p>
              اهم العروض
              <strong> منتجات افضل توصيل اسرع</strong>
            </p>
          </a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
        <div class="banner-wrap h-100">
          <a href="#" class="h-100">
            <h5>اشتري <br> بكل سهولة</h5>
            <p>
              توصيل سريع
              <strong> منتجات افضل توصيل اسرع</strong>
            </p>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div id="category-section" style="display: none;">
      <div class="row">
        <div class="title-section text-center col-12">
          <h2 class="text-uppercase" style="margin: 10px 0;">منتجات الفئة: <span id="selected-category"></span></h2>
        </div>
      </div>
      <div class="row" id="category-products" style="margin-bottom: 20px;">
      </div>
    </div>

    <!-- قسم أشهر المنتجات -->
    <div class="row">
      <div class="title-section text-center col-12">
        <h2 class="text-uppercase" style="margin: 10px 0;">اشهر المنتجات</h2>
      </div>
    </div>

    <div class="row">
      @foreach($products->slice(0, 6) as $product)
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

    <div class="row mt-4">
      <div class="col-12 text-center">
        <a href="{{route('shop')}}" class="btn btn-success px-4 py-3">عرض المزيد</a>
      </div>
    </div>
  </div>
</div>

<!-- باقي الأقسام -->
<div class="site-section bg-light">
  <div class="container">
    <div class="row">
      <div class="title-section text-center col-12">
        <h2 class="text-uppercase">منتجات جديدة</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 block-3 products-wrap">
        <div class="nonloop-block-3 owl-carousel">
          @foreach($lastProducts as $product)
          <div class="text-center item-1 mb-4">
            <a href="{{ route('shop-single', ['id' => $product->id]) }}">
              <img src="{{ $product->image ? $product->image : asset('front/images/default.jpg') }}" alt="Image">
            </a>
            <h3 class="text-dark" style="color: #000;">
              <a style="color: #3EBA84;" href="{{ route('shop-single', ['id' => $product->id]) }}">{{ $product->name }}</a>
            </h3>
            <p style="color: #000;" class="price">${{ $product->price }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="title-section text-center col-12">
        <h2 class="text-uppercase">الموظفين المميزين</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 block-3 products-wrap">
        <div class="nonloop-block-3 no-direction owl-carousel">
          @foreach($users as $user)
          @if($user->role == 'employee')
          <div class="testimony">
            <blockquote>
              @if($user->profile_photo)
              <img src="{{$user->profile_photo}}" alt="{{ $user->name }}" class="img-fluid w-25 mb-4 rounded-circle">
              @else
              <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center text-white">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
              @endif

              <p>&ldquo; أحد الموظفين المتميزين في خدمة العملاء &rdquo;</p>
            </blockquote>
            <p>&mdash; {{ $user->name }}</p>
            @if($user->bill_count)
            <small>عدد الفواتير: {{ $user->bill_count }}</small>
            @endif
          </div>
          @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script src="{{ asset('front/js/index.js')}}"></script>
@endsection

@include('layouts.info')
@endsection