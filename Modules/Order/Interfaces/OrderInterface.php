<?php

namespace Modules\Order\Interfaces;

interface OrderInterface
{

    public function all();

    public function tableHeader();

    public function model();

    public function orderItemModel();

    public function filter($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function monthlySales($enroll);

    public function instructorMonthlySales($enroll);

    public function organizationMonthlySales($enroll);
}
