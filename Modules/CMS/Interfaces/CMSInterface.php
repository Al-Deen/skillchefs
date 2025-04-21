<?php

namespace Modules\CMS\Interfaces;

use Illuminate\Http\Request;

interface CMSInterface
{


    public function tableHeader();

    public function model();

    public function update($request);


}
