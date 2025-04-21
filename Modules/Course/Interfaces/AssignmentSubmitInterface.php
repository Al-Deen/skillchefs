<?php

namespace Modules\Course\Interfaces;

interface AssignmentSubmitInterface
{


    public function model();

    public function store($request, $enroll_id, $assignment_id);

    public function review($request, $assignment_id);
}
