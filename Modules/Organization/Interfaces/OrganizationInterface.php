<?php

namespace Modules\Organization\Interfaces;

use Illuminate\Http\Request;

interface OrganizationInterface
{

    public function model();

    public function create($request);

    public function suspend($id);

    public function reActivate($id);

    public function approve($id);

    public function update($request, $id, $slug);

    public function updateProfile($request, $id);

    public function updatePassword($request, $user);

    public function delete($id);

    public function storeSkill($request, $id);

}
