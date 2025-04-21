<?php

namespace Modules\CMS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\CMS\Interfaces\ImageGalleryInterface;
use Modules\CMS\Http\Requests\ImageGalleryRequest;

class ImageGalleryController extends Controller
{

    use ApiReturnFormatTrait;

    protected $gallery;

    public function __construct(ImageGalleryInterface $imageGalleryInterface)
    {
        $this->gallery = $imageGalleryInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['galleries'] = $this->gallery->model()->search($request)->paginate($request->show ?? 10); // data
            $data['title'] = ___('cms.Image_Gallery_List'); // title
            return view('cms::galleries.index', compact('data')); // view
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
            $data['title'] = ___('cms.Edit_Image_Gallery'); // title
            $data['button'] = ___('common.Update');
            $data['gallery'] = $this->gallery->model()->find($id);
            $data['url'] = route('admin.image_gallery.update', $id);
            $html = view('cms::galleries.modal.edit', compact('data'))->render(); // render view
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
    public function update(ImageGalleryRequest $request, $id)
    {
        try {
            $result = $this->gallery->update($request, $id);
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
        //
    }
}
