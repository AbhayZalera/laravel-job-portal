<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaypalSettingUpdateRequest;
use App\Http\Requests\Admin\PhonepeSettingUpdateRequest;
use App\Http\Requests\Admin\RazorpaySettingUpdateRequest;
use App\Http\Requests\Admin\StripeSettingUpdateRequest;
use App\Models\Country;
use App\Models\PaymentSetting;
use App\Services\Notify;
use App\Services\PaymentGatewaySettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentSettingController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:payment settings']);
    }

    function index(): View
    {

        return view('admin.payment-setting.index');
    }

    function updatePaypalSetting(PaypalSettingUpdateRequest $request): RedirectResponse
    {
        // dd($request->all());
        $validate = $request->validated();
        // dd($validate);
        foreach ($validate as $key => $value) {
            PaymentSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        Notify::updatedNotification();
        return redirect()->back();
    }

    function updateStripeSetting(StripeSettingUpdateRequest $request): RedirectResponse
    {
        // dd($request->all());
        $validate = $request->validated();
        // dd($validate);
        foreach ($validate as $key => $value) {
            PaymentSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        Notify::updatedNotification();
        return redirect()->back();
    }

    function updateRazorpaySetting(RazorpaySettingUpdateRequest $request): RedirectResponse
    {
        // dd($request->all());
        $validate = $request->validated();
        // dd($validate);
        foreach ($validate as $key => $value) {
            PaymentSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        Notify::updatedNotification();
        return redirect()->back();
    }
    function updatePhonepeSetting(PhonepeSettingUpdateRequest $request): RedirectResponse
    {
        $validate = $request->validated();

        foreach ($validate as $key => $value) {
            PaymentSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        Notify::updatedNotification();
        return redirect()->back();
    }
}
