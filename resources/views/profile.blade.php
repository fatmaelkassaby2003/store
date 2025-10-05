@extends('layouts.layout')

@section('css')
<link rel="stylesheet" href="{{ asset('front/css/profile.css') }}">
@endsection

@section('content')

<div class="bg-light py-3">
    <div class="container">
        <div class="row" style="margin-Top: 90px;">
            <div class="col-md-12 mb-0">
                <a style="color: #3EBA84;" href="{{ route('home') }}">الرئيسية</a> <span class="mx-2 mb-0">/</span>
                <strong class="text-black">البروفايل</strong>
            </div>
        </div>
    </div>
</div>

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-avatar">
            @if(auth()->user()->profile_photo)
            <img src="{{auth()->user()->profile_photo}}" alt="صورة البروفايل">
            @else
            <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            @endif
        </div>
        <h1>{{ auth()->user()->name }}</h1>
        <p class="user-email">{{ auth()->user()->email }}</p>

        <!-- عرض نوع المستخدم -->
        <div class="role-badge 
            @if(auth()->user()->role === 'admin') role-admin
            @elseif(auth()->user()->role === 'employee') role-employee
            @else role-user @endif">
            @if(auth()->user()->role === 'admin') مدير
            @elseif(auth()->user()->role === 'employee') موظف
            @else مستخدم @endif
        </div>

        <!-- عرض الفرع إذا كان موظفًا -->
        @if(auth()->user()->role === 'employee' && auth()->user()->branch)
        <div class="branch-info">
            الفرع: {{ auth()->user()->branch }}
        </div>
        @endif
    </div>

    <div class="profile-content">
        <form class="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">الاسم الكامل</label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
            </div>

            <div class="form-group">
                <label for="profile_photo">صورة البروفايل</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
                <small>الصيغ المسموحة: JPEG, PNG (الحجم الأقصى 2MB)</small>
                @if(auth()->user()->profile_photo)
                <div class="current-photo">
                    <small>الصورة الحالية:</small>
                    <img src="{{ auth()->user()->profile_photo }}" width="50" style="border-radius: 50%;">
                </div>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">حفظ التغييرات</button>
                <a href="{{ route('password.change') }}" class="btn-change-password">تغيير كلمة المرور</a>
            </div>
        </form>

        <div class="profile-stats">
            <div class="stat-card">
                <h3>طلباتي</h3>
                <p>{{ auth()->user()->orders()->count() }}</p>
                <div class="order-item">
                    @foreach($groupedItems as $item)
                    <p>{{ $item['product_name'] }} : {{ $item['total_quantity'] }}</p>
                    @endforeach
                </div>

            </div>
            <div class="stat-card">
                @if(auth()->user()->role !== 'admin')
                <h3>عضو منذ</h3>
                <p>{{ auth()->user()->created_at}}</p>
                @else
                <h3>مدير منذ</h3>
                <p>{{ auth()->user()->created_at}}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection