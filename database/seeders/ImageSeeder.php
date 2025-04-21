<?php

namespace Database\Seeders;

use App\Models\Upload;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run()
    {

        // course images
        Upload::create([
            'type' => 'image',
            'name' => '2023-05-21-r0mezpajb4xn-original.png',
            'original' => 'uploads/course/thumbnail/thumbnail2023-05-21-r0mezpajb4xn-original.png',
            'paths' => json_decode('{
                "100x100": "uploads/course/thumbnail/thumbnail2023-05-21-c9mkv0komrib-1.webp",
                "300x300": "uploads/course/thumbnail/thumbnail2023-05-21-cvkpezdgonsm-2.webp",
                "600x600": "uploads/course/thumbnail/thumbnail2023-05-21-r7ariuzjkirc-3.webp"
            }'),
        ]);

        Upload::create([
            'type' => 'image',
            'name' => '2023-05-21-7q1lul7rg9ya-original.png',
            'original' => 'uploads/course/thumbnail/thumbnail2023-05-21-7q1lul7rg9ya-original.png',
            'paths' => json_decode('{
                "100x100": "uploads/course/thumbnail/thumbnail2023-05-21-8w2wsxpjtqqj-1.webp",
                "300x300": "uploads/course/thumbnail/thumbnail2023-05-21-irexgnkw2jsu-2.webp",
                "600x600": "uploads/course/thumbnail/thumbnail2023-05-21-gd4nntjbvzha-3.webp"
            }'),
        ]);

        Upload::create([
            'type' => 'image',
            'name' => '2023-05-21-vvf4puderasx-original.png',
            'original' => 'uploads/course/thumbnail/thumbnail2023-05-21-vvf4puderasx-original.png',
            'paths' => json_decode('{
                "100x100": "uploads/course/thumbnail/thumbnail2023-05-21-giidvwkpfyzg-1.webp",
                "300x300": "uploads/course/thumbnail/thumbnail2023-05-21-fchclqsqjhm4-2.webp",
                "600x600": "uploads/course/thumbnail/thumbnail2023-05-21-dmuvt31ywwp2-3.webp"
            }'),
        ]);
        Upload::create([
            'type' => 'image',
            'name' => '2023-05-21-3dlnsmo7fpu1-original.png',
            'original' => 'uploads/course/thumbnail/thumbnail2023-05-21-3dlnsmo7fpu1-original.png',
            'paths' => json_decode('{
                "100x100": "uploads/course/thumbnail/thumbnail2023-05-21-wqkcmgateskq-1.webp",
                "300x300": "uploads/course/thumbnail/thumbnail2023-05-21-luyce8itnfrj-2.webp",
                "600x600": "uploads/course/thumbnail/thumbnail2023-05-21-uzc7mtncomjy-3.webp"
            }'),
        ]);

        // slider images
        Upload::create([
            'type' => 'image',
            'name' => '2023-04-13-3jkxoroofhj3-original.jpeg',
            'original' => 'uploads/Slider/image/images2023-04-13-3jkxoroofhj3-original.jpeg',
            'paths' => json_decode('{
                "400x1260": "uploads/Slider/image/images2023-04-13-jtaqj3rbr0ww-1.webp"
            }'),
        ]);
        Upload::create([
            'type' => 'image',
            'name' => '2023-04-13-bwzfnilgbx8b-original.jpeg',
            'original' => 'uploads/Slider/image/images2023-04-13-bwzfnilgbx8b-original.jpeg',
            'paths' => json_decode('{
                "400x1260": "uploads/Slider/image/images2023-04-13-lak8ajwixm1l-1.webp"
            }'),
        ]);
    }
}
