@extends('layouts.dashboard')
@section('content')
<div class="title-info">
    <p>قائمة الطلبات</p>
    <i style="color: #fff;" class="fas fa-box"></i>
</div>

<table>
    <thead>
        <tr>
            <th>رقم الطلب</th>
            <th>اسم العميل</th>
            <th>عدد المنتجات</th>
            <th>عرض الطلب</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user->name ?? 'غير معروف' }}</td>
            <td>{{ $order->items->count() }}</td>
            <td>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary" style="text-decoration: none;">
                    عرض →
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="row mt-5">
  <div class="col-md-12 text-center">
    <div class="site-block-27" style="margin: 20px 0;"> <!-- هنا أضفنا margin من الأعلى والأسفل -->
      {{ $orders->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>

@endsection
