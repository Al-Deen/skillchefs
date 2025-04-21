<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BlogCategorySeeder extends Seeder
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
                    'title' => 'Blog Category one',
                    'slug' => Str::slug('Blog Category one'),
                    'status_id' => '1',
                    'created_by' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    // 2
                    'title' => 'Blog Category two',
                    'slug' => Str::slug('Blog Category two'),
                    'status_id' => '1',
                    'created_by' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ];
            DB::table('blog_categories')->insert($data);
        }
    }
}
