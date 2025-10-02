@extends('layouts.dashboard')
@section('content')
<div class="title-info">
    <p>قائمة المنتجات</p>
    <i style="color: #fff;" class="fas fa-box"></i>
</div>

<table>
    <thead>
        <tr>
            <th>رقم الطلب</th>
            <th>اسم المنتج</th>
            <th>الكمية المطلوبة</th>
            <th>عرض المنتج</th>
            <th>عرض الطلب</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $item)
        <tr>
            <td>{{ $item->order_id }}</td>
            <td>{{ $item->product->name ?? 'غير متوفر' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>
                @if($item->product)
                    <a href="{{ route('products.view', ['id' => $item->product_id]) }}" 
                       class="btn btn-primary" style="text-decoration: none;">عرض →</a>
                @else
                    <span class="text-danger">لا يوجد منتج</span>
                @endif
            </td>
            <td>
                <a href="{{ route('orders.show', $item->order_id) }}" 
                   class="btn btn-primary" style="text-decoration: none;">عرض →</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
