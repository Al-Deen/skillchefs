<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (@Session()->get('temp_data') || env('APP_TEST')) {

            $data = [
                [
                    // 1
                    'serial' => 1,
                    'status_id' => '1',
                    'created_by' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'image_id' => '14',
                ],

                [
                    // 2
                    'serial' => 2,
                    'status_id' => '1',
                    'created_by' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'image_id' => '15',
                ],
                [
                    // 3
                    'serial' => 3,
                    'status_id' => '1',
                    'created_by' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'image_id' => '16',
                ],
                [
                    // 4
                    'serial' => 4,
                    'status_id' => '1',
                    'created_by' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'image_id' => '17',
                ],
                [
                    // 5
                    'serial' => 5,
                    'status_id' => '1',
                    'created_by' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'image_id' => '18',
                ],

            ];
            DB::table('brands')->insert($data);
        }
    }
}
