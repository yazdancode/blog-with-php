<?php

namespace Admindashboard;
require_once __DIR__ . '/../Database/Database.php';
use Database\Database;

class Auth
{
    public function login():void
    {
        require dirname(__DIR__) . "/template/auth/login.php";
    }
    public function check_login($request): void
    {
        if (empty($request['email']) || empty($request['password'])) {
            $this->redirectBack();
        }
        elseif (strlen($request['password']) < 8) {
            $this->redirectBack();
        }
        elseif (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            $this->redirectBack();
        }
        else {
            $db = new Database();
            $user = $db->select("SELECT * FROM users WHERE `email` = ?", [$request['email']]);

            if ($user && password_verify($request['password'], $user['password'])) {
                $_SESSION['user'] = $user['id'];
                $this->redirect('admin');
            } else {
                $this->redirectBack();
            }
        }
    }
    public function register():void
    {
        require dirname(__DIR__) . "/template/auth/register.php";
    }

    protected function redirect($url): void
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        header("Location: " . $protocol . $_SERVER['HTTP_HOST'] . "/admin-panel/" . $url);
    }

    protected function redirectBack(): void
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
        $this->redirect('dashboard');
    }

}