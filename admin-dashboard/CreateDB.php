<?php
namespace Database;
require_once(realpath(__DIR__) . "/Database.php");

class CreateDB extends Database
{
    private array $createTableQueries = array(
        "CREATE TABLE `categories` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(200) COLLATE utf8_persian_ci NOT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci",

        "CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(100) COLLATE utf8_persian_ci NOT NULL,
            `email` varchar(150) COLLATE utf8_persian_ci NOT NULL,
            `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
            `permission` enum('user', 'admin') NOT NULL DEFAULT 'user',
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
            UNIQUE KEY 'email' ('email')
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci",

        "CREATE TABLE `articles` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
            `summary` text COLLATE utf8_persian_ci,
            `body` text COLLATE utf8_persian_ci,
            `view` int(11) DEFAULT 0,
            `user_id` int(11) NOT NULL,
            `cat_id` int(11) NOT NULL,
            `image` varchar(255) COLLATE utf8_persian_ci,
            `status` enum('disable', 'enable') NOT NULL DEFAULT 'disable',
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
            FOREIGN KEY (`cat_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci",

        "CREATE TABLE `comments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `article_id` int(11) NOT NULL,
            `comment` text COLLATE utf8_persian_ci NOT NULL,
            `status` enum('disable', 'enable') NOT NULL DEFAULT 'disable',
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
            FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci",

        "CREATE TABLE `websetting` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
            `description` text COLLATE utf8_persian_ci,
            `keywords` varchar(255) COLLATE utf8_persian_ci,
            `logo` varchar(255) COLLATE utf8_persian_ci,
            `icon` varchar(255) COLLATE utf8_persian_ci,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci",

        "CREATE TABLE `menus` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
            `url` varchar(255) COLLATE utf8_persian_ci NOT NULL,
            `parent_id` int(11) DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`parent_id`) REFERENCES `menus`(`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci"
    );

    public function initializeDatabase(): void
    {
        $this->connect();
        foreach ($this->createTableQueries as $query) {
            $this->createTable($query);
        }
    }
}
