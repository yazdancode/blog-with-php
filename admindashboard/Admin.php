<?php
namespace AdminDashboard;


class Admin
{
    protected function redirect($url): void
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        header("Location: " . $protocol . $_SERVER['HTTP_HOST'] . "/admin-panel" . $url);
        exit;
    }
    protected function redirectBack(): void
    {
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }

}
