<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\Searchable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;

class ApiOrderController extends Controller
{
    use Searchable;
    public function index(Request $request)
    {
        $query = Order::query();
        $this->search($query, ['package_name', 'transaction_id', 'order_id', 'payment_provider', 'paid_in_currency', 'payment_status']);
        $orders = $query->orderBy('id', 'DESC')->paginate(20);
        return $orders;
    }

    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return $order;
    }

    public function invoice(string $id)
    {
        $order = Order::findOrFail($id);

        $customer = new Buyer([
            'name' => $order?->company?->name,
            'custom_fields' => [
                'email' => $order?->company?->email,
                'transaction' => $order->transaction_id,
                'payment method' => $order->payment_provider,
            ],
        ]);

        $seller = new Party([
            'name' => config('settings.site_name'),
            'phone' => config('settings.site_phone'),
            'custom_fields' => [
                'email' => config('settings.site_email'),
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
