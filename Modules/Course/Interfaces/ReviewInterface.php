<?php

namespace Modules\Course\Interfaces;

interface ReviewInterface
{

    public function model();

    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
