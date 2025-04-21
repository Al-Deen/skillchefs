<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Interfaces\UserInterface;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Contracts\Support\Renderable;
use Modules\Api\Transformers\OrganizationResource;
use Modules\Api\Collections\OrganizationCollection;
use Modules\Organization\Interfaces\OrganizationInterface;

class OrganizationController extends Controller
{
    use ApiReturnFormatTrait, FileUploadTrait;

    protected $organization;
    protected $user;


    public function __construct(OrganizationInterface $organization, UserInterface $user) {
        $this->organization     = $organization;
        $this->user             = $user;
    }


    public function index(Request $request)
    {
        try {
            $search = $request->search;

            $organizations = $this->organization->model()->with('user')->whereHas('user', function ($query) {
                $query->where('status_id', 4);
            })->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->orWhere('phone', 'like', '%' . $search . '%');
                });
            })->paginate(6);

            $data['instructors'] = new OrganizationCollection($organizations);

            if ($data['instructors']->isEmpty()) {
                return $this->responseWithError(___('course.No data found'));
            }else{
                return $this->responseWithSuccess(___('course.data found'), $data);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }


    public function details(Request $request)
    {
        try {
            $organization = $this->organization->model()->with('user')->where('id', $request->id)->first();
            if(!empty($organization)){
                $data['organization'] = new OrganizationResource($organization);
                if ($data['organization']) {
                    return $this->responseWithSuccess(___('course.data found'), $data);
                }
            }else{
                return $this->responseWithError(___('course.No data found'));
            }

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
