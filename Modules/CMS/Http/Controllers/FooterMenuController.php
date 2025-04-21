<?php

namespace Modules\CMS\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CMS\Http\Requests\FooterMenuRequest;
use Modules\CMS\Interfaces\FooterInterface;

class FooterMenuController extends Controller
{
    use ApiReturnFormatTrait;

    protected $footer;

    public function __construct(FooterInterface $footerInterface)
    {
        $this->footer = $footerInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['tableHeader'] = $this->footer->tableHeader(); // table header
            $data['menus'] = $this->footer->model()->search($request->search)->paginate($request->show ?? 10); // data
            $data['title'] = ___('common.Footer Menu'); // title
            return view('cms::footer_menu.index', compact('data')); // view
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

            $data['title'] = ___('common.Create Footer Menu'); // title
            $data['button'] = ___('common.Create');
            $data['url'] = route('footer-menu.store');
            $html = view('cms::footer_menu.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FooterMenuRequest $request)
    {
        try {
            $result = $this->footer->store($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('cms::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['title'] = ___('common.Edit Footer Menu'); // title
            $data['button'] = ___('common.Update');
            $data['url'] = route('footer-menu.update', $id);
            $data['menu'] = $this->footer->model()->find($id);
            if (!$data['menu']) {
                return $this->responseWithError(___('alert.Footer menu not found'), [], 400); // return error response
            }
            $html = view('cms::footer_menu.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FooterMenuRequest $request, $id)
    {
        
        try {
            $result = $this->footer->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
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
            $result = $this->footer->model()->find($id);
            if (!$result) {
                return redirect()->back()->with('danger', ___('alert.Footer menu not found'));
            }
            $result->delete();
            return redirect()->back()->with('success', ___('alert.Footer menu deleted successfully'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
