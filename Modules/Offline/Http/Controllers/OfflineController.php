<?php

namespace Modules\Offline\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Modules\Event\Interfaces\EventRegistrationInterface;
use Modules\Offline\Http\Requests\OfflinePaymentRequest;
use Modules\Offline\Interfaces\OfflineInterface;
use Modules\Order\Interfaces\OrderInterface;

class OfflineController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;
    // constructor injection
    protected $order;
    protected $offline;
    protected $event;

    public function __construct(OrderInterface $order, OfflineInterface $offline, EventRegistrationInterface $event)
    {
        $this->order = $order;
        $this->offline = $offline;
        $this->event = $event;
    }

    public function courseApprovalIndex(Request $request)
    {
        try {
            $data['title'] = ___('offline.Course Enroll Approval List'); // title
            $data['orders'] = $this->order->model()->where(['payment_method' => 'offline', 'status' => 'unpaid'])->search($request->search)->paginate($request->show ?? 10); // data
            return view('offline::admin.course.approval_list', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function eventApprovalIndex(Request $request)
    {
        try {
            $data['title'] = ___('offline.Event Registration Approval List'); // title
            $data['events'] = $this->event->model()->where(['payment_method' => 'offline', 'status' => 'unpaid'])->search($request)->paginate($request->show ?? 10); // data
            return view('offline::admin.event.approval_list', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function packageApprovalIndex(Request $request)
    {
        try {
            $data['title'] = ___('offline.Package Enroll Approval List'); // title
            $data['packages'] = \Modules\Subscription\Entities\PackagePurchase::where(['payment_method' => 'offline', 'status' => 'unpaid'])->search($request)->paginate($request->show ?? 10); // data
            return view('offline::admin.package.approval_list', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function viewCourseApproval($order_id)
    {
        try {
            $data['order'] = $this->order->model()->find($order_id);
            if (!$data['order']) {
                return $this->responseWithError(___('alert.Order_not_found'), [], 400); // return error response
            }
            $data['url'] = route('course.enroll.approve', $order_id); // title
            $data['title'] = ___('common.Approve_Course_Enroll'); // title
            $data['button'] = ___('common.Approve');
            $html = view('offline::admin.course.view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function viewEventApproval($id)
    {
        try {
            $data['event'] = $this->event->model()->find($id);
            if (!$data['event']) {
                return $this->responseWithError(___('alert.event_not_found'), [], 400); // return error response
            }
            $data['url'] = route('event.enroll.approve', $id); // title
            $data['title'] = ___('common.Approve_Event_Registration'); // title
            $data['button'] = ___('common.Approve');
            $html = view('offline::admin.event.view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function viewPackageApproval($id)
    {
        try {
            $data['package'] = \Modules\Subscription\Entities\PackagePurchase::find($id);
            if (!$data['package']) {
                return $this->responseWithError(___('alert.package_not_found'), [], 400); // return error response
            }
            $data['url'] = route('package.enroll.approve', $id); // title
            $data['title'] = ___('common.Approve_Package_Enroll'); // title
            $data['button'] = ___('common.Approve');
            $html = view('offline::admin.package.view', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response

        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateCourseApproval(Request $request, $id)
    {
        try {
            $order = $this->order->model()->where('id', $id)->first(); // data
            if (!$order) {
                return redirect()->back()->with('danger', ___('alert.order_not_found'));
            }
            $result = $this->offline->approveCourseEnroll($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updateEventApproval(Request $request, $id)
    {
        try {
            $event = $this->event->model()->where('id', $id)->first(); // data
            if (!$event) {
                return redirect()->back()->with('danger', ___('alert.event_not_found'));
            }
            $result = $this->offline->approveEventRegistration($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function updatePackageApproval(Request $request, $id)
    {
        try {
            $event =  \Modules\Subscription\Entities\PackagePurchase::where('id', $id)->first(); // data
            if (!$event) {
                return redirect()->back()->with('danger', ___('alert.event_not_found'));
            }
            $result = $this->offline->approvePackageEnroll($id);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function destroyCourseApproval($id)
    {
        try {
            $result = $this->offline->destroyCourseApproval($id);
            if ($result->original['result']) {
                return back()->with('success', $result->original['message']);
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function destroyEventApproval($id)
    {
        try {
            $result = $this->offline->destroyEventApproval($id);
            if ($result->original['result']) {
                return back()->with('success', $result->original['message']);
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function destroyPackageApproval($id)
    {
        try {
            $result = $this->offline->destroyPackageApproval($id);
            if ($result->original['result']) {
                return back()->with('success', $result->original['message']);
            } else {
                return back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function settings()
    {
        try {
            $data['title'] = ___('offline.Offline Payment Settings'); // title
            $path = base_path('/Modules/Offline');
            $jsonFile = "$path/payment.json";
            $ext = pathinfo($jsonFile, PATHINFO_EXTENSION);
            if (@$ext != 'json') {
                $jsonFile = "$path/payment.json";
            }

            if (File::exists($jsonFile)) {
                $jsonString = file_get_contents($jsonFile);
            } else {
                $defaultSettings = [
                    [
                        "name" => "Cash",
                        "status" => 1,
                    ],
                    [
                        "name" => "Cheque",
                        "status" => 1,
                    ],
                    [
                        "name" => "Bank Transfer",
                        "status" => 1,
                    ],
                ];
                $newJsonString = json_encode($defaultSettings);
                file_put_contents($jsonFile, stripslashes($newJsonString));
                $jsonString = file_get_contents($jsonFile);
            }
            $data['settings'] = (json_decode($jsonString, true));
            return view('offline::admin.settings.settings', compact('data')); // view
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function SettingsEdit($key)
    {
        try {
            $jsonString = file_get_contents(base_path('Modules/Offline/payment.json'));
            if (!$jsonString) {
                return $this->responseWithError(___('alert.setting_not_found'), [], 400); // return error response
            }
            $collections = collect(json_decode($jsonString, true));
            if (!$collections) {
                return $this->responseWithError(___('alert.setting_not_found'), [], 400); // return error response
            }
            $setting = $collections->where('name', $key)->first();
            if (!$setting) {
                return $this->responseWithError(___('alert.setting_not_found'), [], 400); // return error response
            }
            $data['setting'] = (object) $setting;
            $data['url'] = route('admin.offline_payment.settings_update', $key); // url
            $data['title'] = ___('offline.Edit Offline Setting'); // title
            @$data['button'] = ___('common.Update');
            $html = view('offline::admin.settings.modal.create', compact('data'))->render(); // render view
            return $this->responseWithSuccess(___('alert.data_retrieve_success'), $html); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function SettingsUpdate(OfflinePaymentRequest $request, $key)
    {
        try {
            $jsonString = file_get_contents(base_path('Modules/Offline/payment.json'));
            if (!$jsonString) {
                return $this->responseWithError(___('alert.setting_not_found'), [], 400); // return error response
            }
            $collections = collect(json_decode($jsonString, true));
            if (!$collections) {
                return $this->responseWithError(___('alert.setting_not_found'), [], 400); // return error response
            }
            $setting = $collections->where('name', $key)->first();
            if (!$setting) {
                return $this->responseWithError(___('alert.setting_not_found'), [], 400); // return error response
            }
            $setting['status'] = $request->status;
            $setting['name'] = $request->name;
            $collections = $collections->map(function ($item) use ($setting) {
                if ($item['name'] == $setting['name']) {
                    return $setting;
                }
                return $item;
            });
            $newJsonString = json_encode($collections, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents(base_path('Modules/Offline/payment.json'), stripslashes($newJsonString));
            return $this->responseWithSuccess(___('offline.Settings_update')); // return success response
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
