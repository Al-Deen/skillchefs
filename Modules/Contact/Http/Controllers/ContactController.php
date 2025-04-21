<?php

namespace Modules\Contact\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Contact\Interfaces\ContactInterface;

class ContactController extends Controller
{
    use ApiReturnFormatTrait;

    protected $contact;

    public function __construct(ContactInterface $contact)
    {
        $this->contact = $contact;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $data['contacts'] = $this->contact->model()->latest()->paginate(10);
            $data['title'] = ___('common.Contacts'); // title
            return view('contact::index', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        try {
            $data['contact'] = $this->contact->model()->find($id);
            if (!$data['contact']) {
                return $this->responseWithError(___('alert.Contact_Not_Found'), [], 400); // return error response
            }
            $data['title'] = ___('common.Contact_Details'); // title
            $html = view('contact::modal.view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
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
        return view('contact::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
