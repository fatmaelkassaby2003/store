@extends('layouts.dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('dashboard/show.css') }}">
@endsection
@section('content')
    <style>

        .title-info p {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .title-info i {
            font-size: 1.8rem;
        }

        .order-details {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
        }

        .order-id {
            font-size: 1.4rem;
            font-weight: 700;
            color: #000;
        }

        .order-total {
            font-size: 1.3rem;
            font-weight: 600;
            color: #000;
            background-color: rgba(39, 174, 96, 0.1);
            padding: 8px 15px;
            border-radius: 30px;
        }

        .section-title {
            color: #27ae60;
            margin: 25px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #27ae60;
            font-weight: 600;
        }

        .product-item {
            background-color: #f8f9fa;
            border-radius: var(--border-radius);
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #27ae60;
            transition: transform 0.2s;
        }

        .product-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .product-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .product-detail-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
        }

        .product-label {
            color: #555;
            font-weight: 600;
            min-width: 140px;
            margin-bottom: 0;
        }

        .product-value {
            color: #555;
            margin-bottom: 0;
            margin-right: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            background-color: #f8f9fa;
            padding: 12px 15px;
            border-radius: var(--border-radius);
            border-left: 3px solid #27ae60;
        }

        .info-label {
            font-weight: 600;
            color: #27ae60;
            margin-bottom: 5px;
        }

        .info-value {
            color: #555;
        }

        .btn-approve {
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(39, 174, 96, 0.3);
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(39, 174, 96, 0.4);
            background: white;
            color: #27ae60;
            border: 1px solid #27ae60;
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
        }

        .alert-success {
            background-color: rgba(39, 174, 96, 0.15);
            color: #155724;
            border-left: 4px solid var(--success-color);
        }

        .alert-danger {
            background-color: rgba(231, 76, 60, 0.15);
            color: #721c24;
            border-left: 4px solid var(--danger-color);
        }

        hr {
            margin: 30px 0;
            border-top: 1px solid #eaeaea;
        }

        @media (max-width: 768px) {
            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .order-total {
                margin-top: 10px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .product-detail-item {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .product-label {
                min-width: auto;
                margin-bottom: 5px;
            }
        }
    </style>

    <div class="title-info">
        <p>تفاصيل الطلب</p>
        <i style="color: #fff;" class="fas fa-box"></i>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="order-details">
        <div class="order-header">
            <div class="order-id">رقم الطلب: #{{ $order->id }}</div>
            <div class="order-total">الإجمالي: {{ $order->total_price }}$</div>
        </div>

        <h4 class="section-title">المنتجات المطلوبة</h4>
        @foreach($order->items as $item)
            <div class="product-item">
                <div class="product-details">
                    <div class="product-detail-item">
                        <strong class="product-label">اسم المنتج:</strong>
                        <span class="product-value">{{ $item->product->name ?? 'غير متوفر' }}</span>
                    </div>
                    <div class="product-detail-item">
                        <strong class="product-label">الكمية المطلوبة:</strong>
                        <span class="product-value">{{ $item->quantity }}</span>
                    </div>
                    <div class="product-detail-item">
                        <strong class="product-label">سعر الوحدة:</strong>
                        <span class="product-value">$ {{ $item->product->price ?? 0 }}</span>
                    </div>
                    <div class="product-detail-item">
                        <strong class="product-label">الإجمالي:</strong>
                        <span class="product-value">$ {{ ($item->product->price ?? 0) * $item->quantity }}</span>
                    </div>
                </div>
            </div>
        @endforeach

        <h4 class="section-title">بيانات العميل</h4>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">الاسم</div>
                <div class="info-value">{{ $order->userInfo->fname ?? '' }} {{ $order->userInfo->lname ?? '' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">البريد الإلكتروني</div>
                <div class="info-value">{{ $order->userInfo->email ?? '---' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">الهاتف</div>
                <div class="info-value">{{ $order->userInfo->phone ?? '---' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">الشركة</div>
                <div class="info-value">{{ $order->userInfo->company ?? '---' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">البلد</div>
                <div class="info-value">{{ $order->userInfo->country ?? '---' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">الرمز البريدي</div>
                <div class="info-value">{{ $order->userInfo->zip_code ?? '---' }}</div>
            </div>
        </div>
        
        <div class="info-item mb-3">
            <div class="info-label">العنوان</div>
            <div class="info-value">{{ $order->userInfo->address ?? '' }} - {{ $order->userInfo->street ?? '' }} - {{ $order->userInfo->state ?? '' }}</div>
        </div>
        
        <div class="info-item">
            <div class="info-label">ملاحظة</div>
            <div class="info-value">{{ $order->userInfo->message ?? '---' }}</div>
        </div>

        <hr>
        <form action="{{ route('orders.approve', $order->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الموافقة على الطلب؟')">
            @csrf
            <button type="submit" class="btn btn-approve">
                <i class="fas fa-check-circle me-2"></i> الموافقة على الطلب
            </button>
        </form>
    </div>
@endsection