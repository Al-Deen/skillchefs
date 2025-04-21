<?php

namespace Modules\Contact\Repositories;

use App\Traits\ApiReturnFormatTrait;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Interfaces\ContactInterface;

class ContactRepository implements ContactInterface
{
    use ApiReturnFormatTrait;

    private $model;

    public function __construct(Contact $contactModel)
    {
        $this->model = $contactModel;
    }

    public function model()
    {
        return $this->model;
    }

    public function store($request)
    {
        try {
            $contact = $this->model();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();
            return $this->responseWithSuccess(___('alert.thank_you_for_contacting_us.we_will_get_back_to_you_soon'), 200); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400); // return error response
        }
    }
}
