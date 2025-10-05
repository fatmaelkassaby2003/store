@extends('layouts.dashboard')
@section('content')


<form class="form-search" method="GET" action="{{ route('companies.list') }}">
    <div class="search-div">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="ابحث عن منتج..." value="{{ request('search') }}">
    </div>
    <button type="submit">
        بحث
    </button>
</form>


<div class="title-info">
    <p>الشركات</p>
    <i style="color: #fff;" class="fas fa-box"></i>
</div>

<table>
    <thead>
        <tr>
            <th>اسم الشركة </th>
            <th>البريد الإلكتروني للشركه</th>
            <th>كود الشركة</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($companiess as $company)
        <tr>
            <td>{{ $company->name }} </td>
            <td>{{ $company->email }}</td>
            <td>{{ $company->code }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="row mt-5">
  <div class="col-md-12 text-center">
    <div class="site-block-27" style="margin: 20px 0;"> <!-- هنا أضفنا margin من الأعلى والأسفل -->
      {{ $companiess->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>

@endsection