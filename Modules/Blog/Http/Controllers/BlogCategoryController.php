<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Blog\Interfaces\BlogCategoryInterface;
use Modules\Blog\Http\Requests\CreateBlogCategoryRequest;
use Modules\Blog\Http\Requests\UpdateBlogCategoryRequest;

class BlogCategoryController extends Controller
{
    // constructor injection
    protected $blogCategory;

    public function __construct(BlogCategoryInterface $blogCategory)
    {
        $this->blogCategory = $blogCategory;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['tableHeader'] = $this->blogCategory->tableHeader(); // table header
            $data['categories'] = $this->blogCategory->model()->search($request->search)->paginate($request->show ?? 10); // data
            $data['title'] = ___('blog.Blog Category'); // title

            if ($data['categories']) {
                return view('blog::blog_category.index', compact('data')); // view
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
            $data['title'] = ___('blog.Create Blog Category'); // title
            $data['button'] = ___('common.create'); // button
            return view('blog::blog_category.create', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->route('blog-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateBlogCategoryRequest $request)
    {
        try {
            $result = $this->blogCategory->store($request);
            if ($result->original['result']) {
                return redirect()->route('blog-category.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('blog-category.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('blog-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('Blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['title']      = ___('blog.Edit Blog Category'); // title
            $data['button']     = ___('common.update'); // button
            $data['category']   = $this->blogCategory->model()->find($id);
            return view('blog::blog_category.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('blog-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateBlogCategoryRequest $request, $id)
    {
        try {
            $result = $this->blogCategory->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('blog-category.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('blog-category.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('blog-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            $result = $this->blogCategory->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('blog-category.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('blog-category.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('blog-category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
