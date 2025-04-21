<?php

namespace Modules\Addon\Interfaces;

interface AddonInterface
{

    public function model();

    public function store($request);

    public function status($id);
}
