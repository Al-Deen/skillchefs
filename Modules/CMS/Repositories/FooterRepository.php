<?php

namespace Modules\CMS\Repositories;

use App\Traits\ApiReturnFormatTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Modules\CMS\Entities\FooterMenu;
use Modules\CMS\Interfaces\FooterInterface;

class FooterRepository implements FooterInterface
{
    use ApiReturnFormatTrait, FileUploadTrait;

    private $model;

    public function __construct(FooterMenu $footerMenu)
    {
        $this->model = $footerMenu;
    }

    public function tableHeader()
    {

        return [
            ___('common.ID'),
            ___('common.Name'),
            ___('common.Links'),
            ___('common.Column'),
            ___('common.status'),
            ___('common.action'),
        ];
    }

    public function model()
    {
        try {
            return $this->model;

        } catch (\Throwable $th) {

            return false;
        }

    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $footerMenu = $this->model;
            $footerMenu->name = $request->name;
            $footerMenu->column = @$this->model->max('column') + 1;
            $footerMenu->status_id = $request->status_id;
            $footerMenu->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Footer menu store successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function update($request)
    {
        DB::beginTransaction();
        try {
            $footerMenu = $this->model->find($request->id);
            if (!$footerMenu) {
                return $this->responseWithError(___('alert.Footer menu not found.'), [], 400);
            }
            $footerMenu->name = $request->name;
            $footerMenu->status_id = $request->status_id;
            $footerMenu->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Footer menu updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function linkStore($request, $footer_menu_id)
    {
        DB::beginTransaction();
        try {
            $footerMenu = $this->model->find($footer_menu_id);
            if (!$footerMenu) {
                return $this->responseWithError(___('alert.Footer menu not found.'), [], 400);
            }
            $links = json_decode($footerMenu->links, true);
            if ($request->is_page) {
                $links[] = [
                    'name' => $request->name,
                    'page_id' => $request->page_id,
                    'status_id' => $request->status_id,
                    'is_page' => $request->is_page,
                ];
            } else {
                $links[] = [
                    'name' => $request->name,
                    'link' => $request->link,
                    'status_id' => $request->status_id,
                ];
            }
            $footerMenu->links = $links;
            $footerMenu->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Footer link store successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function linkUpdate($request, $footer_menu_id, $linkId)
    {
        DB::beginTransaction();
        try {
            $footerMenu = $this->model->find($footer_menu_id);
            if (!$footerMenu) {
                return $this->responseWithError(___('alert.Footer menu not found.'), [], 400);
            }
            $footerLink = $footerMenu->allLink()[$linkId];
            if (!$footerLink) {
                return $this->responseWithError(___('alert.Footer link not found.'), [], 400);
            }
            $links = json_decode($footerMenu->links, true);
            if ($request->is_page) {
                $links[$linkId] = [
                    'name' => $request->name,
                    'page_id' => $request->page_id,
                    'status_id' => $request->status_id,
                    'is_page' => $request->is_page,
                ];
            } else {
                $links[$linkId] = [
                    'name' => $request->name,
                    'link' => $request->link,
                    'status_id' => $request->status_id,
                ];
            }
            $footerMenu->links = $links;
            $footerMenu->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Footer link updated successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }

    public function linkDestroy($footer_menu_id, $linkId)
    {
        DB::beginTransaction();
        try {
            $footerMenu = $this->model->find($footer_menu_id);
            if (!$footerMenu) {
                return $this->responseWithError(___('alert.Footer menu not found.'), [], 400);
            }
            $footerLink = $footerMenu->allLink()[$linkId];
            if (!$footerLink) {
                return $this->responseWithError(___('alert.Footer link not found.'), [], 400);
            }
            $links = json_decode($footerMenu->links, true);
            unset($links[$linkId]);
            $footerMenu->links = $links;
            $footerMenu->save();
            DB::commit();
            return $this->responseWithSuccess(___('alert.Footer link deleted successfully.'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
