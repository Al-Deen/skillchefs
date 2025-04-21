<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\CMS\Interfaces\HomeSectionInterface;

class PageController extends Controller
{
    use ApiReturnFormatTrait;

    protected $homeSection;

    public function __construct(HomeSectionInterface $homeSectionInterface)
    {
        $this->homeSection = $homeSectionInterface;
    }

    public function page($slug)
    {
        try {
            $data['page'] = \Modules\Page\Entities\Page::where('slug', $slug)->active()->first();
            if ($data['page']) {
                $data['title'] = $data['page']->title; // title
                $sections = $this->homeSection->model()->whereIn('id', json_decode($data['page']->section)??[] )->get();
                $data['section'] = $sections;
                return view('frontend.page.index', compact('data'));
            } else {
                return redirect()->back()->with('danger', ___('alert.Page_not_found'));
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function index()
    {
        try {
            $data['title'] = ___('frontend.Instructor'); // title

            return view('frontend.instructor.instractors', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function details()
    {
        try {
            $data['title'] = ___('frontend.Instructor Details'); // title

            return view('frontend.instructor.instructor_details', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    // privacyPolicy page start
    public function privacyPolicy()
    {
        try {
            $data['title'] = ___('frontend.Privacy Policy'); // title
            return view('frontend.page.privacy_policy', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
    // privacyPolicy page end

    // termsConditions page start
    public function termsConditions()
    {
        try {
            $data['title'] = ___('frontend.Terms And Conditions'); // title
            return view('frontend.page.terms_and_conditions', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }
    // termsConditions page end

}
