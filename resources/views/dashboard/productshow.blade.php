@extends('layouts.dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('dashboard/show.css') }}">
@endsection
@section('content')
<div class="title-info">
    <p>قائمة المنتجات</p><i style="color: #fff;" class="fas fa-box"></i>
</div>

<div class="product-container">
    <h3><strong>اسم المنتج:</strong> {{ $product->name }}</h3>
    <h5><strong>وصف المنتج:</strong> {{ $product->description }}</h5>
    <h5><strong> الكمية المتاحة :</strong> {{ $product->quantity }}</h5>
    <h5><strong>عدد الطلبات :</strong> {{ $sold }}</h5>
    <h5 class="text-primary">السعر: {{ $product->price }}$</h5>

    <div class="buttons">
        <button
            onclick="openModal('orderProductModal', '{{ $product->id }}', '{{ $product->name }}', '{{ $product->company }}', '{{ $product->price }}')">
            طلب المنتج
        </button>
        <button
            onclick="openModal('discountModal', '{{ $product->id }}', '{{ $product->name }}', '{{ $product->price }}')">
            إضافة خصم   
        </button>


    </div>
</div>

<div id="orderProductModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('orderProductModal')">&times;</span>
        <h5 id="modalOrderTitle">طلب المنتج</h5>
        <form action="{{ route('company.store') }}" method="POST">
            @csrf
            <label>📧 إيميل الشركة</label>
            <input type="email" id="modalCompanyEmail" name="company_email" value="{{ $product->company->email }}">

            <label>🔢 كود المنتج</label>
            <input type="text" id="modalProductCode" name="product_code" value="{{ $product->code }}">

            <label>📦 الكمية المطلوبة</label>
            <input type="number" id="modalQuantity" name="quantity" placeholder="ادخل الكمية" required>

            <button type="submit">إرسال الطلب</button>
        </form>
    </div>
</div>

<div id="discountModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal('discountModal')">&times;</span>
        <h5 id="discountModalTitle">إضافة خصم على المنتج</h5>

        <form action="{{ route('product.discount' , $product->id) }}" method="POST">
            @csrf

            <input type="hidden" id="discountProductId" name="product_id">

            <label>📛 اسم المنتج</label>
            <input type="text" id="discountProductName" value="{{ $product->name }}" name="product_name" readonly>

            <label>💰 السعر القديم</label>
            <input type="number" id="oldPrice" value="{{ $product->price }}" name="old_price" readonly>

            <label>💸 السعر الجديد بعد الخصم</label>
            <input type="number" id="newPrice" name="new_price" placeholder="ادخل السعر الجديد" required>

            <button type="submit">حفظ الخصم</button>
        </form>
    </div>
</div>

@section('js')
<script src="{{ asset('front/js/show.js')}}"></script>
@endsection

@endsection