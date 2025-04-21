<?php

namespace Modules\Event\Interfaces;

interface EventInterface{

    // public function all();

    // public function getActive();

    public function tableHeader();

    public function model();

    public function filter($request);

    public function store($request);

    public function dateTime($type, $data);

    // public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function approve($event_id);

    public function reject($event_id);
}
