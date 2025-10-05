<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('dashboard/style.css') }}">
    @yield('css')
    <title>Dashboard</title>
</head>
<body>
<div class="menu">
        <ul>
            <li class="profile">
                <div class="img-box">
                    <img src="{{ asset('front/images/fatma.png') }}" alt="profile">
                </div>
                <h2>Fatma Maged</h2>
            </li>

            <li>
                <a href="{{ route('dashboard.users') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-user-group"></i>
                    <p>المستخدمين</p>
                </a>
            </li>

            <li>
                <a href="{{ route('dashboard.products') }}" class="{{ request()->is('products') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <p>المنتجات</p>
                </a>
            </li>

            <li>
            <a href="{{ route('dashboard.orders') }}" class="{{ request()->is('orders') ? 'active' : '' }}">
            <i class="fas fa-table"></i>
                    <p>المبيعات</p>
                </a>
            </li>

            <li>
            <a href="{{ route('dashboard.companies') }}" class="{{ request()->is('companies') ? 'active' : '' }}">
            <i class="fas fa-building"></i>
            <p> الشركات</p>
                </a>
            </li>

            <li>
            <a href="{{ route('dashboard.employees') }}" class="{{ request()->is('employees') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <p>الموظفين</p>
                </a>
            </li>
            
            <li>
            <a href="{{ route('dashboard.profits') }}" class="{{ request()->is('profits') ? 'active' : '' }}">
            <i class="fas fa-dollar-sign"></i>
            <p>الارباح</p>
                </a>
            </li>

            <li class="log-out">
            <a href="{{ route('logout') }}">
            <i  class="fas fa-sign-out"></i>
                    <p>Log out</p>
                </a>
            </li>

        </ul>
    </div>

    <div class="content">
        <div class="title-info">
        <p>Dashboard <strong>/</strong> <a href="{{ route('home') }}">Home</a></p>
        <i style="color: #fff;" class="fas fa-bars"></i>
        </div>

        <div class="data-info">

            <div class="box">
                <i class="fas fa-user-group"></i>
                <div class="data">
                    <p>المستخدمين</p>
                    <span>{{ count($users) }}</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-box"></i>
                <div class="data">
                    <p>المنتجات</p>
                    <span>{{ count($products) }}</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-chart-line"></i>
                <div class="data">
                    <p>المبيعات</p>
                    <span>{{ count($orders) }}</span>
                </div>
            </div>

            <div class="box">
                <i class="fas fa-building"></i>
                <div class="data">
                    <p>الشركات</p>
                    <span>{{ count($companies) }}</span>
                </div>
            </div>
        </div>
        


        @yield('content')

        
    </div>
    @yield('js')
</body>
</html>