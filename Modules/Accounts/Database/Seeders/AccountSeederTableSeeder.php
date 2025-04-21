<?php

namespace Modules\Accounts\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AccountSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounts')->insert([
            [
                'name' => 'Account 1',
                'ac_name' => 'John Doe',
                'ac_number' => '123456789',
                'code' => '123456789',
                'branch' => 'California',
                'balance' => 0,
                'status_id' => 1,
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]); 


    }
}
