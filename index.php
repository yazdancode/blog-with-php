<?php
require_once __DIR__ . '/admindashboard/Category.php';
require_once __DIR__ . '/Database/CreateDB.php';

use AdminDashboard\Category;

$category = new Category();
$category->store(['name' => ['sport']]);

