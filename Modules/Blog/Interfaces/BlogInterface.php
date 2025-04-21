<?php

namespace Modules\Blog\Interfaces;

use Illuminate\Http\Request;

interface BlogInterface
{

    public function getAll($request);

    public function all();

    public function tableHeader();

    public function model();

    public function filter($request, $data);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    // Front end method
    public function homeBlog();

    public function latestBlog();

    public function getBlogs();
     // Front end method
}
