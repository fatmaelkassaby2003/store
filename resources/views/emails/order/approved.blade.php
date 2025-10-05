@component('mail::message')
# تم الموافقة على طلبك 🎉

مرحباً {{ $order->userInfo->fname ?? 'عميلنا' }},

تمت الموافقة على طلبك رقم **#{{ $order->id }}**.

إجمالي السعر: **{{ $order->total_price }}$**

شكراً لك،  
{{ config('app.name') }}
@endcomponent
