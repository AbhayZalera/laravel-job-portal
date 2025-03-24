<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_settings = array(
            array(
                "id" => 1,
                "key" => "paypal_status",
                "value" => "active",
                "created_at" => "2025-02-17 13:23:39",
                "updated_at" => "2025-02-19 13:41:13",
            ),
            array(
                "id" => 2,
                "key" => "paypal_acoount_mode",
                "value" => "sandbox",
                "created_at" => "2025-02-17 13:23:39",
                "updated_at" => "2025-02-17 13:23:39",
            ),
            array(
                "id" => 3,
                "key" => "paypal_country_name",
                "value" => "US",
                "created_at" => "2025-02-17 13:23:39",
                "updated_at" => "2025-02-18 10:47:20",
            ),
            array(
                "id" => 4,
                "key" => "paypal_currency_name",
                "value" => "USD",
                "created_at" => "2025-02-17 13:23:39",
                "updated_at" => "2025-02-18 10:10:06",
            ),
            array(
                "id" => 5,
                "key" => "paypal_currency_rate",
                "value" => "1",
                "created_at" => "2025-02-17 13:23:39",
                "updated_at" => "2025-02-18 10:10:06",
            ),
            array(
                "id" => 6,
                "key" => "paypal_client_id",
                "value" => "AfcB70NlhU0C_wSM2sz81KsPc2sNvfxgJeVtYhPWuFW8n44KTu2pcJgiw0QuV1THHnYvo7FWbLubngUY",
                "created_at" => "2025-02-17 13:23:39",
                "updated_at" => "2025-02-18 06:53:45",
            ),
            array(
                "id" => 7,
                "key" => "paypal_client_secret",
                "value" => "EFtaoIZSGzCGKlkGpsUoYVddze1qQM6bpdxN8aDIJG5HcgLpdPyz1tncz6bpC6V0K03WzRaLQ7YuvWVq",
                "created_at" => "2025-02-17 13:23:39",
                "updated_at" => "2025-02-18 06:53:45",
            ),
            array(
                "id" => 8,
                "key" => "paypal_app_id",
                "value" => "Client_app_id",
                "created_at" => "2025-02-17 13:23:39",
                "updated_at" => "2025-02-17 13:23:39",
            ),
            array(
                "id" => 9,
                "key" => "stripe_status",
                "value" => "active",
                "created_at" => "2025-02-19 07:32:19",
                "updated_at" => "2025-02-19 13:41:19",
            ),
            array(
                "id" => 10,
                "key" => "stripe_country_name",
                "value" => "US",
                "created_at" => "2025-02-19 07:32:19",
                "updated_at" => "2025-02-19 07:32:19",
            ),
            array(
                "id" => 11,
                "key" => "stripe_currency_name",
                "value" => "USD",
                "created_at" => "2025-02-19 07:32:19",
                "updated_at" => "2025-02-19 07:32:19",
            ),
            array(
                "id" => 12,
                "key" => "stripe_currency_rate",
                "value" => "1",
                "created_at" => "2025-02-19 07:32:19",
                "updated_at" => "2025-02-19 07:32:19",
            ),
            array(
                "id" => 13,
                "key" => "stripe_publishable_key",
                "value" => "pk_test_51Qu6uwFRZK9ghtT9ftZIY5IkltS8JqVemRMgV1IRJB3hkp7OcRj9mCYQTq0RuAgxuVtkH4qMqWcIpYjxf61Iwyt800hIIyelnr",
                "created_at" => "2025-02-19 07:32:19",
                "updated_at" => "2025-02-19 07:32:19",
            ),
            array(
                "id" => 14,
                "key" => "stripe_client_secret",
                "value" => "sk_test_51Qu6uwFRZK9ghtT9WA5hfA5VEV8SsiosIYGM1w93GMkmw1gCMZZiErhC5KGX6E3L8hbSWtF5vIIU6taM7IGU5qdd00Zo6ffSu2",
                "created_at" => "2025-02-19 07:32:19",
                "updated_at" => "2025-02-19 07:32:19",
            ),
            array(
                "id" => 15,
                "key" => "razorpay_status",
                "value" => "active",
                "created_at" => "2025-02-19 11:38:19",
                "updated_at" => "2025-02-19 13:41:24",
            ),
            array(
                "id" => 16,
                "key" => "razorpay_country_name",
                "value" => "IN",
                "created_at" => "2025-02-19 11:38:19",
                "updated_at" => "2025-02-19 11:38:19",
            ),
            array(
                "id" => 17,
                "key" => "razorpay_currency_name",
                "value" => "INR",
                "created_at" => "2025-02-19 11:38:19",
                "updated_at" => "2025-02-19 11:38:19",
            ),
            array(
                "id" => 18,
                "key" => "razorpay_currency_rate",
                "value" => "86",
                "created_at" => "2025-02-19 11:38:19",
                "updated_at" => "2025-02-19 11:38:19",
            ),
            array(
                "id" => 19,
                "key" => "razorpay_key",
                "value" => "rzp_test_K7CipNQYyyMPiS",
                "created_at" => "2025-02-19 11:38:19",
                "updated_at" => "2025-02-19 11:49:56",
            ),
            array(
                "id" => 20,
                "key" => "razorpay_client_secret",
                "value" => "zSBmNMorJrirOrnDrbOd1ALO",
                "created_at" => "2025-02-19 11:38:19",
                "updated_at" => "2025-02-19 11:49:56",
            ),
        );
        \DB::table('payment_settings')->insert($payment_settings);
    }
}
