<?php

namespace Modules\Accounts\Interfaces;

interface AccountInterface
{


    public function model();

    public function transactionModel();

    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
