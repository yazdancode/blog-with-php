<?php

namespace Admindashboard;
require_once __DIR__ . '/../Database/Database.php';
use Database\Database;

class Home
{
    public function index(): void
    {
        $db = new Database();

        $articlesStmt = $db->select("
        SELECT 
            articles.*, 
            (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count,
            (SELECT username FROM users WHERE users.id = articles.user_id) AS username 
        FROM articles 
        ORDER BY created_at DESC 
        LIMIT 6
    ");
        $articles = $articlesStmt ? $articlesStmt->fetchAll() : [];

        $popularStmt = $db->select("
        SELECT 
            articles.*, 
            (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count,
            (SELECT username FROM users WHERE users.id = articles.user_id) AS username
        FROM articles
        ORDER BY view DESC
        LIMIT 4
    ");
        $popularArticles = $popularStmt ? $popularStmt->fetchAll() : [];

        $sidebarPopularArticles = $popularArticles;

        $categoriesStmt = $db->select("SELECT * FROM categories ORDER BY id DESC;");
        $categories = $categoriesStmt ? $categoriesStmt->fetchAll() : [];

        $menusStmt = $db->select("
        SELECT 
            menus.*, 
            (
                SELECT COUNT(*) 
                FROM menus AS submenus 
                WHERE submenus.parent_id = menus.id
            ) AS submenu_count 
        FROM menus 
        WHERE parent_id IS NULL
    ");
        $menus = $menusStmt ? $menusStmt->fetchAll() : [];
        $submenusStmt = $db->select('SELECT * FROM menus WHERE parent_id IS NOT NULL;');
        $submenus = $submenusStmt ? $submenusStmt->fetchAll() : [];
        require_once (realpath(__DIR__). "/../template/app/index.php");
    }
    public function show($id):void
    {
        
    }

    public function category($id):void
    {
        
    }

    public function comment_store($request):void
    {

    }

    protected function redirectBack():void
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

}