<?php

namespace Modules\Offline\Interfaces;

interface OfflineInterface
{
    public function model();
    public function approveCourseEnroll($order_id);

    public function approveEventRegistration($id);

    public function approvePackageEnroll($id);

    public function destroyCourseApproval($id);

    public function destroyEventApproval($id);

    public function destroyPackageApproval($id);
}
