@extends('layouts.layout')
@section('content')
<div class="invoice-container">
    <h2>إضافة المنتجات</h2>
    <form id="invoiceForm" action="{{ route('cashier.store') }}" method="POST" onsubmit="return submitAndPrint(event)">
        @csrf
        <input type="text" id="productCode" placeholder="كود المنتج" oninput="fetchProductDetails()">
        <input type="number" id="productQuantity" placeholder="الكمية" min="1" value="1" oninput="updateTotalPrice()">
        <input type="text" id="productName" placeholder="اسم المنتج" disabled>
        <input type="text" id="totalPrice" placeholder="السعر الكلي" readonly>
        
        <input type="hidden" name="total_price" id="hiddenTotalPrice">

        <button type="button" onclick="addProduct()">إضافة المنتج</button>

        <h3>قائمة المنتجات</h3>
        <ul id="productList" class="product-list"></ul>
        
        <div class="buttons">
            <button class="btn-print" type="submit">🖨 تسجيل وطباعة الفاتورة</button>
        </div>
    </form>
</div>
@section('scripts')
<script src="{{ asset('front/js/cashier.js') }}"></script>
@endsection
@endsection