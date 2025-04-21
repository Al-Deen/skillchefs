<?php

namespace Modules\CMS\Interfaces;

interface FeaturedCourseInterface
{

    public function model();

    public function store($request);

    public function update($request, $id);

    public function destroy($id);

}
