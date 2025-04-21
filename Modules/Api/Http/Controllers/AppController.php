<?php

namespace Modules\Api\Http\Controllers;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\CommonHelperTrait;
use Illuminate\Routing\Controller;
use Modules\Api\Interfaces\SettingsInterface;

class AppController extends Controller
{
    use ApiReturnFormatTrait, CommonHelperTrait;

    protected $settings;

    public function __construct(SettingsInterface $settingInterface)
    {
        $this->settings = $settingInterface;
    }

    public function dashboard()
    {
        try {
            $result = $this->settings->dashboard();
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }

    public function baseSettings()
    {
        try {
            $result = $this->settings->baseSettings();
            if ($result->original['result']) {
                return $this->responseWithSuccess($result->original['message'], $result->original['data']);
            } else {
                return $this->responseWithError($result->original['message'], [], 400); // return error response
            }
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), [], 400); // return error response
        }
    }
}
