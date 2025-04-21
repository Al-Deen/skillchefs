<?php

namespace Modules\Accounts\Interfaces;

interface ExpenseInterface
{

    public function model();

    public function store($request);
}
