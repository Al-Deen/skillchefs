<?php

namespace App\Interfaces;

interface RoleInterface
{

    public function all();
    
    public function model();

    public function getAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
