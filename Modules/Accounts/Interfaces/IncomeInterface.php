<?php

namespace Modules\Accounts\Interfaces;

interface IncomeInterface
{

    public function model();

    public function store($request);

    public function revenue();
}
