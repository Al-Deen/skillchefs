<?php

namespace Modules\Api\Repositories;

use App\Models\Setting;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Modules\Student\Entities\Student;
use Modules\Api\Interfaces\OrderInterface;
use Modules\Api\Interfaces\SettingsInterface;
use Modules\Order\Interfaces\EnrollInterface;
use Modules\Api\Collections\AssignmentCollection;


class SettingsRepository implements SettingsInterface
{

    use ApiReturnFormatTrait, FileUploadTrait;

    protected $model;
    protected $enrollInterface;
    protected $orderInterface;

    public function __construct(EnrollInterface $enrollInterface, OrderInterface $orderInterface, Setting $settings) {
        $this->model = $settings;
        $this->enrollInterface             = $enrollInterface;
        $this->orderInterface              = $orderInterface;
    }

    public function model(){
        return $this->model;
    }

    public function dashboard(){
        try {
            $data['purchase_amounts']           = $this->orderInterface->model()->where('user_id',auth()->id())->sum('total_amount');
            $data['course_count']               = $this->enrollInterface->model()->where('user_id',auth()->id())->count();
            $enroll                             = $this->enrollInterface->model()->with(['course:id,title'])->where('user_id', Auth::id())->get();

            if ($enroll) {
                $assignments = [];
                foreach ($enroll as $enrolled_course) {
                    $assignmentCollection = new AssignmentCollection($enrolled_course->course->activeAssignments);
                    $assignmentArray = json_encode($assignmentCollection);
                    if ($assignmentCollection->isNotEmpty()) {
                        $assignments = array_merge($assignments, json_decode($assignmentArray));
                    }
                }

                $data['assignments'] = $assignments;
            } else {
                $data['assignments'] = [];
            }

           return $this->responseWithSuccess(___('student.data found'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function baseSettings(){
        try{
            // Cache
            if (Cache::has('app_base_settings')) {
                $base_settings = Cache::get('app_base_settings');
            } else {
                $selectSettings = [
                'application_name',
                'application_details',
                'author',
                'email_address',
                'phone_number',
                'office_address',
                'payment_gateway'
            ];

                $setting = $this->model()->whereIn('name', $selectSettings)->get();
                $base_settings = $setting->pluck('value', 'name')->toArray();
                Cache::put('app_base_settings', $base_settings);
            }

            if ($base_settings != []) {
                return $this->responseWithSuccess(___('student.data found'), $base_settings);
            } else {
                return $this->responseWithError(___('student.no data found'));
            }

        }catch(\Throwable $th){
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400);
        }
    }
}
