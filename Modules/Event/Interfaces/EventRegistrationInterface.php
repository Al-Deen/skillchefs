<?php

namespace Modules\Event\Interfaces;

interface EventRegistrationInterface{

    public function all();

    public function model();

    public function store($request);

    public function storeFreeEvent($request);
}
