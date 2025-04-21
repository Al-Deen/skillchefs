<?php

namespace Modules\Api\Interfaces;

use Illuminate\Http\Request;

interface AssignmentInterface
{
    public function model();

    public function assignmentModel();

    public function store($request, $assignment_id);
}
