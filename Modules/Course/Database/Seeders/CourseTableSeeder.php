<?php

namespace Modules\Course\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Session;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (@Session()->get('temp_data') || env('APP_TEST')) {

            try {
                // course category
                $courseCategory = [
                    [
                        'title' => 'Software Development',
                        'slug' => 'software-development',
                        'parent_id' => null,
                        'user_id' => 1,
                        'status_id' => 1,
                        'is_popular' => 1,
                    ],
                    [
                        'title' => 'Website Development',
                        'slug' => 'website-development',
                        'parent_id' => 1,
                        'user_id' => 1,
                        'status_id' => 1,
                        'is_popular' => 1,
                    ],
                    [
                        'title' => 'Mobile Development',
                        'slug' => 'mobile-development',
                        'parent_id' => 1,
                        'user_id' => 1,
                        'status_id' => 1,
                        'is_popular' => 1,
                    ],
                    [
                        'title' => 'Desktop Development',
                        'slug' => 'desktop-development',
                        'parent_id' => null,
                        'user_id' => 1,
                        'status_id' => 1,
                        'is_popular' => 1,
                    ],
                    [
                        'title' => 'Game Development',
                        'slug' => 'game-development',
                        'parent_id' => 4,
                        'user_id' => 1,
                        'status_id' => 1,
                        'is_popular' => 1,
                    ],
                    [
                        'title' => 'Search Engine Optimization',
                        'slug' => 'search-engine-optimization',
                        'parent_id' => 4,
                        'user_id' => 1,
                        'status_id' => 1,
                        'is_popular' => 1,
                    ],
                ];
                foreach ($courseCategory as $key => $value) {
                    \Modules\Course\Entities\CourseCategory::create($value);
                }

                // course
                $course = [
                    [
                        'title' => 'Build a full stack NFT Marketplace using Solidity & Next js',
                        'slug' => 'build-a-full-stack-nft-marketplace-using-solidity-next-js',
                        'short_description' => 'Learn how to build a full stack NFT marketplace using Solidity, Next js, React js, Web3 js, and IPFS',
                        'description' => 'Learn how to build a full stack NFT marketplace using Solidity, Next js, React js, Web3 js, and IPFS',
                        'course_category_id' => 1,
                        'course_overview_type' => 15,
                        'video_url' => 'https://youtu.be/3l6Q4QL-j4Q',
                        'status_id' => 1,
                        'price' => 100,
                        'course_duration' => 260,
                        'point' => 600,
                        'thumbnail' => 1,
                        'created_by' => 5,
                        'updated_by' => 1,

                        'rating' => 0,
                        'total_sales' => 0,
                        'is_free' => 0, //1 = free
                        'is_discount' => 11, // 11 = discount course
                        'discount_price' => 20,
                    ],
                    [
                        'title' => 'The Complete ChatGPT Web Development Code Along - Javascript',
                        'slug' => 'the-complete-chatgpt-web-development-code-along-javascript',
                        'short_description' => 'Learn to code with ChatGPT and 10x your Web Development Productivity - Build a MERN Project from scratch with ChatGPT',
                        'description' => 'Learn to code with ChatGPT and 10x your Web Development Productivity - Build a MERN Project from scratch with ChatGPT',
                        'course_category_id' => 2,
                        'course_overview_type' => 15,
                        'video_url' => 'https://youtu.be/3l6Q4QL-j4Q',
                        'status_id' => 1,
                        'course_duration' => 160,
                        'point' => 1000,
                        'thumbnail' => 2,
                        'created_by' => 5,
                        'updated_by' => 1,
                        'rating' => 0,
                        'total_sales' => 0,
                        'is_free' => 1, //1 = free
                        'is_discount' => 10, // 11 = discount course
                    ],
                    [
                        'title' => 'The Complete 2023 Web Development Bootcamp',
                        'slug' => 'the-complete-2023-web-development-bootcamp',
                        'short_description' => 'Become a Full-Stack Web Developer with just ONE course. HTML, CSS, Javascript, Node, React, MongoDB, Web3 and DApps',
                        'description' => 'Become a Full-Stack Web Developer with just ONE course. HTML, CSS, Javascript, Node, React, MongoDB, Web3 and DApps',
                        'course_category_id' => 3,
                        'course_overview_type' => 15,
                        'video_url' => 'https://youtu.be/3l6Q4QL-j4Q',
                        'status_id' => 1,
                        'created_by' => 5,
                        'price' => 160,
                        'updated_by' => 1,
                        'rating' => 0,
                        'thumbnail' => 3,
                        'total_sales' => 0,
                        'is_free' => 0, //1 = free
                        'is_discount' => 11, // 11 = discount course
                        'discount_price' => 60,

                    ],
                    [
                        'title' => 'The Web Developer Bootcamp 2023',
                        'slug' => 'the-web-developer-bootcamp-2023',
                        'short_description' => 'The only course you need to learn web development - HTML, CSS, JS, Node, and More!',
                        'description' => 'The only course you need to learn web development - HTML, CSS, JS, Node, and More!',
                        'course_category_id' => 4,
                        'video_url' => 'https://youtu.be/3l6Q4QL-j4Q',
                        'status_id' => 1,
                        'created_by' => 5,
                        'course_duration' => 360,
                        'point' => 1000,
                        'thumbnail' => 4,
                        'price' => 120,
                        'updated_by' => 1,
                    ],
                ];
                foreach ($course as $key => $value) {
                    \Modules\Course\Entities\Course::create($value);
                }

                $time = strtotime("+7 day", time());
                $time = date('Y-m-d H:i:s', $time);
                // course assignment
                $course_assignment = [
                    [
                        'title' => 'Assignment 1',
                        'deadline' => $time,
                        'marks' => 100,
                        'pass_marks' => 40,
                        'point' => 100,
                        'details' => 'Assignment 1',
                        'course_id' => 1,
                        'status_id' => 22,
                        'created_by' => 5,
                    ],
                    [
                        'title' => 'Assignment 2',
                        'deadline' => $time,
                        'marks' => 100,
                        'pass_marks' => 40,
                        'point' => 100,
                        'details' => 'Assignment 2',
                        'course_id' => 1,
                        'status_id' => 22,
                        'created_by' => 5,
                    ],
                    [
                        'title' => 'Assignment 3',
                        'deadline' => $time,
                        'marks' => 100,
                        'pass_marks' => 40,
                        'point' => 100,
                        'details' => 'Assignment 3',
                        'course_id' => 1,
                        'status_id' => 21,
                        'created_by' => 5,
                    ],
                ];

                foreach ($course_assignment as $key => $value) {
                    \Modules\Course\Entities\Assignment::create($value);
                }

                // Create noticeboard
                $noticeboard = [
                    [
                        'title' => 'Noticeboard 1',
                        'description' => 'Noticeboard 1',
                        'course_id' => 1,
                        'status_id' => 1,
                        'created_by' => 5,
                    ],
                    [
                        'title' => 'Noticeboard 2',
                        'description' => 'Noticeboard 2',
                        'course_id' => 1,
                        'status_id' => 1,
                        'created_by' => 5,
                    ],
                    [
                        'title' => 'Noticeboard 3',
                        'description' => 'Noticeboard 3',
                        'course_id' => 1,
                        'status_id' => 1,
                        'created_by' => 5,
                    ],
                    [
                        'title' => 'Noticeboard 4',
                        'description' => 'Noticeboard 4',
                        'course_id' => 1,
                        'status_id' => 1,
                        'created_by' => 5,
                    ],
                ];

                foreach ($noticeboard as $key => $value) {
                    \Modules\Course\Entities\NoticeBoard::create($value);
                }

                // section
                $section = [
                    [
                        'title' => 'Section 1',
                        'course_id' => 1,
                        'status_id' => 1,
                        'order' => 1,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                    [
                        'title' => 'Section 2',
                        'course_id' => 1,
                        'status_id' => 1,
                        'order' => 2,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                    [
                        'title' => 'Section 3',
                        'course_id' => 1,
                        'status_id' => 1,
                        'order' => 3,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                    [
                        'title' => 'Section 4',
                        'course_id' => 1,
                        'status_id' => 1,
                        'order' => 4,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                ];

                foreach ($section as $key => $value) {
                    \Modules\Course\Entities\Section::create($value);
                }

                // lesson
                $lesson = [
                    [
                        'title' => 'Lesson 1',
                        'content' => 'Lesson 1',
                        'section_id' => 1,
                        'course_id' => 1,
                        'lesson_type' => 'Youtube',
                        'video_url' => 'https://youtu.be/3l6Q4QL-j4Q',
                        'lesson_text' => 'This is lesson text',
                        'order' => 1,
                        'duration' => 120,
                        'point' => 50,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                    [
                        'title' => 'Quiz 1',
                        'is_quiz' => 1,
                        'instruction' => 'Quiz 1',
                        'course_id' => 1,
                        'section_id' => 1,
                        'marks' => 100,
                        'pass_marks' => 40,
                        'duration' => 60,
                        'point' => 100,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                    [
                        'title' => 'Lesson 2',
                        'content' => 'Lesson 2',
                        'section_id' => 2,
                        'course_id' => 1,
                        'lesson_type' => 'Vimeo',
                        'video_url' => 'https://vimeo.com/24456787',
                        'duration' => 160,
                        'point' => 50,
                        'order' => 2,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                    [
                        'title' => 'Lesson 3',
                        'content' => 'Lesson 3',
                        'section_id' => 3,
                        'course_id' => 1,
                        'lesson_type' => 'Text',
                        'lesson_text' => 'This is lesson text',
                        'duration' => 40,
                        'point' => 50,
                        'order' => 3,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                    [
                        'title' => 'Lesson 4',
                        'content' => 'Lesson 4',
                        'section_id' => 4,
                        'course_id' => 1,
                        'lesson_type' => 'Text',
                        'lesson_text' => 'This is lesson text',
                        'duration' => 220,
                        'point' => 50,
                        'order' => 4,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                    [
                        'title' => 'Quiz 1',
                        'is_quiz' => 1,
                        'instruction' => 'Quiz 1',
                        'course_id' => 1,
                        'section_id' => 1,
                        'marks' => 100,
                        'pass_marks' => 40,
                        'duration' => 60,
                        'point' => 100,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                ];

                foreach ($lesson as $key => $value) {
                    \Modules\Course\Entities\Lesson::create($value);
                }

                // question
                $question = [
                    [
                        'title' => 'Question 1',
                        'quiz_id' => 2, 'created_by' => 5,
                        'course_id' => 1,
                        'type' => 0,
                        'total_options' => 4,
                        'options' => '["Option 1","Option 2","Option 3","Option 4"]',
                        'answer' => '["Option 1"]',
                        'order' => 1,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                    [
                        'title' => 'Question 2',
                        'quiz_id' => 2,
                        'course_id' => 1,
                        'type' => 1,
                        'total_options' => 4,
                        'options' => '["Option 1","Option 2","Option 3","Option 4"]',
                        'answer' => '["Option 1","Option 2"]',
                        'order' => 1,
                        'created_by' => 5,
                        'updated_by' => 1,
                    ],
                ];

                foreach ($question as $key => $value) {
                    \Modules\Course\Entities\Question::create($value);
                }
            } catch (\Exception $e) {

                dd($e);
            }
        }
    }
}
