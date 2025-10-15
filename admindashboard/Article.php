<?php
namespace Admindashboard;

require_once __DIR__ . '/Admin.php';
require_once __DIR__ . '/../Database/Database.php';

use Database\Database;

class Article extends Admin
{
    public function index(): void
    {
        $db = new Database();
        $articles = $db->select('SELECT * FROM `articles` ORDER BY `id` DESC');
        require dirname(__DIR__) . "/template/admin/articles/index.php";
    }

    public function show($id): void
    {
        $db = new Database();
        $articles = $db->select('SELECT * FROM `articles` WHERE `id` = ?', [$id]);
        if ($articles === null) {
            $this->redirectBack();
            return;
        }
        $article = $articles[0];
        require dirname(__DIR__) . "/template/admin/articles/show.php";
    }

    public function create(): void
    {
        $db = new Database();
        $categories = $db->select('SELECT * FROM `categories` ORDER BY `id` DESC');
        require dirname(__DIR__) . "/template/admin/articles/create.php";
    }

    public function store($request): void
    {
        $db = new Database();

        if (empty($request['cat_id']) || !isset($request['image']) || !is_array($request['image'])) {
            $this->redirectBack();
            return;
        }

        $savedImagePath = $this->saveImage($request['image'], 'article-image');
        if (!$savedImagePath) {
            $this->redirectBack();
            return;
        }

        $request['image'] = $savedImagePath;
        $request['user_id'] =$_SESSION['user'];

        $db->insert('articles', array_keys($request), $request);
        $this->redirect('article');
    }

    public function edit($id): void
    {
        $db = new Database();
        $articles = $db->select('SELECT * FROM `articles` WHERE `id` = ?', [$id]);
        if ($articles === null) {
            $this->redirectBack();
            return;
        }

        $article = $articles[0];
        $categories = $db->select('SELECT * FROM `categories` ORDER BY `id` DESC');
        require dirname(__DIR__) . "/template/admin/articles/edit.php";
    }

    public function update($request, $id): void
    {
        $db = new Database();

        if (empty($request['cat_id'])) {
            $this->redirectBack();
            return;
        }

        $articles = $db->select('SELECT * FROM `articles` WHERE `id` = ?', [$id]);
        if ($articles === null) {
            $this->redirectBack();
            return;
        }

        $article = $articles[0];

        if (isset($request['image']) && is_array($request['image']) && is_uploaded_file($request['image']['tmp_name'])) {
            $savedImagePath = $this->saveImage($request['image'], 'article-image');
            if ($savedImagePath) {
                if (!empty($article['image'])) {
                    $this->removeImage($article['image']);
                }
                $request['image'] = $savedImagePath;
            }
        } else {
            $request['image'] = $article['image'];
        }

        $request['user_id'] = $_SESSION['user'];
        $db->update('articles', array_keys($request), $request, $id);
        $this->redirect('article');
    }

    public function delete($id): void
    {
        $db = new Database();
        $articles = $db->select('SELECT * FROM `articles` WHERE `id` = ?', [$id]);
        if ($articles !== null && !empty($articles[0]['image'])) {
            $this->removeImage($articles[0]['image']);
        }

        $db->delete('articles', $id);
        $this->redirect('article');
    }
}
