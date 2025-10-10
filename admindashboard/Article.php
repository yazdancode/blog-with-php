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
        $db  = new Database();
        $article = $db->select('SELECT * FROM `articles` WHERE `id` = ?', [$id])[0];
        extract(['article' => $article]);
        require dirname(__DIR__) . "/template/admin/articles/show.php";
    }

    public function create(): void
    {
        $db = new Database();
        $categories = $db->select('SELECT * FROM `categories` ORDER BY `id` DESC;');
        require dirname(__DIR__) . "/template/admin/articles/create.php";
    }

    public function store($request): void
{
    $db = new Database();
    if (!empty($request['cat_id'])) {
        $savedImagePath = $this->saveImage($request['image'], 'article-image');
        if ($savedImagePath) {
            $request['image'] = $savedImagePath;
            $request['user_id'] = 1;
            $db->insert('articles', array_keys($request), $request);
        }
        else $this->redirectBack();
    }
    else{
        $this->redirectBack();
    }
}


    public function edit($id): void
    {
        $db = new Database();
        $article = $db->select('SELECT * FROM `articles` WHERE `id` = ?', [$id])[0];
        extract(['article' => $article]);
        require dirname(__DIR__) . "/template/admin/articles/edit.php";
    }

    public function update($request, $id): void
    {
        $db = new Database();
        $db->update('articles', $id, ['title', 'content'], [$request['title'], $request['content']]);
        header("Location: /project/article");
        exit;
    }

    public function delete($id): void
    {
        $db = new Database();
        $db->delete('articles', $id);
        header("Location: /project/article");
        exit;
    }
}
