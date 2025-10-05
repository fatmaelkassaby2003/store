<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function initPayment(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::with('user')->findOrFail($orderId);
        if (!$order->user) {
            return redirect()->back()->with('error', 'مستخدم الطلب غير موجود.');
        }

        // المبلغ بالمليم (EGP * 100)
        $amount = intval($order->total_price * 100);

        // مفاتيح Paymob من .env
        $apiKey = config('paymob.api_key');
        $integrationId = config('paymob.integration_id');
        $iframeId = config('paymob.iframe_id');
        $hmac = config('paymob.hmac');
        try {
            $client = new Client();

            // 1- احصل على auth token
            $response = $client->post('https://accept.paymob.com/api/auth/tokens', [
                'json' => ['api_key' => $apiKey]
            ]);
            $authData = json_decode($response->getBody(), true);
            $authToken = $authData['token'] ?? null;

            if (!$authToken) {
                throw new \Exception('فشل الحصول على auth token من Paymob.');
            }



            // 2- إنشاء Order داخل Paymob
            $orderResponse = $client->post('https://accept.paymob.com/api/ecommerce/orders', [
                'json' => [
                    'auth_token' => $authToken,
                    'delivery_needed' => false,
                    'amount_cents' => $amount,
                    'currency' => 'EGP',
                    'merchant_order_id' => $order->id,
                ]
            ]);
            $paymobOrder = json_decode($orderResponse->getBody(), true);

            if (!isset($paymobOrder['id'])) {
                throw new \Exception('فشل إنشاء الطلب في Paymob.');
            }

            // 3- إنشاء Payment Key
            $paymentKeyResponse = $client->post('https://accept.paymob.com/api/acceptance/payment_keys', [
                'json' => [
                    'auth_token' => $authToken,
                    'amount_cents' => $amount,
                    'expiration' => 3600,
                    'order_id' => $paymobOrder['id'],
                    'billing_data' => [
                        'apartment' => 'NA',
                        'email' => $order->user->email ?? 'test@example.com',
                        'floor' => 'NA',
                        'first_name' => $order->user->fname ?? 'Test',
                        'last_name' => $order->user->lname ?? 'User',
                        'phone_number' => $order->user->phone ?? '0000000000',
                        'street' => $order->user->street ?? 'NA',
                        'building' => 'NA',
                        'city' => $order->user->state ?? 'Cairo',
                        'postal_code' => $order->user->zip_code ?? '12345',
                        'country' => $order->user->country ?? 'EG'
                    ],
                    'currency' => 'EGP',
                    'integration_id' => $integrationId
                ]
            ]);
            $paymentData = json_decode($paymentKeyResponse->getBody(), true);

            if (!isset($paymentData['token'])) {
                throw new \Exception('فشل الحصول على payment token من Paymob.');
            }

            // 4- تحويل المستخدم لواجهة الدفع
            $iframeUrl = "https://accept.paymob.com/api/acceptance/iframes/{$iframeId}?payment_token={$paymentData['token']}";
            return redirect($iframeUrl);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الدفع: ' . $e->getMessage());
        }
    }


    public function callback(Request $request)
    {
        $data = $request->all();
        $orderId = $data['merchant_order_id'] ?? null;
        $success = $data['success'] ?? false;

        if (!$orderId) {
            return response()->json(['error' => 'Order ID missing'], 400);
        }
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // تحديث حالة الدفع
        $order->payment_status = $success ? 'paid' : 'failed';
        $order->save();

        // إعادة توجيه المستخدم بعد الدفع (لو هو راجع من iframe)
        if ($success) {
            return redirect()->route('thankyou')->with('success', 'تم الدفع بنجاح!');
        } else {
            return redirect()->route('cart')->with('error', 'فشل الدفع. حاول مرة أخرى.');
        }
    }
}
