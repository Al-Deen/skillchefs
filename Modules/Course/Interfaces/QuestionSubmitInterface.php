<?php

namespace Modules\Course\Interfaces;

interface QuestionSubmitInterface
{

    public function model();

    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
