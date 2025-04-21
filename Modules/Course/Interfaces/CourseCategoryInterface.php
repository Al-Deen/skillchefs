<?php

namespace Modules\Course\Interfaces;

interface CourseCategoryInterface
{

    public function all();

    public function model();

    public function filter($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function popularStatus($id);

    public function popularCategory();
}
