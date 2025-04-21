<?php

namespace Modules\Certificate\Database\Seeders;

use App\Models\Upload;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Certificate\Entities\CertificateTemplate;

class TemplateSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CertificateTemplate::create([
            'title' => 'Certificate of Completion',
            'text' => 'This is to certify that [name] has successfully completed the course [course] on [date].',
            'is_rtl' => 0,
            'default_id' => 11,
        ]);
    }
}
