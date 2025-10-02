@extends('layouts.dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('dashboard/dash.css') }}">
@endsection
@section('content')

<div class="title-info">
    <p>الموظفين</p>
    <a href="#" class="add-employee-btn" onclick="openForm()">إضافة موظف</a>
</div>

<!-- الفورم المنبثق -->
<div id="employeeForm" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeForm()">&times;</span>
        <h2>إضافة موظف جديد</h2>
        <form method="post" action="{{ route('user.add') }}">
            @csrf

            <label for="employeeName">اسم الموظف:</label>
            <input type="text" id="employeeName" name="name" placeholder="أدخل اسم الموظف" required>
            <label for="branch">الفرع:</label>
            <select id="branch" name="branch" required>
                <option value="" disabled selected>اختر الفرع</option>
                <option value="مصر">مصر</option>
                <option value="الإمارات">الإمارات</option>
                <option value="السعودية">السعودية</option>
            </select>

            <label for="employeeEmail">البريد الإلكتروني:</label>
            <input type="email" id="employeeEmail" name="email" placeholder="أدخل البريد الإلكتروني" required>


            <label for="employeePassword">كلمة المرور:</label>
            <input type="password" id="employeePassword" name="password" placeholder="أدخل كلمة المرور" required>

            <label for="employeePasswordConfirm">تأكيد كلمة المرور:</label>
            <input type="password" id="employeePasswordConfirm" name="password_confirmation" placeholder="أعد إدخال كلمة المرور" required>

            <button type="submit">إضافة الموظف</button>
        </form>
    </div>
</div>
<table>
    <thead>
        <tr>
            <th>
                اسم المستخدم
            </th>

            <th>
                البريد الإلكتروني للمستخدم
            </th>
            <th>
                الدور
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userss as $user)
        <tr>
            <td>
                {{ $user->name }}
            </td>

            <td>
                {{ $user->email }}
            </td>
            <td>
                <span class="role">

                    @if ($user->role == 'user')
                    عميل
                    @else
                    موظف
                    @endif

                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="row mt-5">
  <div class="col-md-12 text-center">
    <div class="site-block-27" style="margin: 20px 0;"> <!-- هنا أضفنا margin من الأعلى والأسفل -->
      {{ $userss->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>

@section('js')
<script src="{{ asset('front/js/dash.js')}}"></script>
@endsection
@endsection