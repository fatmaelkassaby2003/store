@extends('layouts.layout')

@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row" style="margin-Top: 90px;">
      <div class="col-md-12 mb-0">
        <a style="color: #3EBA84;" href="{{ route('home') }}">الرئيسية</a> <span class="mx-2 mb-0">/</span>
        <strong class="text-black">الدفع</strong>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-md-6 mb-5 mb-md-0">
        <h2 class="h3 mb-3 text-black">المعلومات الشخصية</h2>
        <div class="p-3 p-lg-5 border">
          <div class="form-group">
            <form action="{{ route('checkout.placeOrder') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="c_country_input">الدولة <span class="text-danger">*</span></label>
                <select name="c_country" id="c_country_input" class="form-control" style="margin-top: 10px;">
                  <option value="">اختر الدولة</option>
                  <option value="مصر">مصر</option>
                  <option value="الإمارات">الإمارات</option>
                  <option value="تونس">السعودية</option>
                </select>
              </div>
              @error('c_country')
              <span class="text-danger" style="color: red;">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="c_fname_input">الاسم الأول <span class="text-danger">*</span></label>
                <input type="text" name="c_fname" id="c_fname_input" class="form-control" placeholder="أدخل اسمك الأول" style="margin-top: 10px;">
              </div>
              @error('c_fname')
              <span class="text-danger" style="color: red;">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="c_lname_input">الاسم الأخير <span class="text-danger">*</span></label>
                <input type="text" name="c_lname" id="c_lname_input" class="form-control" placeholder="أدخل اسمك الأخير" style="margin-top: 10px;">
              </div>
              @error('c_lname')
              <span class="text-danger" style="color: red;">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="c_email_address_input">البريد الإلكتروني <span class="text-danger">*</span></label>
                <input type="email" name="c_email_address" id="c_email_address_input" class="form-control" placeholder="example@email.com" style="margin-top: 10px;">
              </div>
              @error('c_email_address')
              <span class="text-danger" style="color: red;">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="c_phone_input">رقم الهاتف <span class="text-danger">*</span></label>
                <input type="text" name="c_phone" id="c_phone_input" class="form-control" placeholder="أدخل رقم هاتفك" style="margin-top: 10px;">
              </div>
              @error('c_phone')
              <span class="text-danger" style="color: red;">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="c_companyname_input">اسم الشركة (اختياري)</label>
                <input type="text" name="c_companyname" id="c_companyname_input" class="form-control" placeholder="أدخل اسم الشركة" style="margin-top: 10px;">
              </div>

              <div class="form-group">
                <label for="c_address_input">العنوان <span class="text-danger">*</span></label>
                <input type="text" name="c_address" id="c_address_input" class="form-control" placeholder="أدخل عنوانك بالتفصيل" style="margin-top: 10px;">
              </div>
              @error('c_address')
              <span class="text-danger" style="color: red;">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="c_state_country_input">الولاية / الدولة <span class="text-danger">*</span></label>
                <input type="text" name="c_state_country" id="c_state_country_input" class="form-control" placeholder="أدخل اسم الولاية أو الدولة" style="margin-top: 10px;">
              </div>
              @error('c_state_country')
              <span class="text-danger" style="color: red;">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="c_postal_zip_input">الرمز البريدي <span class="text-danger">*</span></label>
                <input type="text" name="c_postal_zip" id="c_postal_zip_input" class="form-control" placeholder="أدخل الرمز البريدي" style="margin-top: 10px;">
              </div>
              @error('c_postal_zip')
              <span class="text-danger" style="color: red;">{{ $message }}</span>
              @enderror

              <div class="form-group">
                <label for="c_order_notes_input">ملاحظات الطلب</label>
                <textarea name="c_order_notes" id="c_order_notes_input" class="form-control" rows="4" placeholder="اكتب ملاحظاتك إن وجدت..." style="margin-top: 10px;"></textarea>
              </div>

              <button type="submit" style="background-color: #3EBA84; border-color: #3EBA84" class="btn btn-success btn-lg btn-block">إكمال الطلب</button>
            </form>
          </div>


        </div>
      </div>
      <div class="col-md-6">
        <div class="row mb-5">
          <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">قائمة المنتجات</h2>
            <div class="p-3 p-lg-5 border">
              <table class="table site-block-order-table mb-5">
                <thead>
                  <th>المنتج</th>
                  <th>المجموع</th>
                </thead>
                <tbody>
                  @foreach ($cartItems as $item)
                  <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-black font-weight-bold">{{ $item->quantity }}</td>
                    <td class="text-black font-weight-bold">${{ number_format($item->price, 2) }}</td>
                    <td class="text-black font-weight-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3" class="text-black font-weight-400">المجموع الجزئي</td>
                    <td class="text-black font-weight-bold">${{ number_format($subtotal, 2) }}</td>
                  </tr>
                  <tr>
                    <td colspan="3" class="text-black font-weight-400">الخصم</td>
                    <td class="text-black font-weight-bold">-${{ number_format($discountAmount, 2) }}</td>
                  </tr>
                  <tr>
                    <td colspan="3" class="text-black font-weight-400">الإجمالي بعد الخصم</td>
                    <td class="text-black font-weight-bold">${{ number_format($totalAfterDiscount, 2) }}</td>
                  </tr>
                  <tr>
                    <td colspan="3" class="text-black font-weight-400">المجموع النهائي (شامل الضريبة)</td>
                    <td class="text-black font-weight-bold fs-8 text-lg text-success">${{ number_format($totalWithTax, 2) }}</td>
                  </tr>
                </tfoot>
              </table>

              <div class="border mb-3">
                <h3  class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsecheque" role="button"
                    aria-expanded="false" aria-controls="collapsecheque" style="color: #3EBA84;">كاش عند الاستلام</a></h3>

                <div class="collapse" id="collapsecheque">
                  <div class="py-2 px-4">
                    <p class="mb-0">ارجو تحضير المبلغ عند استلام الطلب</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


@include('layouts.info')

@endsection