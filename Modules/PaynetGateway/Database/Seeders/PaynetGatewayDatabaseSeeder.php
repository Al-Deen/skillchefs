<?php

namespace Modules\PaynetGateway\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Entities\PaymentMethod;

class PaynetGatewayDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        PaymentMethod::updateOrCreate(
            ['name' => 'Paynet', 'title' => 'Paynet','status_id' => 1]
        );
    }
}
