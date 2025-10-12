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

        // --- ذخیره‌ی لوگو ---
        if (isset($request['logo']) && !empty($request['logo']['tmp_name'])) {
            $request['logo'] = $this->saveImage($request['logo'], 'setting', 'logo');
        } else {
            unset($request['logo']);
        }

        // --- ذخیره‌ی آیکون ---
        if (isset($request['icon']) && !empty($request['icon']['tmp_name'])) {
            $request['icon'] = $this->saveImage($request['icon'], 'setting', 'icon');
        } else {
            unset($request['icon']);
        }

        // حذف مقادیر فایل اضافی برای جلوگیری از خطا
        if (isset($request['logo']['tmp_name'])) {
            unset($request['logo']['tmp_name']);
        }
        if (isset($request['icon']['tmp_name'])) {
            unset($request['icon']['tmp_name']);
        }

        // --- درج یا به‌روزرسانی در دیتابیس ---
        if ($settingExists) {
            $db->update('websetting', $settingId, array_keys($request), $request);
        } else {
            $db->insert('websetting', array_keys($request), $request);
        }

        // --- ریدایرکت به صفحه تنظیمات ---
        $this->redirect('web-setting');
    }
}
