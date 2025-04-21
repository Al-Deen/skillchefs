<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            //for staff
            'users' => ['read' => 'user_read', 'create' => 'user_create', 'update' => 'user_update', 'delete' => 'user_delete'],
            'roles' => ['read' => 'role_read', 'create' => 'role_create', 'update' => 'role_update', 'delete' => 'role_delete'],
            'language' => ['read' => 'language_read', 'create' => 'language_create', 'update' => 'language_update', 'update terms' => 'language_update_terms', 'delete' => 'language_delete'],
            // ai_support
            'ai_support' => ['ai_support' => 'ai_support', 'ai_support_find' => 'ai_support_find'],
            // course category
            'course_category' => ['read' => 'course_category_read', 'create' => 'course_category_create', 'store' => 'course_category_store', 'update' => 'course_category_update', 'delete' => 'course_category_delete', 'popular_course_category_list' => 'popular_course_category_list',
                'popular_course_category_added' => 'popular_course_category_added', 'popular_course_category_deleted' => 'popular_course_category_deleted'],
            // course  category
            // start course
            'course' => ['read' => 'course_read', 'create' => 'course_create', 'store' => 'course_store', 'update' => 'course_update', 'delete' => 'course_delete'],
            'course_assignment' => ['assignment_list' => 'course_assignment_list', 'assignment_create' => 'course_assignment_create', 'assignment_store' => 'course_assignment_store',
                'assignment_update' => 'course_assignment_update', 'assignment_delete' => 'course_assignment_delete', 'assignment_submission_list' => 'course_assignment_submission_list', 'assignment_submission_view' => 'course_assignment_submission_view'],
            'course_noticeboard' => ['noticeboard_list' => 'course_noticeboard_list', 'noticeboard_create' => 'course_noticeboard_create', 'noticeboard_store' => 'course_noticeboard_store', 'noticeboard_update' => 'course_noticeboard_update', 'noticeboard_delete' => 'course_noticeboard_delete'],
            'course_curriculum' => ['course_curriculum' => 'course_curriculum', 'course_curriculum_create' => 'course_curriculum_create', 'course_curriculum_store' => 'course_curriculum_store', 'course_curriculum_update' => 'course_curriculum_update', 'course_curriculum_delete' => 'course_curriculum_delete'],
            'course_lesson' => ['course_lesson' => 'course_lesson', 'course_lesson_create' => 'course_lesson_create', 'course_lesson_store' => 'course_lesson_store', 'course_lesson_update' => 'course_lesson_update', 'course_lesson_delete' => 'course_lesson_delete'],
            'course_quiz' => ['course_quiz' => 'course_quiz_list', 'course_quiz_create' => 'course_quiz_create', 'course_quiz_store' => 'course_quiz_store', 'course_quiz_update' => 'course_quiz_update', 'course_quiz_delete' => 'course_quiz_delete', 'quiz_submission_list' => 'course_quiz_submission_list', 'quiz_submission_view' => 'course_quiz_submission_view'],
            'course_question' => ['course_question' => 'course_question_list', 'course_question_create' => 'course_question_create', 'course_question_store' => 'course_question_store', 'course_question_update' => 'course_question_update', 'course_question_delete' => 'course_question_delete'],
            // end course

            // enroll
            'enroll' => ['list' => 'enroll_list', 'enroll_invoice' => 'enroll_invoice'],
            'certificate' => ['list' => 'certificate_list', 'view' => 'certificate_view', 'download' => 'certificate_download'],
            'certificate_template' => ['read' => 'certificate_template_read', 'create' => 'certificate_template_create', 'store' => 'certificate_template_store', 'update' => 'certificate_template_update', 'delete' => 'certificate_template_delete'],

            //instructor
            'instructor' => ['read' => 'instructor_list', 'instructor_request_list' => 'instructor_request_list', 'instructor_view' => 'instructor_view', 'instructor_approve' => 'instructor_approve', 'instructor_suspend' => 'instructor_suspend',
                'instructor_suspend_list' => 'instructor_suspend_list', 'instructor_re_activate' => 'instructor_re_activate', 'create' => 'instructor_create', 'store' => 'instructor_store', 'update' => 'instructor_update', 'instructor_login' => 'instructor_login',
                'instructor_add_institute' => 'instructor_add_institute', 'instructor_store_institute' => 'instructor_store_institute', 'instructor_update_institute' => 'instructor_update_institute', 'instructor_delete_institute' => 'instructor_delete_institute',
                'instructor_add_experience' => 'instructor_add_experience', 'instructor_store_experience' => 'instructor_store_experience', 'instructor_update_experience' => 'instructor_update_experience', 'instructor_delete_experience' => 'instructor_delete_experience',
                'instructor_add_skill' => 'instructor_add_skill', 'instructor_store_skill' => 'instructor_store_skill'],

            // student
            'student' => ['read' => 'student_list', 'student_suspend' => 'student_suspend', 'student_re_activate' => 'student_re_activate', 'create' => 'student_create', 'store' => 'student_store', 'update' => 'student_update', 'student_login' => 'student_login',
                'student_add_institute' => 'student_add_institute', 'student_store_institute' => 'student_store_institute', 'student_update_institute' => 'student_update_institute', 'student_delete_institute' => 'student_delete_institute',
                'student_add_experience' => 'student_add_experience', 'student_store_experience' => 'student_store_experience', 'student_update_experience' => 'student_update_experience', 'student_delete_experience' => 'student_delete_experience',
                'student_add_skill' => 'student_add_skill', 'student_store_skill' => 'student_store_skill'],

            // review
            'review' => ['read' => 'review_list', 'review_view' => 'review_view'],

            // payouts
            'payouts' => ['instructor_payout_list' => 'instructor_payout_list', 'instructor_payout_request_list' => 'instructor_payout_request_list', 'instructor_unpaid_payout_list' => 'instructor_unpaid_payout_list', 'instructor_rejected_payout_list' => 'instructor_rejected_payout_list',
                'instructor_payout_details' => 'instructor_payout_details', 'instructor_payout_request_approve' => 'instructor_payout_request_approve', 'instructor_payout_request_reject' => 'instructor_payout_request_reject',
                'instructor_make_payout' => 'instructor_make_payout'],

            // account
            'account' => ['read' => 'account_list', 'create' => 'account_create', 'store' => 'account_store', 'update' => 'account_update', 'delete' => 'account_delete', 'income_list' => 'income_list', 'expense_list' => 'expense_list', 'transaction_list' => 'transaction_list'],

            // featured course
            'featured_course' => ['read' => 'featured_course_list', 'create' => 'featured_course_create', 'store' => 'featured_course_store', 'update' => 'featured_course_update', 'delete' => 'featured_course_delete'],

            // discount course
            'discount_course' => ['read' => 'discount_course_list', 'create' => 'discount_course_create', 'store' => 'discount_course_store', 'update' => 'discount_course_update', 'delete' => 'discount_course_delete'],

            // image_gallery
            'image_gallery' => ['read' => 'image_gallery_read', 'image_gallery_update' => 'image_gallery_update'],

            //reports
            'reports' => ['report_student_engagement' => 'report_student_engagement', 'report_student_engagement_export' => 'report_student_engagement_export',
                'report_instructor_engagement' => 'report_instructor_engagement', 'report_instructor_engagement_export' => 'report_instructor_engagement_export',
                'report_purchase_history' => 'report_purchase_history', 'report_purchase_history_export' => 'report_purchase_history_export',
                'report_course_completion' => 'report_course_completion', 'report_course_completion_export' => 'report_course_completion_export',
                'report_student_performance' => 'report_student_performance', 'report_student_performance_export' => 'report_student_performance_export',
                'report_admin_transaction' => 'report_admin_transaction', 'report_admin_transaction_export' => 'report_admin_transaction_export'],

            // testimonial
            'testimonial' => ['read' => 'testimonial_list', 'create' => 'testimonial_create', 'store' => 'testimonial_store', 'update' => 'testimonial_update', 'delete' => 'testimonial_delete'],

            "home_section_settings" => ['read' => 'home_section_settings_read', 'create' => 'home_section_settings_create', 'store' => 'home_section_settings_store',
                'update' => 'home_section_settings_update', 'delete' => 'home_section_settings_delete'],
            // start footer menu
            'footer_menu' => ['read' => 'footer_menu_read', 'create' => 'footer_menu_create', 'store' => 'footer_menu_store', 'update' => 'footer_menu_update', 'delete' => 'footer_menu_delete'],
            // end footer menu
            // payment method
            'payment_method' => ['read' => 'payment_method_read', 'update' => 'payment_method_update', 'delete' => 'payment_method_delete'],
            // payment method
            'general settings' => ['read' => 'general_settings_read', 'update' => 'general_settings_update'],
            'storage settings' => ['read' => 'storage_settings_read', 'update' => 'storage_settings_update'],
            'email settings' => ['read' => 'email_settings_read', 'update' => 'email_settings_update'],
            'seo settings' => ['read' => 'seo_settings_read', 'update' => 'seo_settings_update'],
            // Social Login
            'social login settings' => ['read' => 'social_login_settings_read', 'update' => 'social_login_settings_update'],

            // Blog category
            'blog_category' => ['read' => 'blog_category_read', 'create' => 'blog_category_create', 'store' => 'blog_category_store', 'update' => 'blog_category_update', 'delete' => 'blog_category_delete'],
            'blog' => ['read' => 'blog_read', 'create' => 'blog_create', 'store' => 'blog_store', 'update' => 'blog_update', 'delete' => 'blog_delete'],
            // Blog  category

            //Home Slider
            'slider' => ['read' => 'slider_read', 'create' => 'slider_create', 'store' => 'slider_store', 'update' => 'slider_update', 'delete' => 'slider_delete'],
            //Home Slider

            //CMS page
            'page' => ['read' => 'page_read', 'create' => 'page_create', 'store' => 'page_store', 'update' => 'page_update', 'delete' => 'page_delete'],
            //CMS page

            //Home Brand
            'brand' => ['read' => 'brand_read', 'create' => 'brand_create', 'store' => 'brand_store', 'update' => 'brand_update', 'delete' => 'brand_delete'],
            //Home Brand

            // From List From Contact Page
            'contact' => ['read' => 'contact_read'],

            // Addon Page
            'addon' => ['read' => 'addon_list', 'read' => 'addon_read', 'create' => 'addon_create', 'store' => 'addon_store', 'update' => 'addon_update'],

            // Forum
            'forum_category' => ['read' => 'forum_category_read', 'create' => 'forum_category_create', 'store' => 'forum_category_store', 'update' => 'forum_category_update', 'delete' => 'forum_category_delete'],
            'forum' => ['read' => 'forum_read', 'create' => 'forum_create', 'store' => 'forum_store', 'update' => 'forum_update', 'delete' => 'forum_delete', 'forum_featured_manage' => 'forum_featured_manage', 'forum_status_manage' => 'forum_status_manage'],
            // two_fa
            'two_fa' => ['read' => '2fa_setting', 'update' => '2fa_setting_update'],
        ];

        foreach ($attributes as $key => $attribute) {
            $permission = new Permission();
            $permission->attribute = $key;
            $permission->keywords = $attribute;
            $permission->save();
        }
    }
}
