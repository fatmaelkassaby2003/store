@extends('layouts.dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('dashboard/show.css') }}">
@endsection
@section('content')
<div class="title-info">
    <p> عرض الموظف</p><i style="color: #fff;" class="fas fa-box"></i>
</div>

<div class="product-container">
    <h3>
        <strong style="float: right;"> : اسم الموظف   </strong> 
        {{ $user->name }}
    </h3>
    <h5><strong> عدد الفواتير:</strong> {{ $total_invoices }}</h5>
    <h5><strong> اجمالى مبلغ الفواتير :</strong> {{ $total_price }}</h5>
    <h5><strong>الفرع  :</strong> {{ $user->branch }}</h5>

    </div>


@endsection