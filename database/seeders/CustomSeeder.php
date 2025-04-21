<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
            Artisan::call('module:seed', [
                'module' => 'Course',
                '--class' => 'CourseTableSeeder'
            ]);

            Artisan::call('module:seed', [
                'module' => 'Payment',
                '--class' => 'PaymentMethodSeederTableSeeder'
            ]);
            Artisan::call('module:seed', [
                'module' => 'Certificate',
                '--class' => 'TemplateSeederTableSeeder'
            ]);

            Artisan::call('module:seed', [
                'module' => 'Setting',
                '--class' => 'SettingTableSeeder'
            ]);
            Artisan::call('module:seed', [
                'module' => 'CMS',
                '--class' => 'CMSDatabaseSeeder'
            ]);
            Artisan::call('module:seed', [
                'module' => 'Accounts',
                '--class' => 'AccountsDatabaseSeeder'
            ]);
            Artisan::call('module:seed', [
                'module' => 'Subscription',
                '--class' => 'SubscriptionTableSeeder'
            ]);
            Artisan::call('module:seed', [
                'module' => 'Organization',
                '--class' => 'OrganizationTableSeeder'
            ]);

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
