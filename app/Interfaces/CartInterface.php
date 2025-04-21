<?php

namespace App\Interfaces;


interface CartInterface
{
    public function model();

    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
