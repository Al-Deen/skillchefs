<?php

namespace Modules\Course\Interfaces;

interface BookmarkInterface
{

    public function model();

    public function store($request);

    public function destroy($id);
}
