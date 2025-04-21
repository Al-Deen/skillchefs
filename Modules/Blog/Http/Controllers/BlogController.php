<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Blog\Interfaces\BlogInterface;
use Modules\Blog\Interfaces\BlogCategoryInterface;
use Modules\Blog\Http\Requests\CreateBlogRequest;
use Modules\Blog\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
    // constructor injection
    protected $blog;
    protected $blogCategory;

    public function __construct(BlogInterface $blog, BlogCategoryInterface $blogCategory)
    {
        $this->blog         = $blog;
        $this->blogCategory = $blogCategory;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {

            $data['tableHeader']    = $this->blog->tableHeader(); // table header
            $data['blogs']          = $this->blog->getAll($request); // data
            $data['categoriesArr']  = $this->blogCategory->catArr(); // blog category array
            $data['title']          = ___('blog.Blog'); // title

            if ($data['blogs']) {
                return view('blog::blog.index', compact('data')); // view
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
            $data['title']              =   ___('blog.Create Blog'); // title
            $data['categoriesArr']      =   ['' => ___('blog.select_category')] + $this->blogCategory->catArr(); // data
            $data['button']             =   ___('common.create'); // button
            return view('blog::blog.create', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->route('blog.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateBlogRequest $request)
    {
        try {
            $result = $this->blog->store($request);
            if ($result->original['result']) {
                return redirect()->route('blog.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('blog.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('blog.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {
            $data['title']              = ___('blog.Edit Blog'); // title
            $data['button']             = ___('common.update'); // button
            $data['blog']               = $this->blog->model()->find($id);
            $data['categoriesArr']      = ['' => ___('blog.select_category')] + $this->blogCategory->catArr(); // data

            return view('blog::blog.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('blog.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateBlogRequest $request, $id)
    {
        try {
            $result = $this->blog->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('blog.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('blog.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('blog.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            $result = $this->blog->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('blog.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('blog.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('blog.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
