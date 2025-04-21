<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $paymentMethods = [
            [
                'title' => 'Stripe',
                'name' => 'stripe',
                'status_id' => 1,
                'credentials' => null,
            ],
            [
                'title' => 'Sslcommerz',
                'name' => 'sslcommerz',
                'status_id' => 1,
                'credentials' => null,
            ],
        ];

        foreach ($paymentMethods as $paymentMethod) {
            \Modules\Payment\Entities\PaymentMethod::create($paymentMethod);
        }
    }
}
