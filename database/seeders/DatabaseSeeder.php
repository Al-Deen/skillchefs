<?php

namespace Database\Seeders;

use Database\Seeders\BlogCategorySeeder;
use Database\Seeders\BlogSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\DesignationSeeder;
use Database\Seeders\FlagIconSeeder;
use Database\Seeders\HomeSliderSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\PageSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;
use Modules\Accounts\Database\Seeders\AccountsDatabaseSeeder;
use Modules\Certificate\Database\Seeders\TemplateSeederTableSeeder;
use Modules\CMS\Database\Seeders\CMSDatabaseSeeder;
use Modules\Course\Database\Seeders\CourseTableSeeder;
use Modules\Event\Database\Seeders\EventCategoryTableSeeder;
use Modules\Event\Database\Seeders\EventPermissionTableSeeder;
use Modules\Offline\Database\Seeders\OfflineDatabaseSeeder;
use Modules\Organization\Database\Seeders\OrganizationTableSeeder;
use Modules\Payment\Database\Seeders\PaymentMethodSeederTableSeeder;
use Modules\PaynetGateway\Database\Seeders\PaynetGatewayDatabaseSeeder;
use Modules\Setting\Database\Seeders\SettingTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StatusSeeder::class,
            ImageSeeder::class,
            RoleSeeder::class,
            DesignationSeeder::class,
            CountrySeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            FlagIconSeeder::class,
            LanguageSeeder::class,
            HomeSliderSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,
            PageSeeder::class,
            BrandSeeder::class,
            // CustomSeeder::class,
            // module
            CourseTableSeeder::class,
            PaymentMethodSeederTableSeeder::class,
            TemplateSeederTableSeeder::class,
            SettingTableSeeder::class,
            CMSDatabaseSeeder::class,
            AccountsDatabaseSeeder::class,

            // new Database

            EventPermissionTableSeeder::class,
            EventCategoryTableSeeder::class,
            OfflineDatabaseSeeder::class,

            OrganizationTableSeeder::class,
        ]);
        
        if(module('PaynetGateway')){
            $this->call(PaynetGatewayDatabaseSeeder::class);   
        }
    }
}
