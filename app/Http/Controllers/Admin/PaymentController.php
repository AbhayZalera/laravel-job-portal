<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Notify;
use App\Services\OrderService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Boolean;
use Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Razorpay\Api\Api as RazorpayApi;
use Redirect;
use Str;
use Illuminate\Support\Facades\Log;
use Ixudra\Curl\Facades\Curl;

class PaymentController extends Controller
{

    function paymentSuccess(): View
    {
        return view('frontend.pages.payment-success');
    }

    function paymentError(): View
    {
        return view('frontend.pages.payment-error');
    }

    // PayPal
    function setPaypalConfig(): array
    {
        return [
            'mode'    => config('gatewaySettings.paypal_acoount_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => config('gatewaySettings.paypal_client_id'),
                'client_secret'     => config('gatewaySettings.paypal_client_secret'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('gatewaySettings.paypal_client_id'),
                'client_secret'     => config('gatewaySettings.paypal_client_secret'),
                'app_id'            => config('gatewaySettings.paypal_app_id'),
            ],

            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => config('gatewaySettings.paypal_currency_name'),
            'notify_url'     => '', // Change this accordingly for your application.
            'locale'         => 'en_US', //'en_IN'
            // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
        ];
        // return $config;
    }

    function payWithPaypal()
    {
        abort_if(!$this->checkSession(), 404);
        if (!(isCompanyProfileComplete())) {
            Notify::errorNotification('Complete your profle first for purchase plan!!..');
            return redirect()->back();
        }

        // dd($this->setPaypalConfig());
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();
        //calculate Payable Amount
        // dd($provider);
        $payableAmount = round(Session::get('selected_plan')['price'] * config('gatewaySettings.paypal_currency_rate'));
        // dd($payableAmount);
        // dd(config('gatewaySettings.paypal_currency_name'));
        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('company.paypal.success'),
                'cancel_url' => route('company.paypal.cancel')
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('gatewaySettings.paypal_currency_name'),
                        'value' => $payableAmount
                    ]
                ]
            ]
        ]);
        // dd($response);
        // dd(isset($response['id']) && $response['id'] !== NULL);
        if (isset($response['id']) && $response['id'] !== NULL) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }
    }
    function paypalSuccess(Request $request)
    {
        abort_if(!$this->checkSession(), 404);
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        // dd($response);
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $capture = $response['purchase_units'][0]['payments']['captures'][0];
            try {
                OrderService::storeOrder(
                    $capture['id'],
                    'payPal',
                    $capture['amount']['value'],
                    $capture['amount']['currency_code'],
                    'paid'
                );
                OrderService::setUserPlan();
                return redirect()->route('company.payment.success');
            } catch (\Exception $e) {
                logger('Payment ERROR >> ' . $e);
            }
        }
        Session::forget('selected_plan');
        return redirect()->route('company.payment.error')->withErrors(['error' => $response['error']['message']]);
    }
    function paypalCancel()
    {
        return redirect()->route('company.payment.error')->withErrors(['error' => "Something went wrong plaese try again"]);
    }

    //Stripe
    function payWithStripe()
    {
        abort_if(!$this->checkSession(), 404);
        if (!(isCompanyProfileComplete())) {
            Notify::errorNotification('Complete your profle first for purchase plan!!..');
            return redirect()->back();
        }
        Stripe::setApiKey(config('gatewaySettings.stripe_client_secret'));

        //Calculate Payable Amount
        $payableAmount = round(Session::get('selected_plan')['price'] * config('gatewaySettings.stripe_currency_rate')) * 100;
        // dd($payableAmount);
        $response = StripeSession::create(
            [
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => config('gatewaySettings.stripe_currency_name'),
                            'product_data' => [
                                'name' => Session::get('selected_plan')['label'] . 'package',
                            ],
                            'unit_amount' => $payableAmount
                        ],
                        'quantity' => 1
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('company.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('company.stripe.cancel')
            ]
        );
        return redirect()->away($response->url);
        // dd($response);
    }

    function stripeSuccess(Request $request)
    {
        abort_if(!$this->checkSession(), 404);
        // dd($request);
        Stripe::setApiKey(config('gatewaySettings.stripe_client_secret'));
        $sessionId = $request->session_id;
        $response = StripeSession::retrieve($sessionId);
        // dd($response);
        if ($response->payment_status === 'paid') {
            try {
                OrderService::storeOrder(
                    $response->payment_intent,
                    'stripe',
                    ($response->amount_total / 100),
                    $response->currency,
                    'paid'
                );
                OrderService::setUserPlan();
                return redirect()->route('company.payment.success');
            } catch (\Exception $e) {
                logger('Payment ERROR >> ' . $e);
            }
        } else {
            return redirect()->route('company.payment.error')->withErrors(['error' => 'Payment Failed']);
        }
    }

    function stripeCancel()
    {
        return redirect()->route('company.payment.error')->withErrors(['error' => 'Payment Failed']);
    }

    //RazorPay

    // function razorpayRedirect(): View
    // {
    //     abort_if(!$this->checkSession(), 404);
    //     return view('frontend.pages.razorpay-redirect');
    // }
    // function payWithRazorpay(Request $request)
    // {
    //     // dd($request->all());
    //     abort_if(
    //         !$this->checkSession(),
    //         404
    //     );
    //     $api = new RazorpayApi(
    //         config('gatewaySettings.razorpay_key'),
    //         config('gatewaySettings.razorpay_client_secret')
    //     );
    //     // dd(config('gatewaySettings.razorpay_client_secret'));
    //     if (isset($request->razorpay_payment_id) && $request->filled('razorpay_payment_id')) {
    //         $payableAmount = round(Session::get('selected_plan')['price'] * config('gatewaySettings.razorpay_currency_rate')) * 100;

    //         try {
    //             $response = $api->payment->fetch($request->razorpay_payment_id)->capture(['amount' => $payableAmount]);
    //             // dd($response);
    //             if ($response['status'] === 'captured') {
    //                 OrderService::storeOrder(
    //                     $response->id,
    //                     'razorpay',
    //                     ($response->amount / 100),
    //                     $response->currency,
    //                     'paid'
    //                 );
    //                 OrderService::setUserPlan();
    //                 return redirect()->route('company.payment.success');
    //             } else {
    //                 return redirect()->route('company.payment.error')->withErrors(['error' => 'Something went wrong please try again']);
    //             }
    //         } catch (\Exception $e) {
    //             logger($e);
    //             return redirect()->route('company.payment.error')->withErrors(['error' => $e->getMessage()]);
    //         }
    //     }
    // }

    function razorpayRedirect(): View|RedirectResponse
    {
        abort_if(!$this->checkSession(), 404);
        if (!(isCompanyProfileComplete())) {
            Notify::errorNotification('Complete your profle first for purchase plan!!..');
            return redirect()->back();
        }
        return view('frontend.pages.razorpay-redirect');
    }

    function payWithRazorpay(Request $request)
    {
        abort_if(!$this->checkSession(), 404);

        if ($request->input('payment_abandoned') == 1) {
            return redirect()->route('company.payment.error')->withErrors(['error' => 'Payment was abandoned.']);
        }

        $api = new RazorpayApi(
            config('gatewaySettings.razorpay_key'),
            config('gatewaySettings.razorpay_client_secret')
        );

        if (isset($request->razorpay_payment_id) && $request->filled('razorpay_payment_id')) {
            $payableAmount = round(Session::get('selected_plan')['price'] * config('gatewaySettings.razorpay_currency_rate')) * 100;

            try {
                $response = $api->payment->fetch($request->razorpay_payment_id)->capture(['amount' => $payableAmount]);

                if ($response['status'] === 'captured') {
                    OrderService::storeOrder(
                        $response->id,
                        'razorpay',
                        ($response->amount / 100),
                        $response->currency,
                        'paid'
                    );
                    OrderService::setUserPlan();
                    return redirect()->route('company.payment.success');
                } else {
                    return redirect()->route('company.payment.error')->withErrors(['error' => 'Payment failed. Please try again.']);
                }
            } catch (\Exception $e) {
                logger($e);
                return redirect()->route('company.payment.error')->withErrors(['error' => $e->getMessage()]);
            }
        }
        return redirect()->route('company.payment.error')->withErrors(['error' => 'Payment failed.']);
    }


    function checkSession(): bool
    {
        if (session()->has('selected_plan')) {
            return true;
        }
        return false;
    }

    // PhonePe
    // public function payWithPhonepe()
    // {
    //     try {
    //         abort_if(!$this->checkSession(), 404);

    //         if (!isCompanyProfileComplete()) {
    //             Notify::errorNotification('Complete your profile first!');
    //             return back();
    //         }

    //         $amount = Session::get('selected_plan')['price'] * config('gatewaySettings.phonepe_currency_rate');
    //         $merchantId = config('gatewaySettings.phonepe_merchant_id');
    //         $saltKey = config('gatewaySettings.phonepe_salt_key');
    //         $saltIndex = config('gatewaySettings.phonepe_salt_index');

    //         if (empty($merchantId) || empty($saltKey)) {
    //             throw new \Exception('PhonePe credentials not configured');
    //         }

    //         $data = [
    //             "merchantId" => $merchantId,
    //             "merchantTransactionId" => "MT" . Str::uuid()->toString(),
    //             "merchantUserId" => "USER_" . auth()->id(),
    //             "amount" => $amount * 100, // Convert to paise
    //             "redirectUrl" => route('company.phonepe.callback', [], true),
    //             "redirectMode" => "POST",
    //             "callbackUrl" => route('company.phonepe.callback', [], true),
    //             "mobileNumber" => preg_replace('/[^0-9]/', '', auth()->user()->phone),
    //             "paymentInstrument" => ["type" => "PAY_PAGE"]
    //         ];

    //         // $base64Payload = base64_encode(json_encode($data));
    //         // $endpoint = '/pg/v1/pay';
    //         // $hashString = $base64Payload . $endpoint . $saltKey;
    //         // $sha256 = hash('sha256', $hashString);
    //         // $xVerifyHeader = $sha256 . '###' . $saltIndex;

    //         // 2. Convert to JSON and base64
    //         $jsonPayload = json_encode($data);
    //         $base64Payload = base64_encode($jsonPayload);

    //         // 3. Create the hash string (ORDER IS CRUCIAL!)
    //         $endpointPath = '/pg/v1/pay'; // Note the leading slash
    //         $hashString = $base64Payload . $endpointPath . $saltKey;

    //         // 4. Generate SHA256 hash
    //         $sha256Hash = hash('sha256', $hashString);

    //         // 5. Combine with salt index
    //         $xVerifyHeader = $sha256Hash . '###' . $saltIndex;

    //         $baseUrl = config('gatewaySettings.phonepe_mode') === 'sandbox'
    //             ? 'https://api-preprod.phonepe.com/apis/merchant-sandbox'
    //             : 'https://api.phonepe.com/apis/hermes';
    //         // dd($xVerifyHeader);
    //         $response = Http::withHeaders([
    //             'Content-Type' => 'application/json',
    //             'X-VERIFY' => $xVerifyHeader,
    //             'X-MERCHANT-ID' => $merchantId
    //         ])->post($baseUrl . $endpointPath, [
    //             'request' => $base64Payload
    //         ]);
    //         dd($response);
    //         if ($response->successful()) {
    //             $responseData = $response->json();

    //             if (($responseData['success'] ?? false) === true) {
    //                 return redirect()->away(
    //                     $responseData['data']['instrumentResponse']['redirectInfo']['url']
    //                 );
    //             }
    //         }

    //         Log::error('PhonePe API Error', [
    //             'status' => $response->status(),
    //             'body' => $response->body()
    //         ]);

    //         throw new \Exception('Payment initiation failed. Please try another method.');
    //     } catch (\Exception $e) {
    //         Log::error('PhonePe Payment Failed: ' . $e->getMessage());
    //         return redirect()->route('company.payment.error')
    //             ->withErrors(['error' => $e->getMessage()]);
    //     }
    // }

    public function payWithPhonepe()
    {
        try {
            abort_if(!$this->checkSession(), 404);

            if (!isCompanyProfileComplete()) {
                Notify::errorNotification('Complete your profile first!');
                return back();
            }

            $amount = Session::get('selected_plan')['price'] * config('gatewaySettings.phonepe_currency_rate');
            $merchantId = config('gatewaySettings.phonepe_merchant_id');
            $saltKey = config('gatewaySettings.phonepe_salt_key');
            $saltIndex = config('gatewaySettings.phonepe_salt_index');
            // Enhanced credential validation
            if (empty($merchantId) || empty($saltKey)) {
                throw new \Exception('PhonePe credentials not configured');
            }

            // Prepare payload with strict typing
            $data = [
                "merchantId" => (string) $merchantId,
                "merchantTransactionId" => "MT" . Str::uuid()->toString(),
                "merchantUserId" => "USER_" . auth()->id(),
                "amount" => (int) ($amount * 100), // Ensure integer value for paise
                "redirectUrl" => route('company.phonepe.callback'),
                "redirectMode" => "POST",
                "callbackUrl" => route('company.phonepe.callback'),
                "mobileNumber" => (string) preg_replace('/[^0-9]/', '', auth()->user()->company->phone),
                "paymentInstrument" => [
                    "type" => "PAY_PAGE" // Must be exactly "PAY_PAGE"
                ]
            ];

            // Validate JSON payload before encoding
            $jsonPayload = json_encode($data);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid payload data: ' . json_last_error_msg());
            }

            $base64Payload = base64_encode($jsonPayload);
            $endpoint = '/pg/v1/pay';

            // Generate X-VERIFY header with verification
            $xVerifyHeader = $this->generateXVerifyHeader($base64Payload, $endpoint, $saltKey, $saltIndex);

            // Get base URL with validation
            $baseUrl = config('gatewaySettings.phonepe_mode') === 'sandbox'
                ? 'https://api-preprod.phonepe.com/apis/merchant-sandbox'
                : 'https://api.phonepe.com/apis/hermes';

            if (!filter_var($baseUrl, FILTER_VALIDATE_URL)) {
                throw new \Exception('Invalid PhonePe API URL');
            }

            $fullUrl = $baseUrl . $endpoint;

            // Make API request with timeout and retry
            $response = Http::timeout(30)
                ->retry(3, 500)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-VERIFY' => $xVerifyHeader,
                    'X-MERCHANT-ID' => $merchantId
                ])
                ->post($fullUrl, [
                    'request' => $base64Payload
                ]);
            dd($response);
            // Enhanced response handling
            if ($response->successful()) {
                $responseData = $response->json();

                if (($responseData['success'] ?? false) === true) {
                    return redirect()->away(
                        $responseData['data']['instrumentResponse']['redirectInfo']['url']
                    );
                }
            }
            // dd($response->status());

            // Detailed error logging
            $errorContext = [
                'request' => [
                    'url' => $fullUrl,
                    'payload' => $data,
                    'base64Payload' => $base64Payload,
                    'headers' => [
                        'X-VERIFY' => $xVerifyHeader,
                        'X-MERCHANT-ID' => $merchantId
                    ]
                ],
                'response' => [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers()
                ],
                'environment' => [
                    'mode' => config('gatewaySettings.phonepe_mode'),
                    'merchant_id' => $merchantId,
                    'salt_key' => substr($saltKey, 0, 4) . '...' . substr($saltKey, -4) // Partial for security
                ]
            ];

            Log::error('PhonePe API Failure', $errorContext);

            // Extract error message from response if available
            $errorMessage = 'Payment initiation failed. Please try another method.';
            $responseBody = $response->json();
            if (isset($responseBody['message'])) {
                $errorMessage .= ' Reason: ' . $responseBody['message'];
            }

            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            Log::error('PhonePe Payment Exception: ' . $e->getMessage());
            return redirect()->route('company.payment.error')
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    protected function generateXVerifyHeader($base64Payload, $endpoint, $saltKey, $saltIndex)
    {
        // Verify endpoint starts with slash
        if (strpos($endpoint, '/') !== 0) {
            $endpoint = '/' . $endpoint;
        }

        $hashString = $base64Payload . $endpoint . $saltKey;
        $sha256 = hash('sha256', $hashString);

        // Verify hash generation
        if (strlen($sha256) !== 64) {
            throw new \Exception('Invalid hash generated');
        }

        return $sha256 . '###' . $saltIndex;
    }

    public function phonepeCallback(Request $request)
    {
        try {
            abort_if(!$this->checkSession(), 404);

            $callbackData = $request->all();
            $receivedSignature = $request->header('X-VERIFY');
            $saltKey = config('gatewaySettings.phonepe_salt_key');
            $saltIndex = config('gatewaySettings.phonepe_salt_index');

            $expectedSignature = hash('sha256', $callbackData['response'] . $saltKey) . '###' . $saltIndex;

            if (!hash_equals($expectedSignature, $receivedSignature)) {
                throw new \Exception('Invalid callback signature');
            }

            $responseData = json_decode(base64_decode($callbackData['response']), true);

            if ($responseData['code'] === 'PAYMENT_SUCCESS') {
                OrderService::storeOrder(
                    $responseData['data']['merchantTransactionId'],
                    'phonepe',
                    $responseData['data']['amount'] / 100,
                    'INR',
                    'paid'
                );

                OrderService::setUserPlan();
                return redirect()->route('company.payment.success');
            }

            throw new \Exception('Payment failed: ' . ($responseData['message'] ?? 'Unknown error'));
        } catch (\Exception $e) {
            Log::error('PhonePe Callback Error: ' . $e->getMessage());
            return redirect()->route('company.payment.error')
                ->withErrors(['error' => 'Payment verification failed.']);
        }
    }
}
