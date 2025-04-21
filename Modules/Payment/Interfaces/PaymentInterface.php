<?php

namespace Modules\Payment\Interfaces;

interface PaymentInterface
{

    public function all();

    public function tableHeader();

    public function model();

    public function withoutRedirect();

    public function findPaymentMethod($paymentMethod);
    
    public function findAdminPaymentMethod($paymentMethod);
    
    public function findApiPaymentMethod($paymentMethod);

    public function filter($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
