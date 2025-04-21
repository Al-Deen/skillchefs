<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'phone' => '01811000000',
            'email' => 'superadmin@onest.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'remember_token' => Str::random(10),
            'role_id' => 1,
            'date_of_birth' => '2022-09-07',
            'status_id' => 4,
            'designation_id' => rand(1, 5),
            'permissions' => [
                'user_read',
                'user_create',
                'user_update',
                'user_delete',
                'role_read',
                'role_create',
                'role_update',
                'role_delete',

                //ai_support_find
                'ai_support',
                'ai_support_find',
                // course category
                'course_category_read',
                'course_category_store',
                'course_category_create',
                'course_category_update',
                'course_category_delete',
                'popular_course_category_list',
                'popular_course_category_added',
                'popular_course_category_deleted',
                // course category
                // start course
                'course_read',
                'course_store',
                'course_create',
                'course_update',
                'course_delete',
                'course_assignment_list',
                'course_assignment_create',
                'course_assignment_store',
                'course_assignment_update',
                'course_assignment_delete',
                'course_assignment_submission_list',
                'course_assignment_submission_view',

                'course_noticeboard_list',
                'course_noticeboard_create',
                'course_noticeboard_store',
                'course_noticeboard_update',
                'course_noticeboard_delete',
                'course_announcement_list',
                'course_curriculum',
                'course_curriculum_create',
                'course_curriculum_store',
                'course_curriculum_update',
                'course_curriculum_delete',
                'course_lesson',
                'course_lesson_create',
                'course_lesson_store',
                'course_lesson_update',
                'course_lesson_delete',

                'course_quiz_list',
                'course_quiz_create',
                'course_quiz_store',
                'course_quiz_update',
                'course_quiz_delete',
                'course_quiz_submission_list',
                'course_quiz_submission_view',

                'course_question_list',
                'course_question_create',
                'course_question_store',
                'course_question_update',
                'course_question_delete',

                'enroll_list',
                'enroll_invoice',

                'certificate_list',
                'certificate_view',
                'certificate_download',
                'certificate_template_list',
                'certificate_template_create',
                'certificate_template_store',
                'certificate_template_update',
                'certificate_template_edit',
                'certificate_template_delete',

                'instructor_list',
                'instructor_request_list',
                'instructor_view',
                'instructor_approve',
                'instructor_suspend',
                'instructor_suspend_list',
                'instructor_re_activate',
                'instructor_create',
                'instructor_store',
                'instructor_update',
                'instructor_login',
                'instructor_add_institute',
                'instructor_store_institute',
                'instructor_update_institute',
                'instructor_delete_institute',
                'instructor_add_experience',
                'instructor_store_experience',
                'instructor_update_experience',
                'instructor_delete_experience',
                'instructor_add_skill',
                'instructor_store_skill',

                'student_list',
                'student_suspend',
                'student_re_activate',
                'student_create',
                'student_store',
                'student_update',
                'student_login',
                'student_add_institute',
                'student_store_institute',
                'student_update_institute',
                'student_delete_institute',
                'student_add_experience',
                'student_store_experience',
                'student_update_experience',
                'student_delete_experience',
                'student_add_skill',
                'student_store_skill',

                'certificate_template_read',
                'certificate_template_create',
                'certificate_template_update',
                'certificate_template_delete',

                'review_list',
                'review_view',

                'instructor_payout_list',
                'instructor_payout_request_list',
                'instructor_unpaid_payout_list',
                'instructor_rejected_payout_list',
                'instructor_payout_details',
                'instructor_payout_request_approve',
                'instructor_payout_request_reject',
                'instructor_make_payout',
                'account_list',
                'account_create',
                'account_store',
                'account_update',
                'account_delete',
                'income_list',
                'expense_list',
                'transaction_list',

                'contact_read',

                'featured_course_list',
                'featured_course_create',
                'featured_course_store',
                'featured_course_update',
                'featured_course_delete',

                'discount_course_list',
                'discount_course_create',
                'discount_course_store',
                'discount_course_update',
                'discount_course_delete',

                'image_gallery_read',
                'image_gallery_update',

                'report_student_engagement',
                'report_student_engagement_export',
                'report_instructor_engagement',
                'report_instructor_engagement_export',
                'report_purchase_history',
                'report_purchase_history_export',
                'report_course_completion',
                'report_course_completion_export',
                'report_student_performance',
                'report_student_performance_export',
                'report_admin_transaction',
                'report_admin_transaction_export',


                // end course
                'language_read',
                'language_create',
                'language_update',
                'language_update_terms',
                'language_delete',
                'general_settings_read',
                'general_settings_update',
                'storage_settings_read',
                'storage_settings_update',
                'email_settings_read',
                'email_settings_update',
                'seo_settings_read',
                'seo_settings_update',

                'social_login_settings_read',
                'social_login_settings_update',

                'testimonial_read',
                'testimonial_create',
                'testimonial_store',
                'testimonial_update',
                'testimonial_delete',

                // Blog category
                'blog_category_read',
                'blog_category_store',
                'blog_category_create',
                'blog_category_update',
                'blog_category_delete',
                // Blog category

                // Blog category
                'blog_read',
                'blog_store',
                'blog_create',
                'blog_update',
                'blog_delete',
                // Blog category

                // Slider
                'slider_read',
                'slider_store',
                'slider_create',
                'slider_update',
                'slider_delete',
                // Slider

                // Page
                'page_read',
                'page_store',
                'page_create',
                'page_update',
                'page_delete',
                // Page

                // Brands
                'brand_read',
                'brand_store',
                'brand_create',
                'brand_update',
                'brand_delete',
                // Brands

                //payment_method_read
                'payment_method_read',
                'payment_method_update',
                'payment_method_delete',

                // home_section_settings

                'home_section_settings_read',
                'home_section_settings_create',
                'home_section_settings_store',
                'home_section_settings_update',
                'home_section_settings_delete',

                // footer menu
                'footer_menu_read',
                'footer_menu_store',
                'footer_menu_create',
                'footer_menu_update',
                'footer_menu_delete',

                'addon_list',
                'addon_create',
                'addon_store',
                'addon_update',

                // Forum
                'forum_list',
                'forum_create',
                'forum_store',
                'forum_update',
                'forum_delete',
                'forum_status_manage',
                'forum_featured_manage',
                // Forum

                // Forum category
                'forum_category_read',
                'forum_category_store',
                'forum_category_create',
                'forum_category_update',
                'forum_category_delete',
                // Forum category

            ],
        ]);

        User::create([
            'name' => 'admin',
            'phone' => '01811000001',
            'email' => 'admin@onest.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'remember_token' => Str::random(10),
            'role_id' => 2,
            'status_id' => 4,
            'date_of_birth' => '2022-09-07',
            'designation_id' => rand(1, 5),
            'permissions' => [
                'user_read',
                'user_create',
                'user_update',
                'user_delete',
                'role_read',
                'role_create',
                'role_update',
                'role_delete',
                'language_read',
                'language_create',
                'language_update_terms',
                'general_settings_read',
                'general_settings_update',
                'storage_settings_read',
                'storage_settings_read',
                'recaptcha_settings_update',
                'email_settings_read',

                'social_login_settings_read',
                'social_login_settings_update',

                // Forum
                'forum_list',
                'forum_create',
                'forum_store',
                'forum_update',
                'forum_delete',
                'forum_status_manage',
                'forum_featured_manage',
                // Forum

                // Forum category
                'forum_category_read',
                'forum_category_store',
                'forum_category_create',
                'forum_category_update',
                'forum_category_delete',
                // Forum category
            ],
        ]);

        if (@Session()->get('temp_data') || env('APP_TEST')) {

            User::create([
                'name' => 'Anna Littlical',
                'phone' => '01811000002',
                'email' => 'manager@onest.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => Str::random(10),
                'role_id' => 3,
                'status_id' => 4,
                'date_of_birth' => '2022-09-07',
                'designation_id' => rand(1, 5),
                'permissions' => [
                    'user_read',
                    'user_create',
                    'role_read',
                    'language_read',
                    'language_create',
                    'general_settings_read',
                    'storage_settings_read',
                    'email_settings_read',

                    'social_login_settings_read',
                ],
            ]);

            for ($i = 1; $i <= 1; $i++) {

                $user = User::create([
                    'name' => 'student' . $i,
                    'username' => 'student' . $i,
                    'phone' => '134578978456' . $i,
                    'email' => 'student@onest.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('123456'),
                    'remember_token' => Str::random(10),
                    'role_id' => 4,
                    'date_of_birth' => '2022-09-07',
                    'status_id' => 4,
                    'designation_id' => rand(1, 5),
                    'permissions' => [
                        'user_read',
                        'role_read',
                        'language_read',
                    ],
                ]);
                $user->student()->create();
            }

            $instructor = User::create([
                'name' => 'instructor',
                'username' => 'instructor',
                'phone' => '13457897',
                'email' => 'instructor@onest.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => Str::random(10),
                'role_id' => 5,
                'date_of_birth' => '2022-09-07',
                'status_id' => 4,
                'designation_id' => 5,
            ]);
            $instructor->instructor()->create([
                "about_me" => "Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry's Standard Dummy Text Ever Since The 1500s, When An Unknown Printer Took A Galley Of Type And Scrambled It To Make A Type Specimen Book. It Has Survived Not Only Five Centuries, But Also The Leap Into Electronic Typesetting, Remaining Essentially Unchanged.

            It Was Popularised In The 1960s With The Release Of Letraset Sheets Containing Lorem Ipsum Passages, And More Recently With Desktop Publishing Software Like Aldus PageMaker Including Versions Of Lorem Ipsum.",
                "designation" => "Software engineer | Laravel | PHP",
                "address" => "Dhaka, Bangladesh",
                "country_id" => 19,
                "education" => json_decode('[{
                "name": "Lorem Ipsum is simply dummy text of the printing",
                "degree": "Lorem Ipsum",
                "current": 0,
                "program": "Lorem Ipsum",
                "end_date": "03/28/2018",
                "start_date": "03/01/2014",
                "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
                }
            ]'),
                "experience" => json_decode('[
                {
                    "name": "Maya Lucas",
                    "title": "Senior Software Engineer",
                    "current": 1,
                    "end_date": null,
                    "location": "Deserunt rerum volup",
                    "start_date": "03/28/2023",
                    "description": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                    "employee_type": "full_time",
                    "location_type": "hybrid"
                }
            ]'),
                "skills" => json_decode('[{ "value": "Nodejs"}, {"value": "laravel"},{"value": "php"},{"value": "javascript"},{"value": "css"},{ "value": "html"}, { "value": "vue.js"}, {"value": "react.js"}]'),
            ]);
        }

    }
}
