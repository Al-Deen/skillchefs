<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\Role;
use App\Traits\ApiReturnFormatTrait;

class RoleRepository implements RoleInterface
{

    use ApiReturnFormatTrait;

    private $model;

    public function __construct(Role $roleModel)
    {
        $this->model = $roleModel;
    }

    public function model()
    {
        return $this->model;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getAll()
    {
        return Role::latest()->paginate(10);
    }

    public function store($request)
    {
        try {
            $roleStore = new $this->model;
            $roleStore->name = $request->name;
            $roleStore->status = $request->status;
            $roleStore->permissions = $request->permissions;
            $roleStore->save();
            return $this->responseWithSuccess(___('alert.role_created_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.role_created_failed'));
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {

        try {
            $roleUpdate = $this->model->findOrfail($id);
            $roleUpdate->name = $request->name;
            $roleUpdate->status = $request->status;
            $roleUpdate->permissions = $request->permissions;
            $roleUpdate->save();
            return $this->responseWithSuccess(___('alert.role_updated_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.role_created_failed'));
        }
    }

    public function destroy($id)
    {
        try {
            $roleDestroy = $this->model->find($id);
            $roleDestroy->delete();
            return $this->responseWithSuccess(___('alert.role_deleted_successfully'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.role_deleted_failed'));
        }
    }
}
