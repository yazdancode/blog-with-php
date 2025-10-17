<?php

namespace Admindashboard;
require_once __DIR__ . '/Admin.php';
require_once __DIR__ . '/../Database/Database.php';

use Database\Database;
class Comment extends Admin
{
    public function index(): void
    {
        $db = new Database();
        $comments = $db->select("SELECT * FROM comments ORDER BY id DESC");
        foreach ($comments as $comment) {
            if ($comment['status'] === 'disable') {
                $db->update('comments', $comment['id'], ['status'], ['enable']);
            }
        }
        $comments = $db->select("SELECT * FROM comments ORDER BY id DESC");
        require dirname(__DIR__) . "/template/admin/comments/index.php";
    }

    public function show($id):void
    {
        $db = new Database();
        $comment = $db->select("SELECT * FROM comments WHERE id = ?", [$id])->fetch();
        require_once dirname(__FILE__) . "/template/admin/comments/show.php";
    }

    public function approved($id)  
    {
    $db = new Database();
    $comment = $db->select("SELECT * FROM comments WHERE id = ?", [$id])->fetch();

    if ($comment['status'] === 'approved') {
        $db->update('comments', $id, ['status'], ['enable']);
    } else {
        $db->update('comments', $id, ['status'], ['approved']);
    }
    $this->redirectBack();
    }
}