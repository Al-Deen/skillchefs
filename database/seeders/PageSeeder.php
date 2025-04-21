<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = '../public/DB/pages.sql';
        if (file_exists($path)) {
            DB::unprepared(file_get_contents($path));
        } else {
            $path = 'public/DB/pages.sql';
            if (file_exists($path)) {
                DB::unprepared(file_get_contents($path));
            } else {
                DB::unprepared(file_get_contents('DB/pages.sql'));
            }
        }

    }
}
