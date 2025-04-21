<?php

namespace Modules\Certificate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Certificate\Database\Seeders\TemplateSeederTableSeeder;

class CertificateDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(TemplateSeederTableSeeder::class);
    }
}
