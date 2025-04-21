<?php

namespace Modules\Course\Interfaces;

interface CourseInterface
{

    public function all();

    public function tableHeader();

    public function model();

    public function params($request);

    public function filter($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function courseDiscount($request);

    public function courseDiscountDestroy($id);

    //Use this method for Home api
    public function getCourse($request, $allowArray);

    public function filterCourse($request, $data);
    //Use this method for Home api
}
