<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Redirect;
use Modules\Event\Http\Requests\EventCheckoutRequest;
use Modules\Payment\Interfaces\PaymentInterface;
use Modules\Event\Interfaces\EventRegistrationInterface;
use Modules\Event\Interfaces\EventInterface;

class EventCheckoutController extends Controller
{
    use ApiReturnFormatTrait;

    private $paymentRepository;
    private $event;
    private $eventRegistration;

    public function __construct(EventInterface $event, PaymentInterface $paymentRepository, EventRegistrationInterface $eventRegistration)
    {
        $this->event = $event;
        $this->paymentRepository = $paymentRepository;
        $this->eventRegistration = $eventRegistration;
    }

    public function index(Request $request)
    {  
        try {
            if (auth()->user()->role_id == 4 || auth()->user()->role_id == 5 || auth()->user()->role_id == 6) {
                $events = $this->event->model()->where('slug', $request->event)->withCount('register')->first();

                if($events->register_count > $events->max_participant){
                    return back()->with('danger', ___('alert.Participant limit exceeded'));
                }

                if(!$events){
                    return redirect()->route('home')->with('danger', ___('alert.Invalid_event'));
                }
                if (@$events->registration_deadline <= now()->format('Y-m-d h:i:s')) {
                    return back()->with('danger', ___('alert.Event_registration_deadline_expired'));
                }

                $data['event'] = $events;
                $data['title'] = ___('frontend.Event_Checkout'); // title
                $data['payment_method'] = $this->paymentRepository->model()->active()->get();
                return view('event::frontend.event_checkout', compact('data'));
            } else{
                return back()->with('danger', ___('alert.You_are_not_a_student_or_instructor'));
            }
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function payment(EventCheckoutRequest $request){
        try {
            if($request->payment_method == 'offline'){
                $payment_method = 'offline';
                $data['payment_type'] = $request->payment_type;
                $data['additional_details'] = $request->additional_details;
            } elseif($request->payment_method == 'Paynet'){
                $payment_method = $request->payment_method;
            } else{
                $payment_method = $request->payment_method ? decrypt($request->payment_method) : null;
            }

            if (!$payment_method) {
                return redirect()->back()->with('danger', ___('alert.Please_select_payment_method'));
            }
            $data['payment_method'] = $payment_method;
            $data['country'] = setting('country') ? setting('country') : 'Bangladesh';

            $event_slug = $request->event_slug ? decrypt($request->event_slug) : null;
            if (!$event_slug) {
                return redirect()->back()->with('danger', ___('alert.Invalid_event'));
            }
            $data['event'] = $this->event->model()->where('slug', $event_slug)->first();


            // event registration store data
            $result = $this->eventRegistration->store($data);

            // offline event registration
            if($payment_method === 'offline'){
                return redirect()->route('home')->with('success', ___('alert.Payment successfully completed'));
            }

            if ($result->original['result']) {
                try {
                    $payment = $this->paymentRepository->findPaymentMethod($payment_method);
                    if($payment_method == 'Paynet'){
                        $redirect = $payment->event_process($result->original['data'], $request->all());
                    } else{
                        $redirect = $payment->event_process($result->original['data']);
                    }
                    if (in_array($payment_method, $this->paymentRepository->withoutRedirect())) {
                        return $redirect;
                    }
                    return Redirect::away($redirect);
                } catch (\Throwable $th) {
                    return redirect()->route('frontend.event.checkout.index')->with('danger', ___('alert.Payment gateway error'));
                }
            } else {
                return redirect()->back()->with('danger', $result['message']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('frontend.event.checkout.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function joinEvent(Request $request){
        try {
            if (auth()->user()->role_id == 4 || auth()->user()->role_id == 5) {
                $events = $this->event->model()->where('slug', $request->event)->withCount('register')->first();

                if($events->register_count > $events->max_participant){
                    return back()->with('danger', ___('alert.Participant limit exceeded'));
                }
                if(!$events){
                    return redirect()->route('home')->with('danger', ___('alert.Invalid_event'));
                }
                if (@$events->registration_deadline <= now()->format('Y-m-d h:i:s')) {
                    return back()->with('danger', ___('alert.Event_registration_deadline_expired'));
                }
                 // free event registration
                if($events->is_paid === 10){
                    $result = $this->eventRegistration->storeFreeEvent($events);
                    if ($result->original['result']) {
                        try {
                            return redirect()->route('home')->with('success', ___('alert.Event_registered_successfully.')); // return success response
                        } catch (\Throwable $th) {
                            return redirect()->route('frontend.event.checkout.index')->with('danger', ___('alert.Payment gateway error'));
                        }
                    } else {
                        return redirect()->back()->with('danger', $result['message']);
                    }
                }
            } else{
                return back()->with('danger', ___('alert.You_are_not_a_student_or_instructor'));
            }
        } catch (\Throwable $th) {
            return redirect()->route('frontend.event.checkout.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }
}
