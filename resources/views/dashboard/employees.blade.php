@extends('layouts.dashboard')
@section('content')


<form class="form-search" method="GET" action="{{ route('employees.list') }}">
    <div class="search-div">
        <i class="fas fa-search"></i>
        <input type="text" name="search" placeholder="ابحث عن منتج..." value="{{ request('search') }}">
    </div>
    <button type="submit">
        بحث
    </button>
</form>


<div class="title-info">
    <p> الموظفين</p>
    <i style="color: #fff;" class="fas fa-box"></i>
</div>


<table>
    <thead>
        <tr>
            <th>اسم المستخدم</th>
            <th>البريد الإلكتروني للمستخدم</th>
            <th>عرض الموظف</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employeess as $employee)
        <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->email }} </td>
            <td><a href="{{ route('user.view', $employee->id) }}" class="btn btn-primary" style="text-decoration: none; color: #000;"> عرض → </a></td>
            <td>
                <form action="{{ route('employee.delete', $employee->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="border: none; background: none; padding: 0;">
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
    <div class="site-block-27" style="margin: 20px 0;">
    {{ $employeess->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>

@endsection