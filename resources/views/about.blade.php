@extends('layouts.layout')
@section('content')

@php
    $bgImage = asset('front/images/image 10.png');
@endphp

<div class="site-blocks-cover" style="background-image: url('{{ $bgImage }}');">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 mx-auto align-self-center">
        <div class="text-center">
          <h1>من نحن</h1>
          <p class="lead">نحن شركة رائدة في تقديم المنتجات الصحية والمكملات الغذائية ذات الجودة العالية.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="site-section bg-light custom-border-bottom" data-aos="fade">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-6">
        <div class="block-16">
          <figure>
            <img src="{{ asset('front') }}/images/image.png" alt="صورة" class="img-fluid rounded">
            <a href="https://vimeo.com/channels/staffpicks/93951774" class="play-button popup-vimeo"><span
                class="icon-play"></span></a>
          </figure>
        </div>
      </div>
      <div class="col-md-5">
        <div class="site-section-heading pt-3 mb-4">
          <h2 class="text-black">كيف بدأنا</h2>
        </div>
        <p>بدأنا رحلتنا في عالم المنتجات الصحية بهدف تقديم أفضل المكملات الغذائية والفيتامينات لعملائنا.</p>
      </div>
    </div>
  </div>
</div>

@endsection