<?php

namespace Modules\Event\Interfaces;

interface EventCategoryInterface{

    public function all();

    public function getActive();

    public function tableHeader();

    public function model();

    public function filter($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function catArr();
}
