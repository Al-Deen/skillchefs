<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            // all for api
            [
                'title' => 'Slider',
                'snake_title' => 'slider',
                'order' => 1,
                'type' => 'api',
            ],
            [
                'title' => 'Categories',
                'snake_title' => 'Categories',
                'order' => 2,
                'type' => 'api',
            ],
            [
                'title' => 'Featured Courses',
                'snake_title' => 'featured_courses',
                'order' => 3,
                'type' => 'api',
            ],
            [
                'title' => 'Latest Courses',
                'snake_title' => 'latest_courses',
                'order' => 4,
                'type' => 'api',
            ],
            [
                'title' => 'Best Rated Course',
                'snake_title' => 'best_rated_courses',
                'order' => 5,
                'type' => 'api',
            ],
            [
                'title' => 'Best Selling Course',
                'snake_title' => 'best_selling_courses',
                'order' => 6,
                'type' => 'api',
            ],
            [
                'title' => 'Free Courses',
                'snake_title' => 'free_courses',
                'order' => 7,
                'type' => 'api',
            ],
            [
                'title' => 'Discounted Courses',
                'snake_title' => 'discount_courses',
                'order' => 8,
                'type' => 'api',
            ],
            // end for api

            // all for web
            [
                'title' => 'Slider', // 1
                'snake_title' => 'slider',
                'order' => 1,
                'type' => 'web',
            ],

            [
                'title' => 'Popular Category', // 3
                'snake_title' => 'popular_category',
                'order' => 2,
                'color' => '#fbfaf7',
                'type' => 'web',
            ],

            [
                'title' => 'Featured Courses', // 2
                'snake_title' => 'featured_courses',
                'order' => 3,
                'type' => 'web',
            ],

            [
                'title' => 'Latest Courses', // 4
                'snake_title' => 'latest_courses',
                'order' => 4,
                'color' => '#fbfaf7',
                'type' => 'web',
            ],
            [
                'title' => 'Best Rated Course', // 5
                'snake_title' => 'best_rated_courses',
                'order' => 5,
                'type' => 'web',
            ],
            [
                'title' => 'Most Popular Course', // 6
                'snake_title' => 'most_popular_courses',
                'order' => 6,
                'color' => '#fbfaf7',
                'type' => 'web',
            ],
            [
                'title' => 'Discounted Courses', // 7
                'snake_title' => 'discount_courses',
                'order' => 7,
                'type' => 'web',
            ],
            [
                'title' => 'Events', // 7
                'snake_title' => 'event',
                'order' => 8,
                'type' => 'web',
            ],
            [
                'title' => 'Become An Instructor', // 8
                'snake_title' => 'become_an_instructor',
                'order' => 9,
                'color' => '#fbfaf7',
                'type' => 'web',
            ],
            [
                'title' => 'Testimonials', // 9
                'snake_title' => 'testimonials',
                'order' => 10,
                'type' => 'web',
            ],
            [
                'title' => 'Our Recent Blogs', // 9
                'snake_title' => 'blogs',
                'order' => 11,
                'color' => '#fbfaf7',
                'type' => 'web',
            ],

            [
                'title' => 'Trusted By Thousands', // 10
                'snake_title' => 'brands',
                'order' => 12,
                'type' => 'web',
            ],
        ];

        foreach ($data as $key => $value) {
            \Modules\CMS\Entities\AppHomeSection::create($value);
        }

        // footer menus
        $routes1 = [
            [
                'name' => 'Organization',
                'link' => route('frontend.organization.create'),
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Latest Courses'),
                'link' => route('courses') . '?sort=latest',
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Certificate_Track'),
                'link' => route('front.certificate'),
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Best Rated Courses'),
                'link' => route('courses') . '?sort=best_rated',
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Our Recent Blogs'),
                'link' => route('blogs'),
                'status_id' => 1,
            ],
        ];
        $routes2 = [
            [
                'name' => ___('frontend.About Us'),
                'is_page' => "1",
                "page_id" => "3",
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Contact Us'),
                'link' => route('frontend.contact_us'),
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Privacy Policy'),
                'link' => route('frontend.privacy_policy'),
                'is_page' => "1",
                "page_id" => "1",
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Terms & Conditions'),
                'link' => route('frontend.terms_and_conditions'),
                'is_page' => "1",
                "page_id" => "2",
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Events'),
                'link' => route('event.home.event.list'),
                'status_id' => 1,
            ],
        ];
        if (@Session()->get('temp_data') || env('APP_TEST')) {
            $routes3 = [
                [
                    'name' => ___('frontend.Web Development'),
                    'link' => route('frontend.category') . '?q=web-development',
                    'status_id' => 1,
                ],
                [
                    'name' => ___('frontend.Mobile Development'),
                    'link' => route('frontend.category') . '?q=mobile-development',
                    'status_id' => 1,
                ],
                [
                    'name' => ___('frontend.Game Development'),
                    'link' => route('frontend.category') . '?q=game-development',
                    'status_id' => 1,
                ],
                [
                    'name' => ___('frontend.Seo'),
                    'link' => route('frontend.category') . '?q=seo',
                    'status_id' => 1,
                ],
            ];
        } else {
            $routes3 = [];
        }
        $footerMenus = [
            [
                'name' => ___('frontend.Pages'),
                'column' => 1,
                'links' => json_encode($routes1),
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Custom Links'),
                'column' => 2,
                'links' => json_encode($routes2),
                'status_id' => 1,
            ],
            [
                'name' => ___('frontend.Top Categories'),
                'column' => 3,
                'links' => json_encode($routes3),
                'status_id' => 1,
            ],
        ];

        foreach ($footerMenus as $key => $value) {
            \Modules\CMS\Entities\FooterMenu::create($value);
        }
        if (@Session()->get('temp_data') || env('APP_TEST')) {
            // testimonial
            $testimonials = [
                [
                    'name' => 'John Doe',
                    'designation' => 'CEO',
                    'content' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                    'rating' => 5,
                    'image_id' => 23,
                ],
                [
                    'name' => 'Cristina Parker',
                    'designation' => 'CEO',
                    'content' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                    'rating' => 5,
                    'image_id' => 24,
                ],
                [
                    'name' => 'Rhea Smith',
                    'designation' => 'CEO',
                    'content' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                    'rating' => 5,
                    'image_id' => 25,
                ],
                [
                    'name' => 'Carla Houston',
                    'designation' => 'CEO',
                    'content' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                    'rating' => 5,
                    'image_id' => 26,
                ],
            ];
            try {
                foreach ($testimonials as $key => $value) {
                    \Modules\CMS\Entities\Testimonial::create($value);
                }
            } catch (\Throwable $th) {
                Log::error($th);
            }
        }

        // gallery

        $galleries = [
            ___('frontend.Sign_In'),
            ___('frontend.Sign_Up'),
            ___('frontend.Forgot_Password'),
            ___('frontend.Reset_Password'),
            ___('frontend.Verify_Email'),
            ___('frontend.Tracking_Certificate'),
            ___('frontend.Become_An_Instructor'),
            ___('frontend.Home_Loader'),
            ___('common.400_database_connection_error'),
            ___('common.403_forbidden'),
            ___('common.404_page_not_found'),
            ___('common.405_method_not_allowed'),
            ___('common.500_something_wrong'),
        ];

        foreach ($galleries as $key => $value) {
            \Modules\CMS\Entities\ImageGallery::create([
                'title' => $value,
                'slug' => Str::slug($value),
                'status_id' => 1,
            ]);
        }

    }
}
