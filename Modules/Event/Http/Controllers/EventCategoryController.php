<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Event\Interfaces\EventCategoryInterface;
use Modules\Event\Http\Requests\Category\CreateEventCategoryRequest;
use Modules\Event\Http\Requests\Category\UpdateEventCategoryRequest;

class EventCategoryController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;
    // constructor injection
    protected $eventCategory;

    public function __construct(EventCategoryInterface $eventCategory)
    {
        $this->eventCategory = $eventCategory;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $data['tableHeader'] = $this->eventCategory->tableHeader(); // table header
            $data['categories'] = $this->eventCategory->model()->search($request->search)->paginate($request->show ?? 10); // data
            $data['title'] = ___('event.Event Category'); // title

            if ($data['categories']) {
                return view('event::backend.admin.event_category.index', compact('data')); // view
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
            $data['url'] = route('event.category.store'); // url
            $data['title'] = ___('event.Create Category');
            @$data['button'] = ___('event.Add'); // button
            $html = view('event::backend.admin.modal.category.create', compact('data'))->render(); // render view
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
    public function store(CreateEventCategoryRequest $request)
    {
        try {
            $result = $this->eventCategory->store($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return redirect()->route('instructor.event.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
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
            $data['category'] = $this->eventCategory->model()->where('id', $id)->first();
            if (@$data['category']) {
                $data['url'] = route('event.category.update', $id); // url
                $data['title'] = ___('event.Edit Category'); // title
                @$data['button'] = ___('event.Update'); // button
                $html = view('event::backend.admin.modal.category.update', compact('data'))->render(); // render view
                return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
            } else {
                return $this->responseWithError(___('event.Question Not Found'), [], 400); // return error response
            }
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
    public function update(UpdateEventCategoryRequest $request, $id)
    {
        try {
            $result = $this->eventCategory->update($request, $id);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']); // return success response
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
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
            $result = $this->eventCategory->destroy($id);
            if ($result->original['result']) {
                return redirect()->route('event.category.index')->with('success', $result->original['message']);
            } else {
                return redirect()->route('event.category.index')->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('event.category.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
