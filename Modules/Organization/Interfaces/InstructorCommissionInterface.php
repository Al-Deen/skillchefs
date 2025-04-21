<?php

namespace Modules\Organization\Interfaces;

use Illuminate\Http\Request;

interface InstructorCommissionInterface
{

    public function model();

    public function store($request);

    public function update($request, $course_id);
}
