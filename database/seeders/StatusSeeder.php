<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Log;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                // 1
                'name' => 'Active',
                'class' => 'success',
                'color_code' => '449d44'
            ],
            [
                // 2
                'name' => 'Inactive',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ],
            [
                // 3
                'name' => 'Pending',
                'class' => 'warning',
                'color_code' => 'ec971f'
            ],
            [
                // 4
                'name' => 'Approve',
                'class' => 'success',
                'color_code' => '449d44'
            ],
            [
                // 5
                'name' => 'Suspended',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ],

            [
                // 6
                'name' => 'Reject',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ],
            [
                // 7
                'name' => 'Cancel',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ],
            [
                // 8
                'name' => 'Paid',
                'class' => 'success',
                'color_code' => '449d44'
            ],
            [
                // 9
                'name' => 'Unpaid',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ],
            [
                // 10
                'name' => 'No',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ],
            [
                // 11
                'name' => 'Yes',
                'class' => 'primary',
                'color_code' => '337ab7'
            ],
            // course type
            [
                // 12
                'name' => 'Live',
                'class' => 'tertiary',
                'color_code' => '449d44'
            ],
            [
                // 13
                'name' => 'Recorded',
                'class' => 'primary',
                'color_code' => '337ab7'
            ],
            [
                // 14
                'name' => 'Text',
                'class' => 'warning',
                'color_code' => 'ec971f'
            ],
            // video player
            [
                // 15
                'name' => 'Youtube',
                'class' => 'primary',
                'color_code' => '337ab7'
            ],
            [
                // 16
                'name' => 'Vimeo',
                'class' => 'primary',
                'color_code' => '337ab7'
            ],
            [
                // 17
                'name' => 'Html5',
                'class' => 'primary',
                'color_code' => '337ab7'
            ],
            // level
            [
                // 18
                'name' => 'Beginner',
                'class' => 'primary',
                'color_code' => '337ab7'
            ],
            [
                // 19
                'name' => 'Intermediate',
                'class' => 'success',
                'color_code' => '449d44'
            ],
            [
                // 20
                'name' => 'Advanced',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ],
            // draft
            [
                // 21
                'name' => 'Draft',
                'class' => 'warning',
                'color_code' => 'ec971f'
            ],
            // visibility
            [
                // 22
                'name' => 'Public',
                'class' => 'success',
                'color_code' => '449d44'
            ],
            [
                // 23
                'name' => 'Private',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ],
            [
                // 24
                'name' => 'Fail',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ],
            [
                // 25
                'name' => 'Passed',
                'class' => 'success',
                'color_code' => '449d44'
            ],
            [
                // 26
                'name' => 'Credit',
                'class' => 'success',
                'color_code' => '449d44'
            ],
            [
                // 27
                'name' => 'Debit',
                'class' => 'danger',
                'color_code' => 'c9302c'
            ]

        ];

        Status::query()->insert($statuses);



    }
}
