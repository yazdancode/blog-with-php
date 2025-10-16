<?php
namespace Admindashboard;
require_once __DIR__ . '/../Database/Database.php';
use Database\Database;

class Home
{
    public function index(): void
    {
        $db = new Database();

        $articlesStmt = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count,(SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles ORDER BY created_at DESC LIMIT 6");
        $articles = $articlesStmt ? $articlesStmt->fetchAll() : [];

        $popularStmt = $db->select("SELECT articles.*, (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count,(SELECT username FROM users WHERE users.id = articles.user_id) AS username FROM articles ORDER BY view DESC LIMIT 4");
        $popularArticles = $popularStmt ? $popularStmt->fetchAll() : [];

        $sidebarPopularArticles = $popularArticles;

        $categoriesStmt = $db->select("SELECT * FROM categories ORDER BY id DESC;");
        $categories = $categoriesStmt ? $categoriesStmt->fetchAll() : [];

        $menusStmt = $db->select("SELECT menus.*, (SELECT COUNT(*) FROM menus AS submenus WHERE submenus.parent_id = menus.id) AS submenu_count FROM menus WHERE parent_id IS NULL");
        $menus = $menusStmt ? $menusStmt->fetchAll() : [];
        $submenusStmt = $db->select('SELECT * FROM menus WHERE parent_id IS NOT NULL;');
        $submenus = $submenusStmt ? $submenusStmt->fetchAll() : [];
        require_once (realpath(__DIR__). "/../template/app/index.php");
    }
    public function show($id): void
    {
        $db = new Database();
        $article = $db->select('SELECT * FROM articles WHERE id = ?;', [$id])->fetch();
        if (!$article) {
            http_response_code(404);
            echo "Article not found";
            return;
        }
        $username = $db->select('SELECT username FROM users WHERE id = ?;', [$article['user_id']])->fetch();
        $commentsCount = $db->select('SELECT COUNT(*) as count FROM comments WHERE article_id = ?;', [$id])->fetch();
        $comments = $db->select(
            'SELECT comments.*, users.username 
         FROM comments 
         JOIN users ON users.id = comments.user_id 
         WHERE article_id = ? 
         ORDER BY comments.created_at DESC;',
            [$id]
        )->fetchAll();
        $db->execute('UPDATE articles SET view = view + 1 WHERE id = ?;', [$id]);
        $popularArticles = $db->select(
            'SELECT articles.*, 
                (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count  
         FROM articles  
         ORDER BY comments_count DESC 
         LIMIT 4;'
        )->fetchAll();
        $sidebarPopularArticles = $popularArticles;
        $categories = $db->select('SELECT * FROM categories ORDER BY id DESC;')->fetchAll();
        $menus = $db->select(
            'SELECT menus.*, 
                (SELECT COUNT(*) FROM menus AS submenus WHERE submenus.parent_id = menus.id) AS submenus_count 
         FROM menus 
         WHERE parent_id IS NULL 
         ORDER BY id ASC;'
        )->fetchAll();
        $submenus = $db->select('SELECT * FROM menus WHERE parent_id IS NOT NULL;')->fetchAll();
        require_once(realpath(__DIR__) . "/../template/app/show-article.php");
    }

    public function category($id): void
    {
        $db = new Database();

        $categoryStmt = $db->select('SELECT * FROM categories WHERE id = ? ORDER BY id DESC;', [$id]);
        $category = $categoryStmt ? $categoryStmt->fetchAll() : [];

        $articlesStmt = $db->select('
        SELECT articles.*, 
               (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count,
               (SELECT username FROM users WHERE users.id = articles.user_id) AS username 
        FROM articles 
        WHERE articles.cat_id = ?', [$id]);
        $articles = $articlesStmt ? $articlesStmt->fetchAll() : [];

        $popularStmt = $db->select('
        SELECT articles.*, 
               (SELECT COUNT(*) FROM comments WHERE comments.article_id = articles.id) AS comments_count 
        FROM articles 
        ORDER BY comments_count DESC 
        LIMIT 5;');
        $popularArticles = $popularStmt ? $popularStmt->fetchAll() : [];

        $sidebarPopularArticles = $popularArticles;

        $categoriesStmt = $db->select('SELECT * FROM categories ORDER BY id DESC;');
        $categories = $categoriesStmt ? $categoriesStmt->fetchAll() : [];

        $menusStmt = $db->select('
        SELECT *, 
               (SELECT COUNT(*) FROM menus AS submenus WHERE submenus.parent_id = menus.id) AS submenu_count 
        FROM menus 
        WHERE parent_id IS NULL;');
        $menus = $menusStmt ? $menusStmt->fetchAll() : [];

        $submenusStmt = $db->select('SELECT * FROM menus WHERE parent_id IS NOT NULL;');
        $submenus = $submenusStmt ? $submenusStmt->fetchAll() : [];

        $templatePath = dirname(__DIR__) . '/template/app/show-category.php';
        if (file_exists($templatePath)) {
            require_once($templatePath);
        } else {
            echo "Template not found.";
        }
    }



    public function comment_store($request):void
    {
        session_start();
        if(isset($_SESSION['user'])){
            if($_SESSION['user'] != null)
            {
                $db = new Database();
                $db->insert('comments', ['user_id', 'article_id','comment'], [$_SESSION['user'], $request['article'], $request['comment']]);
                $this->redirectBack();
            }
            else
            {
                $this->redirectBack();
            }
        }
        else
        {
            $this->redirectBack();
        }
    }

    protected function redirectBack():void
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

}