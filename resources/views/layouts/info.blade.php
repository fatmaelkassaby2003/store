@php
    $backgroundImage = asset('front/images/image.png');
    $Image1 = asset('front/images/log.jpg');
    $Image2 = asset('front/images/fatma.png');
@endphp

<div class="site-section bg-secondary bg-image" style="background-image: url('{{ $backgroundImage }}');">

  <div class="container">
    <div class="row align-items-stretch">
      <div class="col-lg-6 mb-5 mb-lg-0">
        <a href="#" class="banner-1 h-100 d-flex" style="background-image: url('{{ $Image1 }}');">
          <div class="banner-1-inner align-self-center">
            <h2>الزهراء ماركت</h2>
            <p>
              تسوق اسهل <br> خدمه افضل
            </p>
          </div>
        </a>
      </div>
      <div class="col-lg-6 mb-5 mb-lg-0">
        <a href="#" class="banner-1 h-100 d-flex" style="background-image: url('{{ $Image2 }}');">
          <div class="banner-1-inner ml-auto  align-self-center">
            <h2> تم بواسطة</h2>
            <br>
            <p> فاطمة ماجد القصبي
            </p>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>