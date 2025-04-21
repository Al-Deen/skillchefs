<?php

namespace Modules\Instructor\Interfaces;

interface PayoutInterface
{

    public function all();

    public function model();

    public function filter($request);

    public function store($request);

    public function approve($id);

    public function reject($request, $id);

    public function logCreate($data);
}
