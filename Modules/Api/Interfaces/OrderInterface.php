<?php

namespace Modules\Api\Interfaces;

interface OrderInterface
{

    public function all();

    public function model();

    public function filter($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function monthlySales($enroll);

    public function instructorMonthlySales($enroll);
}
