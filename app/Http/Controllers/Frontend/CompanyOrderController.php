<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\View\View;

use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;


class CompanyOrderController extends Controller
{
    use Searchable;
    function index(): View
    {
        $query = Order::query()->where('company_id', auth()->user()->company?->id);
        $query->with(['company', 'plan']);
        $orders = $query->orderBy('id', 'DESC')->paginate(5);
        return view('frontend.company-dashboard.order.index', compact('orders'));
    }

    function show(string $id): View
    {
        $order = Order::findOrFail($id);
        return view('frontend.company-dashboard.order.show', compact('order'));
    }

    function invoice(string $id)
    {
        $order = Order::findOrFail($id);
        $customer = new Buyer([
            'name'          => $order?->company?->name,
            'custom_fields' => [
                'email' => $order?->company?->email,
                'transaction' => $order->transaction_id,
                'payment method' => $order->payment_provider,
            ],
        ]);
        $seller = new Party([
            'name'          => config('settings.site_name'),
            'phone'         => config('settings.site_phone'),
            'custom_fields' => [
                'email'         => config('settings.site_email'),
            ],
        ]);
        $item = InvoiceItem::make($order->package_name . ' Plan')->pricePerUnit($order->amount);
        $invoice = Invoice::make()
            ->series($order->order_id)
            ->currencyCode($order->paid_in_currency)
            ->currencySymbol($order->paid_in_currency)
            ->buyer($customer)
            ->seller($seller)
            ->status('Paid')
            ->addItem($item);

        return $invoice->download();
    }
}
