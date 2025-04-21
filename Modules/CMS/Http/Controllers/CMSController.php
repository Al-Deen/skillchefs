<?php

namespace Modules\CMS\Http\Controllers;

use App\Enums\GuardType;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\CMS\Interfaces\CMSInterface;
use Illuminate\Contracts\Support\Renderable;

class CMSController extends Controller
{
    use ApiReturnFormatTrait;
     // constructor injection
     protected $cms;

     public function __construct(CMSInterface $cms)
     {
         $this->cms         = $cms;
     }



    public function index(Request $request)
    {

        try {

            $data['tableHeader']    = $this->cms->tableHeader(); // table header
            $data['allowArr']       = $this->cms->model()->search($request)->where('type',$request->type ?? 'web')->orderBy('id', 'asc')->paginate($request->show ?? 10); // data
            $data['title']          = ___('cms.CMS Setting'); // title

            return view('cms::cms.index', compact('data')); // view
        }

        catch (\Throwable $th) {

            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function update(Request $request)
    {
        try {
            $result = $this->cms->update($request);
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message']);
            } else {
                return $this->responseWithError($result->original['message']);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'));
        }
    }


}
