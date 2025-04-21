<?php

namespace Modules\CMS\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CMS\Http\Requests\AppHomeSectionRequest;
use Modules\CMS\Interfaces\HomeSectionInterface;

class HomeSectionController extends Controller
{
    use ApiReturnFormatTrait;

    protected $homeSection;

    // constructor injection
    public function __construct(
        HomeSectionInterface $homeSectionInterface
    ) {
        $this->homeSection = $homeSectionInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        try {
            $data['tableHeader'] = $this->homeSection->tableHeader(); // table header
            $data['sections'] = $this->homeSection->model()->where('is_delete', 0)->search($request)->where('type', 'web')->orderBy('order', 'asc')->paginate($request->show ?? 10); // data
            $data['title'] = ___('cms.Home Section Setting'); // title
            $data['type'] = 'web'; // type
            return view('cms::home_sections.index', compact('data')); // view
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function appHomeSection(Request $request)
    {

        try {
            $data['tableHeader'] = $this->homeSection->tableHeader(); // table header
            $data['sections'] = $this->homeSection->model()->where('is_delete', 0)->search($request)->where('type', 'api')->orderBy('order', 'asc')->paginate($request->show ?? 10); // data
            $data['title'] = ___('cms.App Home Section Setting'); // title
            $data['type'] = 'api'; // type
            return view('cms::home_sections.index', compact('data')); // view
        } catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($type)
    {
        try {

            $data['title'] = ___('common.Create Home Section'); // title
            $data['button'] = ___('common.Create');
            $data['sections'] = $this->homeSection->model()->where('is_delete', 1)->where('type', $type)->orderBy('order', 'asc')->get();
            $data['url'] = route('home_section.setting.store', $type);
            $html = view('cms::home_sections.modal.create', compact('data'))->render(); // render view
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
    public function store(AppHomeSectionRequest $request, $type)
    {
        try {
            $request->merge(['type' => $type]);
            $result = $this->homeSection->store($request);
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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {

            $data['title'] = ___('common.Edit Home Section'); // title
            $data['button'] = ___('common.Update');
            $data['section'] = $this->homeSection->model()->find($id);
            $data['url'] = route('home_section.setting.update', $id);
            $data['sections'] = $this->homeSection->model()->where('type', $data['section']->type)->orderBy('order', 'ASC')->select('order')->get();
            $html = view('cms::home_sections.modal.edit', compact('data'))->render(); // render view
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
    public function update(AppHomeSectionRequest $request, $id)
    {
        try {
            $result = $this->homeSection->update($request, $id);
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
            $target = $this->homeSection->model()->find($id);
            if (!$target) {
                return redirect()->back()->with('danger', ___('alert.Home section not found'));
            }
            $target->update(['is_delete' => 1]);
            return redirect()->back()->with('success', ___('alert.Home section deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
