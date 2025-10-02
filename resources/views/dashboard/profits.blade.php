@extends('layouts.dashboard')
@section('content')

<div class="title-info">
    <p>قائمة المنتجات</p>
    <i style="color: #fff;" class="fas fa-box"></i>
</div>

<table>
    <thead>
        <tr>
            <th>الفرع</th>
            <th>اجمالى المبيعات </th>
            <th>اجمالى الربح</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td> مصر  </td>
            <td>{{ $total_egypt }}$</td>
            <td>{{ number_format($total_egypt * 0.15, 2) }} $</td>
        </tr>
        <tr>
            <td>السعودية  </td>
            <td>{{ $total_saudi }}$</td>
            <td>{{ number_format($total_saudi * 0.15, 2) }} $</td>
        </tr>
        <tr>
            <td>الامارات </td>
            <td>{{ $total_emirates }} $</td>
            <td>{{ number_format($total_emirates * 0.15, 2) }} $</td>
        </tr>
        <tr>
            <td> المتجر الالكترونى    </td>
            <td>{{ $total_ecommerce }} $</td>
            <td>{{ number_format($total_ecommerce * 0.15, 2) }} $</td>
            </tr>
    </tbody>
</table>

@endsection