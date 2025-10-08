<?php

namespace AdminDashboard;


use Database\Database;

class Category extends Admin
{
    public function index():void
    {
        $db = new Database();
        $category = $db->select("SELECT * FROM `categories` ORDER BY `id` DESC;");
        require_once realpath(__FILE__). "../template/admin/categories/index.php";

    }

    public function show($id): void
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM `categories` WHERE `id` = ?", [$id]);
        require_once realpath(__FILE__). "../template/admin/categories/show.php";

    }


    public function create():void
    {
        require_once realpath(__FILE__). "../template/admin/categories/create.php";

    }

    public function store($request):void
    {
        $db = new Database();
        $db->insert('categories',array_keys($request), $request);
        $this->redirect('category');
    }

    public function edit($id):void
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM `categories` WHERE `id` = ?", [$id]);
        require_once realpath(__FILE__). "../template/admin/categories/edit.php";
    }

    public function update($request, $id):void
    {
        $db = new Database();
        $db->update('categories', $id, array_keys($request), $request);
        $this->redirect('category');
    }

    public function delete($id):void
    {
        $db = new Database();
        $db->delete('categories', $id);
        $this->redirectBack();
    }

}