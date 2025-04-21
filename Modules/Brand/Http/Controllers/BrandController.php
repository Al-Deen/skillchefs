<?php

namespace Modules\Brand\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Brand\Interfaces\BrandInterface;
use Modules\Brand\Http\Requests\CreateBrandRequest;
use Modules\Brand\Http\Requests\UpdateBrandRequest;


class BrandController extends Controller
{
    // constructor injection
    protected $brand;

    public function __construct(BrandInterface $brand)
    {
        $this->brand         = $brand;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        try {

            $data['tableHeader']    = $this->brand->tableHeader(); // table header
            $data['brands']         = $this->brand->getAll($request); // data
            $data['title']          = ___('brand.Brand'); // title

            if ($data['brands']) {
                return view('brand::brand.index', compact('data')); // view
            }

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

        catch (\Throwable $th) {

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
            $data['title']              =   ___('brand.Create Brand'); // title
            $data['button']             =   ___('common.create'); // button
            return view('brand::brand.create', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->route('brand.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */

    public function store(CreateBrandRequest $request)
    {

        try {
            $result = $this->brand->store($request);
            if ($result->original['result']) {
                return redirect()->route('brand.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('brand.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {

            return redirect()->route('brand.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('brand::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['title']              = ___('brand.Edit Brand'); // title
            $data['button']             = ___('common.update'); // button
            $data['brand']               = $this->brand->model()->find($id);

            return view('brand::brand.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('brand.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        try {
            $result = $this->brand->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('brand.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('brand.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('brand.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            // dd($id);
            $result = $this->brand->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('brand.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('brand.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('brand.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
