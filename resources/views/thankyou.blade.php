@extends('layouts.layout')

@section('content')

    <div class="bg-light py-3">
      <div class="container">
        <div class="row" style="margin-Top: 90px;">
          <div class="col-md-12 mb-0"><a style="color: #3EBA84;" href="{{ route('home') }}">الرئيسية</a> <span class="mx-2 mb-0">/</span> <strong
              class="text-black">شكرا لك</strong></div>
        </div>
      </div>
    </div>
    
    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <span style="color: #3EBA84;" class="icon-check_circle display-3"></span>
            <h2 class="display-3 text-black">شكرا لك</h2>
            <p class="lead mb-5">لقد قمت بالشراء بنجاح</p>
            <p><a href="{{route('shop')}}" class="btn btn-md height-auto px-4 py-3 btn-success">عودة للمتجر</a></p>
          </div>
        </div>
      </div>
    </div>


    @endsection