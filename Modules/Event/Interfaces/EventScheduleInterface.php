<?php

namespace Modules\Event\Interfaces;

interface EventScheduleInterface{

    public function all();

    public function getActive();

    public function model();

    public function scheduleListModel();

    public function filter($request);

    public function store($request, $id);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    // Event List
    public function listUpdate($request, $id);

    public function listStore($request, $id);

    public function listDestroy($id);
}
