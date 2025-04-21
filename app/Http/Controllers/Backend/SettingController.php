<?php

namespace App\Http\Controllers\Backend;

use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Interfaces\SettingInterface;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\SettingStoreRequest;
use App\Http\Requests\Settings\EmailSettingStoreRequest;
use App\Http\Requests\GeneralSetting\StorageUpdateRequest;
use App\Http\Requests\GeneralSetting\GeneralSettingStoreRequest;
use App\Http\Requests\GeneralSetting\TwilioUpdateRequest;

class SettingController extends Controller
{
    use ApiReturnFormatTrait;

    private $setting;

    public function __construct(SettingInterface $settingInterface)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')) {
            abort(400);
        }
        $this->setting = $settingInterface;
    }

    // General setting start
    public function generalSettings()
    {
        Log::info('General setting');
        $data['title'] = ___('common.General_Settings');
        $data['data'] = $this->setting->getAll();
        $data['languages'] = $this->setting->getLanguage();
        $data['countries'] = $this->setting->getCountry();
        $data['currencies'] = $this->setting->getCurrency();
        $data['date_formats'] = $this->setting->getDateFormat();
        $data['timezones'] = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        return view('backend.settings.general-settings', compact('data'));
    }

    public function updateGeneralSetting(GeneralSettingStoreRequest $request)
    {
        try {
            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
            }

            $result = $this->setting->updateGeneralSetting($request);
            // dd($result);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    // General setting end

    // Storage setting start
    public function storageSetting()
    {

        try {
            $data['title'] = ___('common.Storage_Settings');
            $data['data'] = $this->setting->getAll();
            return view('backend.settings.storage_setting', compact('data'));
        } catch (\Throwable $th) {
            return redirect('/')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function storageSettingUpdate(StorageUpdateRequest $request)
    {
        try {

            if (env('APP_DEMO')) {
                 return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
            }
            $result = $this->setting->storageSettingUpdate($request);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    // Storage setting start

    // seo setting start
    public function seoSetting()
    {
        $data['title'] = ___('common.Seo_Settings');
        $data['data'] = $this->setting->getAll();
        return view('backend.settings.seo_setting', compact('data'));
    }

    public function seoSettingUpdate(SettingStoreRequest $request)
    {

        try {

            if (env('APP_DEMO')) {
                 return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
            }
            $result = $this->setting->updateSeoSetting($request);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    // seo setting end

    // Twilio setting start
    public function twilioSettings()
    {
        Log::info('General setting');
        $data['title'] = ___('common.Twilio_Settings');
        $data['data'] = $this->setting->getAll();
        $data['timezones'] = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        return view('backend.settings.twilio-settings', compact('data'));
    }

    public function updateTwilioSetting(TwilioUpdateRequest $request)
    {
        try {
            if (env('APP_DEMO')) {
                return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
            }

            $result = $this->setting->updateTwilioSetting($request);
            // dd($result);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    // Twilio setting end
    
    // mail settings start
    public function mailSetting()
    {
        $data['title'] = ___('settings.Email_Settings');
        $data['data'] = $this->setting->getAll();
        return view('backend.settings.mail-settings', compact('data'));
    }

    public function updateMailSetting(EmailSettingStoreRequest $request)
    {

        try {

            if (env('APP_DEMO')) {
                 return redirect()->back()->with('danger',___('alert.you_can_not_change_in_demo_mode'));
            }

            $result = $this->setting->updateMailSetting($request);
            if ($result->original['result']) {
                return redirect()->back()->with('success', $result->original['message']);
            } else {
                return redirect()->back()->with('danger', $result->original['message']);
            }
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
    // mail settings end

    public function changeTheme(Request $request)
    {
        Cache::put('user_theme', $request->theme_mode);
        return true;
    }
}
