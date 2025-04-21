<?php

namespace Modules\Instructor\Interfaces;

interface InstructorPaymentMethodInterface
{

    public function all();

    public function model();

    public function filter($request);

    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
