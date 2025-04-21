<?php

namespace Modules\Blog\Repositories;

use App\Enums\OrderBy;
use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Interfaces\BlogInterface;

class BlogRepository implements BlogInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(Blog $blogModel)
    {
        $this->model = $blogModel;
    }

    public function getAll($request)
    {

        try {

            $data = $this->model->query()->with('category:id,title', 'metaImage', 'iconImage');

            $data = $this->filter($request, $data);

            $data = $data->orderBy('id', OrderBy::DESC)->paginate($request->show ?? 10);

            return $data;

        } catch (\Throwable $th) {
            return false;
        }

    }

    public function filter($request, $data)
    {

        if (!empty($request->search)) {
            $data = $data->where('title', 'like', '%' . $request->search . '%');
        }

        if (!empty($request->category_id)) {
            $data = $data->where('blog_categories_id', $request->category_id);
        }

        return $data;
    }

    public function all()
    {
        try {
            return $this->model->get();

        } catch (\Throwable $th) {
            return false;
        }

    }

    public function tableHeader()
    {

        return [
            ___('common.ID'),
            ___('common.Title'),
            ___('common.Image'),
            ___('common.Category'),
            ___('ui_element.status'),
            ___('ui_element.created_at'),
            ___('ui_element.action'),
        ];
    }

    public function model()
    {
        try {
            return $this->model;

        } catch (\Throwable $th) {
            return false;
        }
    }

    public function store($request)
    {

        DB::beginTransaction(); // start database transaction
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $target = new $this->model; // create new object of model for store data in database table
            $target->title = $request->title;
            $target->slug = Str::slug($request->title) . '-' . Str::random(8);
            $target->status_id = $request->status_id;
            $target->blog_categories_id = $request->blog_categories_id;
            $target->description = $request->description;
            $target->meta_title = $request->meta_title ?? '';
            $target->meta_keywords = $request->meta_keywords ?? '';
            $target->meta_description = $request->meta_description ?? '';
            $target->created_by = auth()->id();
            // icon upload
            if ($request->hasFile('image_id')) {
                $upload = $this->uploadFile($request->image_id, 'blog/image/images', [[35, 35], [300, 220], [750, 400]], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $target->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }

            // Meta imsge upload
            if ($request->hasFile('meta_image_id')) {
                $upload = $this->uploadFile($request->meta_image_id, 'blog/meta_image/images', [[35, 35], [300, 220], [750, 400]], '', 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $target->meta_image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }

            $target->save(); // save data in database table
            DB::commit(); // commit database transaction
            return $this->responseWithSuccess(___('alert.Blog created successfully.')); // return success response
        } catch (\Throwable $th) {
            DB::rollBack(); // rollback database transaction
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    public function show($id)
    {
        try {

            return $this->model->with('category:id,title', 'metaImage', 'iconImage', 'user:id,name,image_id')->find($id);

        } catch (\Throwable $th) {
            return false;
        }

    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }


            $target = $this->model->find($id);
            if (!$target) {
                return $this->responseWithError(___('alert.Blog not found.'), [], 400);
            }
            $target->title = $request->title;
            if ($request->title != $target->title) {
                $target->slug = Str::slug($request->title) . '-' . Str::random(8);
            }

            $target->status_id = $request->status_id;
            $target->blog_categories_id = $request->blog_categories_id;
            $target->description = $request->description;
            $target->meta_title = $request->meta_title ?? '';
            $target->meta_keywords = $request->meta_keywords ?? '';
            $target->meta_description = $request->meta_description ?? '';
            $target->created_by = auth()->id();
            // Image upload
            if ($request->hasFile('image_id')) {
                $upload = $this->uploadFile($request->image_id, 'blog/image/images', [[35, 35], [300, 220], [750, 400]], @$target->image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $target->image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }

            // Meta imsge upload
            if ($request->hasFile('meta_image_id')) {
                $upload = $this->uploadFile($request->meta_image_id, 'blog/meta_image/images', [[35, 35], [300, 220], [750, 400]], @$target->meta_image_id, 'image'); // upload file and resize image 35x35
                if ($upload['status']) {
                    $target->meta_image_id = $upload['upload_id'];
                } else {
                    return $this->responseWithError($upload['message'], [], 400);
                }
            }

            $target->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Blog updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function destroy($id)
    {
        try {

            if (env('APP_DEMO')) {
                return $this->responseWithError(___('alert.you_can_not_change_in_demo_mode'));
            }

            $target = $this->model->find($id);

            $upload = $this->deleteFile($target->image_id, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }

            $upload = $this->deleteFile($target->meta_image_id, 'delete'); // delete file from storage
            if (!$upload['status']) {
                return $this->responseWithError($upload['message'], [], 400); // return error response
            }
            $target->delete();

            return $this->responseWithSuccess(___('alert.Blog deleted successfully.')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }

    // Use this function in frontend BLog page
    public function getBlogs()
    {
        try {

            return $this->model->query()->active()->with('iconImage')->select('id', 'title', 'description', 'image_id','created_at')->latest()->paginate(8);

        } catch (\Throwable $th) {

            return false;
        }

    }

    // Use this function at Home page blog section
    public function homeBlog()
    {
        try {

            return $this->model->query()->active()->with('iconImage')->select('id', 'title', 'description', 'image_id','created_at')->latest()->take(4)->get();

        } catch (\Throwable $th) {

            return false;

        }

    }
    // Use this function at Home page  blog section

    // Use this function at Blog details in front end
    public function latestBlog()
    {
        try {

            return $this->model->query()->active()->with('category:id,title', 'iconImage')->latest()->take(6)->get();

        } catch (\Throwable $th) {

            return false;
        }

    }
    // Use this function at Blog details in front end

}
