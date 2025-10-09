<?php

namespace AdminDashboard;

require_once __DIR__ . '/Admin.php';
require_once __DIR__ . '/../Database/Database.php';

use Database\Database;


class Category extends Admin
{
    public function index(): void
    {
        $db = new Database();
        $categories = $db->select("SELECT * FROM categories ORDER BY id DESC");
        extract(['categories' => $categories]);
        require dirname(__DIR__) . "/template/admin/categories/index.php";
    }

    public function show($id): void
    {
        $db = new Database();
        $result = $db->select("SELECT * FROM `categories` WHERE `id` = ?", [$id]);
        require_once dirname(__FILE__, 2) . "/template/admin/categories/show.php";

    }

    public function create():void
    {
        require_once dirname(__FILE__, 2) . "/template/admin/categories/create.php";

    }

    public function store($request):void
    {
        $db = new Database();
        $db->insert('categories', array_keys($request), $request);
        $this->redirect('category');
    }

    public function edit($id): void
    {
    $db = new Database();
    $category = $db->select("SELECT * FROM categories WHERE id = ?", [$id])[0];
    extract(['category' => $category]);
    require dirname(__DIR__) . "/template/admin/categories/edit.php";
    }

    public function update($request, $id): void
    {
    $db = new Database();
    $db->update('categories', $id, ['name'], [$request['name']]);
    header("Location: /project/category");
    exit;
    }


    public function delete($id):void
    {
        $db = new Database();
        $db->delete('categories', $id);
        $this->redirectBack();
    }
}