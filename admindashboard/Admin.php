<?php
namespace AdminDashboard;

use RuntimeException;

class Admin
{
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

    protected function saveImage($image, $imagePath, $imagename = null)
    {
        // بررسی وجود کلیدهای لازم
        if (!isset($image['tmp_name'], $image['name'], $image['type'])) {
            return false;
        }
        $imageInfo = getimagesize($image['tmp_name']);
        if ($imageInfo === false) {
            return false;
        }
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        if ($imagename) {
            $imagename = preg_replace('/[^a-zA-Z0-9-_]/', '', $imagename);
            $imagename .= '.' . $extension;
        } else {
            $imagename = date('Y-m-d-H-i-s') . '.' . $extension;
        }
        $imagePath = rtrim('public/' . $imagePath, '/') . '/';
        if (!is_dir($imagePath) && !mkdir($imagePath, 0755, true) && !is_dir($imagePath)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $imagePath));
        }
        if (is_uploaded_file($image['tmp_name']) && move_uploaded_file($image['tmp_name'], $imagePath . $imagename)) {
            return $imagePath . $imagename;
        }

        return false;
    }

    protected function removeImage($path): bool
    {
    if (empty($path)) {
        return false;
    }
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($path, '/');
    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }

    return false;
    }

}
