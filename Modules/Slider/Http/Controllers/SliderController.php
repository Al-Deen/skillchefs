<?php

namespace Modules\Slider\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Slider\Interfaces\SliderInterface;
use Modules\Slider\Http\Requests\CreateSliderRequest;
use Modules\Slider\Http\Requests\UpdateSliderRequest;


class SliderController extends Controller
{
    // constructor injection
    protected $slider;

    public function __construct(SliderInterface $slider)
    {
        $this->slider         = $slider;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        try {

            $data['tableHeader']    = $this->slider->tableHeader(); // table header
            $data['sliders']        = $this->slider->getAll($request); // data
            $data['title']          = ___('slider.slider'); // title


            if ($data['sliders']) {
                return view('slider::slider.index', compact('data')); // view
            }

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));

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
            $data['title']              =   ___('slider.Create slider'); // title
            $data['button']             =   ___('common.create'); // button
            return view('slider::slider.create', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->route('slider.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */

    public function store(CreateSliderRequest $request)
    {


        try {
            $result = $this->slider->store($request);
            if ($result->original['result']) {
                return redirect()->route('slider.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('slider.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {

            return redirect()->route('slider.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('slider::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['title']              = ___('slider.Edit slider'); // title
            $data['button']             = ___('common.update'); // button
            $data['slider']               = $this->slider->model()->find($id);

            return view('slider::slider.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('slider.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateSliderRequest $request, $id)
    {
        try {
            $result = $this->slider->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('slider.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('slider.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('slider.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            $result = $this->slider->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('slider.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('slider.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('slider.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
