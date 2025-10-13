<?php

namespace Admindashboard;
require_once __DIR__ . '/../Database/Database.php';
use Database\Database;

class Auth
{
    public function login(): void
    {
        require dirname(__DIR__) . "/template/auth/login.php";
    }

    public function check_login($request): void
    {
        if (empty($request['email']) || empty($request['password'])) {
            $this->redirectBack();
        }
        else
        {
            $db = new Database();
            $user = $db->select("SELECT * FROM users WHERE `email` = ?", [$request['email']]);
            if ($user && $this->verifyPassword($request['password'], $user['password'])) {
                $_SESSION['user'] = $user['id'];
                $this->redirect('admin');
            } else {
                $this->redirectBack();
            }
        }
    }

    public function register(): void
    {
        require dirname(__DIR__) . "/template/auth/register.php";
    }

    public function register_store($request): void
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
            $existingUser = $db->select("SELECT * FROM users WHERE `email` = ?", [$request['email']]);
            if ($existingUser) {
                $this->redirectBack();
                return;
            }
            $request['password'] = $this->hashPassword($request['password']);
            $db->insert('users', array_keys($request), $request);
            $this->redirect('login');
        }
    }

    public function hashPassword($password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('login');
    }

    public function checkAdmin(): bool
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('home');
            return false;
        }

        $db = new Database();
        $user = $db->select("SELECT * FROM users WHERE `id` = ?", [$_SESSION['user']]);
        if ($user === null || $user['permission'] !== 'admin') {
            $this->redirect('home');
            return false;
        }
        return true;
    }


    public function requireAdmin(): void
    {
        if (!$this->checkAdmin()) {
            exit;
        }
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    protected function redirect($url): void
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        header("Location: " . $protocol . $_SERVER['HTTP_HOST'] . "/admin-panel/" . $url);
        exit;
    }

    protected function redirectBack(): void
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
        $this->redirect('dashboard');
    }
}