<?php

namespace AdminDashboard;


use Database\Database;

class Category extends Admin
{
    public function index():void
    {
        $db = new Database();
        $category = $db->select("SELECT * FROM `categories` ORDER BY `id` DESC;");

    }

    public function show($id): void
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM `categories` WHERE `id` = ?", [$id]);

    }


    public function create():void
    {

    }

    public function store($request):void
    {
        $db = new Database();
        $db->insert('categories',array_keys($request), $request);
    }

    public function edit($id):void
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM `categories` WHERE `id` = ?", [$id]);
    }

    public function update($request, $id):void
    {
        $db = new Database();
        $db->update('categories', $id, array_keys($request), $request);
    }

    public function delete($id):void
    {
        $db = new Database();
        $db->delete('categories', $id);
    }

}