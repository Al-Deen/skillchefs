<?php

namespace Modules\Course\Interfaces;

interface QuizInterface
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
}
