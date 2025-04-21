<?php

namespace Modules\CMS\Interfaces;

use Illuminate\Http\Request;

interface FooterInterface
{


    public function tableHeader();

    public function model();

    public function store($request);
    
    public function update($request);

    public function linkStore($request, $footer_menu_id);

    public function linkUpdate($request, $footer_menu_id, $linkId);

    public function linkDestroy($footer_menu_id, $linkId);


}
