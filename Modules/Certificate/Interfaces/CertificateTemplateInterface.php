<?php

namespace Modules\Certificate\Interfaces;

interface CertificateTemplateInterface
{

    public function model();

    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
