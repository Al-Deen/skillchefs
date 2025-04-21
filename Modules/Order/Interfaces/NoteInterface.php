<?php

namespace Modules\Order\Interfaces;

interface NoteInterface
{

    public function model();

    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
