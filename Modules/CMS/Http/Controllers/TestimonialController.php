<?php

namespace Modules\CMS\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CMS\Http\Requests\TestimonialRequest;
use Modules\CMS\Http\Requests\UpdateTestimonialRequest;
use Modules\CMS\Interfaces\TestimonialInterface;

class TestimonialController extends Controller
{
    use ApiReturnFormatTrait;

    protected $testimonial;

    public function __construct(TestimonialInterface $testimonialInterface)
    {
        $this->testimonial = $testimonialInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['testimonials'] = $this->testimonial->model()->search($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('common.Testimonial List'); // title
            return view('cms::testimonial.index', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            $data['title'] = ___('common.Create Testimonial'); // title
            $data['button'] = ___('common.Create'); // button
            return view('cms::testimonial.create', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(TestimonialRequest $request)
    {
        try {
            $result = $this->testimonial->store($request);
            if ($result->original['result']) {
                return redirect()->route('admin.testimonial.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['testimonial'] = $this->testimonial->model()->findOrFail($id);
            if (!$data['testimonial']) {
                return redirect()->back()->with('danger', ___('alert.testimonial_not_found'));
            }
            $data['title'] = ___('common.Edit Testimonial'); // title
            $data['button'] = ___('common.Update'); // button
            return view('cms::testimonial.edit', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateTestimonialRequest $request, $id)
    {
        try {
            $result = $this->testimonial->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('admin.testimonial.index')->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            $result = $this->testimonial->destroy($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
