<?php
namespace Admindashboard;
require_once __DIR__ . '/Admin.php';
require_once __DIR__ . '/../Database/Database.php';
use Database\Database;

class Menu extends Admin
{
    public function index():void
    {
        $db = new Database;
        $menus = $db->select("SELECT * FROM menus ORDER BY id DESC");
        extract(['menus' => $menus]);
        require dirname(__DIR__) . "/template/admin/menus/index.php";


    }
    public function show($id): void
    {
        $db = new Database();
        $menu = $db->select("SELECT * FROM `menus` WHERE `id` = ?", [$id]);
        require_once dirname(__FILE__, 2) . "/template/admin/menus/show.php";

    }

    public function create(): void
    {
        $db = new Database();
        $menu = $db->select("SELECT * FROM `menus` WHERE `parent_id` IS NULL;");
        require_once dirname(__FILE__, 2) . "/template/admin/menus/create.php";

    }

    public function store($request): void
    {
        $db = new Database();
        $db->insert('menus', array_keys(array_filter($request)), array_filter($request));
        $this->redirect('menu');

    }

    public function edit($id): void
    {
    $db = new Database();
    $topMenus = $db->select("SELECT * FROM `menus` WHERE `parent_id` IS NULL;");
    $menu = $db->select("SELECT * FROM `menus` WHERE `id` = ?", [$id])->fetch();

    if (!$menu) {
        $this->redirectBack();
        return;
    }
    require dirname(__DIR__) . "/template/admin/menus/edit.php";
    }

    public function update($request, $id): void
    {
        $db = new Database();
        $db->update('menus',$id , array_keys($request),$request);
        $this->redirect('menus');
    }

    public function delete($id): void
    {
        $db = new Database();
        $db->delete('menus', $id);
        $this->redirectBack();

    }

}