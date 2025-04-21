<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Interfaces\PageInterface;
use Illuminate\Contracts\Support\Renderable;
use Modules\CMS\Interfaces\HomeSectionInterface;
use Modules\Page\Http\Requests\CreatePageRequest;
use Modules\Page\Http\Requests\UpdatePageRequest;


class PageController extends Controller
{
    // constructor injection
    protected $page;
    protected $homeSection;

    public function __construct(PageInterface $page,HomeSectionInterface $homeSectionInterface)
    {
        $this->page         = $page;
        $this->homeSection = $homeSectionInterface;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {

        try {

            $data['tableHeader']    = $this->page->tableHeader(); // table header
            $data['pages']          = $this->page->getAll($request); // data
            $data['title']          = ___('page.Page'); // title
            return view('page::page.index', compact('data')); // view
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
            $data['title']              =   ___('page.Create Page'); // title
            $data['button']             =   ___('common.create'); // button
            $data['sections']           = $this->homeSection->model()->where('type', 'web')->orderBy('order', 'asc')->get(); // data
            return view('page::page.create', compact('data'));
        } catch (\Throwable $th) {

            return redirect()->route('pages.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */

    public function store(CreatePageRequest $request)
    {


        try {
            $result = $this->page->store($request);
            if ($result->original['result']) {
                return redirect()->route('pages.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('pages.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {

            return redirect()->route('pages.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            $data['title']              = ___('page.Edit Page'); // title
            $data['button']             = ___('common.update'); // button
            $data['page']               = $this->page->model()->find($id);
            $data['sections']           = $this->homeSection->model()->where('type', 'web')->orderBy('order', 'asc')->get(); // data
            return view('page::page.edit', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('pages.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdatePageRequest $request, $id)
    {
        try {
            $result = $this->page->update($request, $id);
            if ($result->original['result']) {
                return redirect()->route('pages.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('pages.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('pages.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            $result = $this->page->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('pages.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('pages.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('pages.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
