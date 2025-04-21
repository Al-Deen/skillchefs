<?php

namespace Modules\Instructor\Interfaces;

use Illuminate\Http\Request;

interface InstructorInterface
{

    public function model();

    public function create($request);

    public function store($request);

    public function approve($id);

    public function suspend($id);

    public function reActivate($id);


    public function update($request, $id, $slug);


    public function updateProfile($request, $id);

    public function updatePassword($request, $user);

    public function addInstitute($request, $id);

    public function updateInstitute($request, $key, $id);

    public function deleteInstitute($key, $id);

    public function addExperience($request, $id);

    public function updateExperience($request, $key, $id);

    public function deleteExperience($key, $id);

    public function storeSkill($request, $id);

}
