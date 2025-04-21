<?php

namespace Modules\CMS\Interfaces;

use Illuminate\Http\Request;

interface HomeSectionInterface
{


    public function tableHeader();

    public function model();

    public function store($request);

    public function update($request, $id);


}
