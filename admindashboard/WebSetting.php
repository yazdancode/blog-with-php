<?php
namespace Admindashboard;

require_once __DIR__ . '/Admin.php';
require_once __DIR__ . '/../Database/Database.php';
use Database\Database;

class WebSetting extends Admin
{
    public function index(): void
    {
        $db = new Database();
        $setting = $db->select("SELECT * FROM websetting LIMIT 1");
        require dirname(__DIR__) . "/template/admin/web-setting/index.php";
    }

    public function set(): void
    {
        $db = new Database();
        $setting = $db->select("SELECT * FROM websetting LIMIT 1");
        require dirname(__DIR__) . "/template/admin/web-setting/set.php";
    }

    public function store(array $request): void
    {
        $db = new Database();
        $setting = $db->select("SELECT * FROM websetting LIMIT 1");
        $settingExists = !empty($setting);
        $settingId = $settingExists ? $setting[0]['id'] : null;
        if (isset($request['logo']) && !empty($request['logo']['tmp_name'])) {
            $request['logo'] = $this->saveImage($request['logo'], 'setting', 'logo');
        } else {
            unset($request['logo']);
        }
        if (isset($request['icon']) && !empty($request['icon']['tmp_name'])) {
            $request['icon'] = $this->saveImage($request['icon'], 'setting', 'icon');
        } else {
            unset($request['icon']);
        }
        if (isset($request['logo']['tmp_name'])) {
            unset($request['logo']['tmp_name']);
        }
        if (isset($request['icon']['tmp_name'])) {
            unset($request['icon']['tmp_name']);
        }
        if ($settingExists) {
            $db->update('websetting', $settingId, array_keys($request), $request);
        } else {
            $db->insert('websetting', array_keys($request), $request);
        }
        $this->redirect('web-setting');
    }
}
