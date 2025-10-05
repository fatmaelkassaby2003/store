<!DOCTYPE html>
<html lang="en">

<head>
  <title>الزهراء ماركت</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('front/fonts/icomoon/style.css') }}">

  <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('front/css/magnific-popup.css')}}">
  <link rel="stylesheet" href="{{ asset('front/css/jquery-ui.css')}} ">
  <link rel="stylesheet" href="{{ asset('front/css/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{ asset('front/css/owl.theme.default.min.css ') }}">
  <link rel="stylesheet" href="{{ asset('front/css/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">


  @yield('css')


</head>

<body dir="rtl">
  <div class="site-wrap">
    <div class="site-navbar py-2">
      <div class="search-wrap">
        <div class="container">
          <a href="#" class="search-close js-search-close">
            <span class="icon-close2"></span>
          </a>

          <!-- مربع البحث -->
          <input type="text" id="search-box" class="form-control" placeholder="ابحث عن منتج...">

          <!-- القائمة المنسدلة -->
          <div id="search-results" class="search-dropdown"></div>
        </div>
      </div>

      <!-- مكان سيظهر فيه المنتج المختار -->
      <div id="product-details"></div>
      <div class="container">
        <div class="d-flex align-items-center justify-content-between">
          <div class="logo d-flex align-items-center"> <!-- أضفنا d-flex هنا -->
            <div class="site-logo d-flex align-items-center"> <!-- وأضفناها هنا أيضا -->
              @auth
              <a href="{{ route('profile') }}" class="profile-icon ms-30">
                <div class="avatar">
                  @if(auth()->user()->profile_photo)
                  <img src="{{ auth()->user()->profile_photo }}"
                    alt="صورة البروفايل"
                    class="avatar-image">
                  @else
                  <span class="avatar-initial">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                  @endif
                </div>
              </a>
              @endauth
              <a href="#" class="js-logo-clone" id="dropdownToggle">الزهراء ماركت</a>
              <ul class="dropdown-menu" id="dropdownMenu">
                @guest
                <li><a href="{{ route('register') }}">تسجيل</a></li>
                <li><a href="{{ route('login') }}">تسجيل الدخول</a></li>
                @endguest
                @auth
                <li><a href="{{ route('logout') }}">الخروج</a></li>
                @endauth
                @auth
                @if(auth()->user()->role === 'admin')
                <li><a href="{{ route('dashboard.users') }}">المعلومات</a></li>
                @endif
                @endauth
                @if(Auth::check() && Auth::user()->role === 'employee')
                <li><a href="{{ route('cashier') }}">الكاشير</a></li>
                @endif
              </ul>
            </div>
          </div>
          <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
              <ul class="site-menu js-clone-nav d-none d-lg-block">
                <li><a href="{{ route('home') }}">الرئيسية</a></li>
                <li><a href="{{ route('shop') }}">المتجر</a></li>
                <li class="has-children">
                  <a href="#">القائمة</a>
                  <ul class="dropdown">
                    <li><a href="{{ route('home') }}" class="category-link" data-category="المنظفات">المنظفات</a></li>
                    <li><a href="{{ route('home') }}" class="category-link" data-category="الألبان">الألبان</a></li>
                    <li><a href="{{ route('home') }}" class="category-link" data-category="اللحوم">اللحوم</a></li>
                    <li><a href="{{ route('home') }}" class="category-link" data-category="الخضروات">الخضروات</a></li>
                    <li><a href="{{ route('home') }}" class="category-link" data-category="الفواكه">الفواكه</a></li>
                    <li><a href="{{ route('home') }}" class="category-link" data-category="البقالة">البقالة</a></li>
                  </ul>
                </li>
                <li><a href="{{ route('about') }}">من نحن</a></li>
                <li><a href="{{ route('contact') }}">اتصل بنا</a></li>
              </ul>
            </nav>
          </div>
          <div class="icons">
            <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>
            <a href="{{ route('cart') }}" class="icons-btn d-inline-block bag">
              <span class="icon-shopping-bag"></span>
              <span class="number">{{ session('cart_count', 0) }}</span>
            </a>

            <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
                class="icon-menu"></span></a>
          </div>
        </div>
      </div>
    </div>

    <div class="site-mobile-menu-overlay">
      <ul>
        <li><a href="{{ route('home') }}">الرئيسية</a></li>
        <li><a href="{{ route('shop') }}">المتجر</a></li>
        <li class="has-children">
          <a href="#">القائمة</a>
          <ul class="dropdown">
            <li><a href="{{ route('home') }}"> المنظفات </a></li>
            <li><a href="{{ route('home') }}">الالبان</a></li>
            <li><a href="{{ route('home') }}"> اللحوم</a></li>
            <li><a href="{{ route('home') }}"> الخضروات</a></li>
            <li><a href="{{ route('home') }}"> البقالة</a></li>
          </ul>
        </li>
        <li><a href="{{ route('about') }}">من نحن</a></li>
        <li><a href="{{ route('contact') }}">اتصل بنا</a></li>
      </ul>
    </div>
    @yield('content')

    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">

            <div class="block-7">
              <h3 class="footer-heading mb-4">من نحن</h3>
              <p>لوريم ايبسوم دولار سيت أميت , كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمسيا يليفيكيوا.</p>
            </div>

          </div>
          <div class="col-lg-3 mx-auto mb-5 mb-lg-0">
            <h3 class="footer-heading mb-4">روابط مهمة</h3>
            <ul class="list-unstyled">
              <li><a href="#">فيسبوك</a></li>
              <li><a href="#">تويتر</a></li>
              <li><a href="#">تليجرام &amp; واتساب</a></li>
              <li><a href="#">انستقرام &amp; يوتيوب</a></li>
            </ul>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="block-5 mb-5">
              <h3 class="footer-heading mb-4">تواصل معنا</h3>
              <ul class="list-unstyled">
                <li class="address">شارع الملك عبدالعزيز، القاهرة</li>
                <li class="phone"><a href="tel://23923929210">+2 392 3929 210</a></li>
                <li class="email">emailaddress@domain.com</li>
              </ul>
            </div>


          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p>
              Copyright &copy;
              <script>
                document.write(new Date().getFullYear());
              </script> كل الحقوق محفوظة
              with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank"
                class="text-primary">Colorlib</a>
            </p>
          </div>

        </div>
      </div>
    </footer>
  </div>

  <script src="{{ asset('front/js/jquery-3.3.1.min.js') }}"></script>

  <script src="{{ asset('front/js/jquery-ui.js') }}"></script>
  <script src="{{ asset('front/js/popper.min.js')}}"></script>
  <script src="{{ asset('front/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('front/js/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('front/js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{ asset('front/js/aos.js ')}}"></script>

  <script src="{{ asset('front/js/main.js')}}"></script>
  <script src="{{ asset('front/js/layout.js')}}"></script>
  @yield('scripts')

</body>

</html>