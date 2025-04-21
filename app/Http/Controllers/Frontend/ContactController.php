<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Interfaces\ContactInterface;

class ContactController extends Controller
{

    use ApiReturnFormatTrait;

    protected $contact;

    public function __construct(ContactInterface $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        try {
            $data['title'] = ___('frontend.Contact_Us'); // title
            return view('frontend.contact', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

    public function store(ContactRequest $request)
    {
        try {
            $result = $this->contact->store($request);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }

    }

}
