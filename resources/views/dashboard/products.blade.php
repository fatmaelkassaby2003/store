@extends('layouts.dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('dashboard/pro.css') }}">
@endsection
@section('content')

<form class="form-search" method="GET" action="{{ route('products.list') }}">
    <div class="search-div">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="ابحث عن منتج..." value="{{ request('search') }}">
    </div>
    <button type="submit">
        بحث
    </button>
</form>


<div class="title-info">
    <p>
        قائمة المنتجات
    </p>
    <div class="buttons-container">
        <a href="#" class="add-company-btn" onclick="openCompanyForm()">إضافة شركة</a>
        <a href="#" class="add-product-btn" onclick="openForm()">إضافة منتج</a>
    </div>
</div>

<!-- الفورم المنبثق -->
<div id="productForm" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeForm()">&times;</span>
        <h2>إضافة منتج جديد</h2>
        <form method="post" action="{{ route('product.add') }}" enctype="multipart/form-data">
            @csrf
            <label for="productName">اسم المنتج:</label>
            <input type="text" id="productName" name="name" placeholder="أدخل اسم المنتج" required>

            <label for="productImage">صورة المنتج:</label>
            <input type="file" id="productImage" name="image">

            <label for="company">الشركة:</label>
            <select id="company" name="company_id">
                <option value="">بدون شركة</option>
                @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>

            <label for="productCategory">فئة المنتج:</label>
            <select id="productCategory" name="category" required>
                <option value="" disabled selected>اختر الفئة</option>
                <option value="المنظفات">المنظفات</option>
                <option value="الألبان">الألبان</option>
                <option value="اللحوم">اللحوم</option>
                <option value="الخضروات">الخضروات</option>
                <option value="الفواكه">الفواكه</option>
                <option value="البقالة">البقالة</option>

            </select>


            <label for="productSize">حجم المنتج:</label>
            <input type="text" id="productSize" name="size" placeholder="أدخل الحجم بالجرام" required>

            <label for="productDescription">وصف المنتج:</label>
            <textarea id="productDescription" name="description" placeholder="أدخل وصف المنتج"></textarea>

            <label for="productPrice">سعر المنتج:</label>
            <input type="text" id="productPrice" name="price" placeholder="أدخل السعر" required>

            <button type="submit">إضافة المنتج</button>
        </form>
    </div>
</div>

<div id="companyForm" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCompanyForm()">&times;</span>
        <h2>إضافة شركة جديدة</h2>
        <form method="post" action="{{ route('company.add') }}">
            @csrf
            <label for="companyName">اسم الشركة:</label>
            <input type="text" id="companyName" name="name" placeholder="أدخل اسم الشركة" required>

            <label for="companyEmail">البريد الإلكتروني:</label>
            <input type="email" id="companyEmail" name="email" placeholder="أدخل البريد الإلكتروني" required>

            <button type="submit">إضافة الشركة</button>
        </form>
    </div>
</div>


<table>
    <thead>
        <tr>
            <th>اسم المنتج</th>
            <th>السعر</th>
            <th>الوصف</th>
            <th>عرض المنتج</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productss as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }} $</td>
            <td>{{ $product->description }}</td>
            <td>
                <a href="{{ route('products.view', $product->id) }}" class="btn btn-primary" style="text-decoration: none; color: #000;"> عرض → </a>
            </td>
            <td>
                <form action="{{ route('product.delete', $product->id) }}" method="POST" style="display: inline; ">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="border: none; background: none; padding: 0; color:#000;">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<div class="row mt-5">
    <div class="col-md-12 text-center">
        <div class="site-block-27" style="margin: 20px 0;"> <!-- هنا أضفنا margin من الأعلى والأسفل -->
            {{ $productss->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@section('js')<script src="{{ asset('front/js/pro.js') }}"></script>@endsection
@endsection