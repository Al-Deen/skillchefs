<?php

namespace Modules\Event\Interfaces;

interface EventOrganizerInterface{

    public function all();

    public function model();

    public function filter($request);

    public function store($request, $id);

    public function update($request, $id);

    public function destroy($id);
}
