<?php

namespace Modules\CMS\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CMS\Http\Requests\FooterMenuLinkRequest;
use Modules\CMS\Interfaces\FooterInterface;
use Modules\Page\Interfaces\PageInterface;

class FooterMenuLinkController extends Controller
{
    use ApiReturnFormatTrait;

    protected $footer;
    protected $page;

    public function __construct(FooterInterface $footerInterface, PageInterface $pageInterface)
    {
        $this->footer = $footerInterface;
        $this->page = $pageInterface;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request, $footer_menu_id)
    {
        try {
            if (!$request->ajax()) {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
            $data['title'] = ___('common.Create Footer Menu Link'); // title
            $data['button'] = ___('common.Create');
            $data['url'] = route('footer-menu-link.store', $footer_menu_id);
            $data['pages'] = $this->page->model()->active()->select('title','id','slug')->get();
            $html = view('cms::footer_menu.modal.link_create', compact('data'))->render(); // render view
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
    public function store(FooterMenuLinkRequest $request, $footer_menu_id)
    {
        try {
            $result = $this->footer->linkStore($request, $footer_menu_id);
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
    public function edit(Request $request, $footer_menu_id, $id)
    {
        try {
            if (!$request->ajax()) {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
            }
            $data['title'] = ___('common.Edit Footer Menu Link'); // title
            $data['button'] = ___('common.Update');
            $data['url'] = route('footer-menu-link.update', [$footer_menu_id, $id]);
            $data['menu'] = $this->footer->model()->find($footer_menu_id);
            if (!$data['menu']) {
                return $this->responseWithError(___('alert.Footer menu not found'), [], 400); // return error response
            }
            if (!@$data['menu']->allLink()[$id]) {
                return $this->responseWithError(___('alert.Footer menu link not found'), [], 400); // return error response
            }
            $data['pages'] = $this->page->model()->active()->select('title','id','slug')->get();
            $data['link'] = $data['menu']->allLink()[$id];
            $html = view('cms::footer_menu.modal.link_create', compact('data'))->render(); // render view
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
    public function update(FooterMenuLinkRequest $request, $footer_menu_id, $linkId)
    {

        try {
            $result = $this->footer->linkUpdate($request, $footer_menu_id, $linkId);
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
    public function destroy($footer_menu_id, $linkId)
    {
        try {
            $result = $this->footer->linkDestroy($footer_menu_id, $linkId);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']); // return success response
            } else {
                return redirect()->back()->with('error', $result->original['message']); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', ___('alert.something_went_wrong_please_try_again')); // return error response
        }
    }
}
