<?php

namespace App\Interfaces;

use App\Http\Requests\SettingStoreRequest;

interface SettingInterface{

    public function getAll();

    public function getLanguage();

    public function getCountry();

    public function getCurrency();

    public function getDateFormat();

    public function updateSeoSetting(SettingStoreRequest $request);

    public function storageSettingUpdate($request);

    public function updateMailSetting($request);

    public function updateGeneralSetting($request);

    public function updateTwilioSetting($request);
}
