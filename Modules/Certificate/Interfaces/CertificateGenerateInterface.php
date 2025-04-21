<?php

namespace Modules\Certificate\Interfaces;

interface CertificateGenerateInterface
{

    public function model();

    public function certificate($enroll_id);

    public function adminCertificate($enroll_id);
    
    public function store($request);

    public function update($request, $id);

    public function destroy($id);
}
