<?php
namespace Admindashboard;
require_once __DIR__ . '/Admin.php';
require_once __DIR__ . '/../Database/Database.php';

use Database\Database;


class Article extends Admin
{
    public function index(): void
    {
        $db  = new Database();
        $articles = $db->select('SELECT * FROM `articles` ORDER BY `id` DESC;');
        require dirname(__DIR__) . "/template/admin/articles/index.php";
    }

    public function show($id): void
    {
        # code...
    }

    public function create()
    {

    }

    public function store($request): void
    {
        # code...
    }

    public function edit($id): void
    {
        # code...
    }
    public function update($request, $id): void
    {
        # code...
    }

    public function delete($id): void
    {
        # code...
    }

}