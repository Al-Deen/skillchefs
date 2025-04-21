<?php

namespace Modules\Api\Interfaces;

use Illuminate\Http\Request;

interface SettingsInterface
{
    public function model();

    public function dashboard();

    public function baseSettings();
}
