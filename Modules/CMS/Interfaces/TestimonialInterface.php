<?php

namespace Modules\CMS\Interfaces;

interface TestimonialInterface
{

    public function model();

    public function store($request);

    public function update($request, $id);

    public function destroy($id);

}
