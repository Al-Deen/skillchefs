<?php

namespace Modules\Api\Interfaces;

use Illuminate\Http\Request;

interface BookmarkInterface
{
    public function model();

    public function update($id);
}
