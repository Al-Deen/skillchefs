<?php

namespace Modules\Api\Interfaces;

use Illuminate\Http\Request;

interface ProfileInterface
{
    public function model();

    public function updateProfile($request);

    public function updatePassword($request);
}
