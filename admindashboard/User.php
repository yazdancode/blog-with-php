<?php
namespace Admindashboard;
require_once __DIR__ . '/Admin.php';
require_once __DIR__ . '/../Database/Database.php';
use Database\Database;

class User extends Admin
{
    public function index():void
    {
        $db = new Database();
        $users = $db->select("SELECT * FROM users ORDER BY id DESC;");
        require dirname(__DIR__) . "/template/admin/users/index.php";
    }
    public function permission($id):void
    {
        $db= new Database();
        $user = $db->select('SELECT * FROM users WHERE id = ?', [$id]);
        if($user['permission'] === 'admin')
        {
            $db->update('users', $id, ['permission'], ['user']);
        }
        else
        {
            $db->update('users', $id, ['permission'], ['admin']);
        }
        $this->redirectBack();
    }
    public function edit($id):void
    {
        $db = new Database();
        $user = $db->select("SELECT * FROM users WHERE id = ?", [$id])[0];
        extract(['category' => $user]);
        require dirname(__DIR__) . "/template/admin/users/edit.php";
    }

    public function update($request, $id):void
    {
        $db = new Database();
        $db->update('users', $id, ['name'], [$request['name']]);
        header("Location: /project/user");
        exit;
        
    }
    public function delete($id):void
    {
        $db = new Database();
        $db->delete('users', $id);
        $this->redirectBack();
    }



}