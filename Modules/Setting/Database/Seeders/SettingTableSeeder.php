<?php

namespace Modules\Setting\Database\Seeders;

use App\Models\Setting;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class SettingTableSeeder extends Seeder
{
    use CommonHelperTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            Setting::create([
                'name' => 'application_name',
                'value' => 'Onest LMS',
            ]);
            Setting::create([
                'name' => 'application_details',
                'value' => 'Lorem ipsum dolor sit amet consectetur. Morbi cras sodales elementum sed. Suspendisse adipiscing arcu magna leo sodales pellentesque. Ac iaculis mattis ornare rhoncus nibh mollis arcu.',
            ]);
            Setting::create([
                'name' => 'footer_text',
                'value' => '© ' . date('Y') . ' Onest LMS . All rights reserved.',
            ]);
            Setting::create([
                'name' => 'file_system',
                'value' => 'local',
            ]);
            Setting::create([
                'name' => 'aws_access_key_id',
                'value' => '',
            ]);
            Setting::create([
                'name' => 'aws_secret_key',
                'value' => ' ',
            ]);
            Setting::create([
                'name' => 'aws_region',
                'value' => 'ap-southeast-1',
            ]);
            Setting::create([
                'name' => 'aws_bucket',
                'value' => 'onest-starter-kit',
            ]);
            Setting::create([
                'name' => 'aws_endpoint',
                'value' => 'https://s3.ap-southeast-1.amazonaws.com',
            ]);
            Setting::create([
                'name' => 'recaptcha_sitekey',
                'value' => '6Lfn6nQhAAAAAKYauxvLddLtcqSn1yqn-HRn_CbN',
            ]);
            Setting::create([
                'name' => 'recaptcha_secret',
                'value' => '6Lfn6nQhAAAAABOzRtEjhZYB49Dd4orv41thfh02',
            ]);
            Setting::create([
                'name' => 'recaptcha_status',
                'value' => '0',
            ]);
            Setting::create([
                'name' => 'mail_drive',
                'value' => 'smtp',
            ]);
            Setting::create([
                'name' => 'mail_host',
                'value' => 'smtp.gmail.com',
            ]);
            Setting::create([
                'name' => 'mail_address',
                'value' => 'sales@onesttech.com',
            ]);
            Setting::create([
                'name' => 'from_name',
                'value' => 'O-Academy',
            ]);
            Setting::create([
                'name' => 'mail_username',
                'value' => 'sales@onesttech.com',
            ]);

            Setting::create([
                'name' => 'firebase_key',
                'value' => '',
            ]);
            Setting::create([
                'name' => 'country',
                'value' => 'Bangladesh',
            ]);

            // pass
            $mail_password = Crypt::encrypt('ya!@a+TIY3Vl&esT');
            Setting::create([
                'name' => 'mail_password',
                'value' => $mail_password,
            ]);

            Setting::create([
                'name' => 'mail_port',
                'value' => '587',
            ]);
            Setting::create([
                'name' => 'encryption',
                'value' => 'tls',
            ]);
            Setting::create([
                'name' => 'default_language',
                'value' => 'en',
            ]);
            Setting::create([
                'name' => 'currency',
                'value' => 'USD',
            ]);
            Setting::create([
                'name' => 'currency_symbol',
                'value' => '$',
            ]);
            Setting::create([
                'name' => 'time_zone',
                'value' => 'Asia/Dhaka',
            ]);

            Setting::create([
                'name' => 'light_logo',
                'value' => "uploads/backend/uploads/settings/light_logo2023-04-13-m3zlgbczk1iu-original.png",
            ]);
            Setting::create([
                'name' => 'dark_logo',
                'value' => "uploads/backend/uploads/settings/dark_logo2023-04-13-6fftzbk9pefm-original.png",
            ]);
            Setting::create([
                'name' => 'favicon',
                'value' => "uploads/backend/uploads/settings/favicon2023-04-13-ukjghc1c6zf3-original.png",
            ]);

            // date format
            Setting::create([
                'name' => 'date_format',
                'value' => 'd-m-Y',
            ]);

            //author
            Setting::create([
                'name' => 'author',
                'value' => 'Onest Tech',
            ]);

            Setting::create([
                'name' => 'meta_keyword',
                'value' => 'lms, academy, eclass, elearning, education, online course,  learning management system, live class, live meeting, lms, online education, online teaching, udemy, quiz, school, skillshare',
            ]);

            Setting::create([
                'name' => 'meta_description',
                'value' => 'Onest LMS - Learning Management System web application. web-based responsive application that includes an online learning management system, as well as admin, instructor panel and student panel. This is a completely ready-to-use learning management system.',
            ]);

            Setting::create([
                'name' => 'email_address',
                'value' => 'info@onesttech.com',
            ]);

            Setting::create([
                'name' => 'phone_number',
                'value' => '+880 1711 111 111',
            ]);

            Setting::create([
                'name' => 'office_address',
                'value' => 'Dhaka, Bangladesh',
            ]);

            Setting::create([
                'name' => 'office_hours',
                'value' => 'Monday - Friday : 10:00am to 6:00pm',
            ]);

            Setting::create([
                'name' => 'application_map',
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3176328.0190763366!2d-108.19558402634385!3d38.972343352127425!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x874014749b1856b7%3A0xc75483314990a7ff!2sColorado%2C%20USA!5e0!3m2!1sen!2sbd!4v1682586333488!5m2!1sen!2sbd',
            ]);

            Setting::create([
                'name' => 'facebook_setup',
                'value' => 'off',
            ]);

            Setting::create([
                'name' => 'facebook_client_id',
                'value' => '',
            ]);

            Setting::create([
                'name' => 'facebook_client_secret',
                'value' => '',
            ]);

            Setting::create([
                'name' => 'google_setup',
                'value' => 'off',
            ]);

            Setting::create([
                'name' => 'google_client_id',
                'value' => '',
            ]);

            Setting::create([
                'name' => 'google_client_secret',
                'value' => '',
            ]);

            Setting::create([
                'name' => 'github_setup',
                'value' => 'off',
            ]);

            Setting::create([
                'name' => 'github_client_id',
                'value' => '',
            ]);

            Setting::create([
                'name' => 'github_client_secret',
                'value' => '',
            ]);

            Setting::create([
                'name' => 'linkedin_setup',
                'value' => 'off',
            ]);

            Setting::create([
                'name' => 'linkedin_client_id',
                'value' => '',
            ]);

            Setting::create([
                'name' => 'linkedin_client_secret',
                'value' => '',
            ]);

            Setting::create([
                'name' => 'payment_getaway',
                'value' => 1,
            ]);

            Setting::create([
                'name' => 'instructor_otp_verification',
                'value' => 1,
            ]);

            Setting::create([
                'name' => 'student_otp_verification',
                'value' => 1,
            ]);

        } catch (\Exception $e) {
        }
        //End Home page

    }
}
