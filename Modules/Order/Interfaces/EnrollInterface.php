<?php

namespace Modules\Order\Interfaces;

interface EnrollInterface
{

    public function all();

    public function tableHeader();

    public function model();

    public function filter($request);

    public function store($request);
    
    public function update($request);

    public function visited($enroll);
}
