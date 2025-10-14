<?php
require_once __DIR__ . '/admindashboard/Category.php';
require_once __DIR__ . '/admindashboard/Menu.php';
require_once __DIR__ . '/admindashboard/WebSetting.php';
require_once __DIR__ . '/admindashboard/User.php';
require_once __DIR__ . '/Admindashboard/Auth.php';
require_once __DIR__ . '/Admindashboard/Home.php';
require_once __DIR__ . '/Database/CreateDB.php';

function uri($uriPattern, $className, $methodName, $requestMethod = 'GET')
{
    $params = [];
    $patternParts = explode('/', trim($uriPattern, '/'));
    $cleanUri = str_replace('/project/', '', $_SERVER['REQUEST_URI']);
    $requestParts = explode('/', trim($cleanUri, '/'));
    if (count($patternParts) !== count($requestParts) || $_SERVER['REQUEST_METHOD'] !== $requestMethod) {
        return;
    }
    foreach ($patternParts as $index => $part) {
        if (preg_match('/^{\w+}$/', $part)) {
            $params[] = $requestParts[$index];
        } elseif ($part !== $requestParts[$index]) {
            return;
        }
    }
    $fullClassName = "AdminDashboard\\$className";
    $object = new $fullClassName();

    if ($requestMethod === 'POST') {
        $requestData = $_POST;
        if (!empty($_FILES)) {
            $requestData = array_merge($requestData, $_FILES);
        }

        if (!empty($params)) {
            $object->$methodName($requestData, implode(',', $params));
        } else {
            $object->$methodName($requestData);
        }
    } else if (!empty($params)) {
        $object->$methodName(implode(',', $params));
    } else {
        $object->$methodName();
    }
}


// مسیرهای دسته‌بندی
uri('category', 'Category','index');
uri('category/create', 'Category','create');
uri('category/store', 'Category','store', 'POST');
uri('category/edit/{id}', 'Category','edit');
uri('category/update/{id}', 'Category','update', 'POST');
uri('category/delete/{id}', 'Category','delete');


// روتر مقاله
uri('articles', 'Article','index');
uri('articles/create', 'Article','create');
uri('articles/store', 'Article','store', 'POST');
uri('articles/edit/{id}', 'Article','edit');
uri('articles/update/{id}', 'Article','update', 'POST');
uri('articles/delete/{id}', 'Article','delete');


// روتر menu
uri('menu', 'Menu','index');
uri('menu/create', 'Menu','create');
uri('menu/store', 'Menu','store', 'POST');
uri('menu/edit/{id}', 'Menu','edit');
uri('menu/update/{id}', 'Menu','update', 'POST');
uri('menu/delete/{id}', 'Menu','delete');

// روتر web-setting
uri('web-setting', 'WebSetting', 'index');
uri('web-setting/set', 'WebSetting', 'set');
uri('web-setting/store', 'WebSetting', 'store', 'POST');

// router users
uri('user', 'User','index');
uri('user/permission/{id}', 'User','permission');
uri('user/edit/{id"', 'User','edit');
uri('user/update/{id}', 'User','update', 'POST');
uri('user/delete/{id}', 'User','delete');

// router Auth
uri('login','Auth','login');
uri('check_login', 'Auth', 'check_login', 'POST');
uri('register', 'Auth', 'register');
uri('register/store', 'Auth', 'register_store', 'POST');
uri('logout', 'Auth', 'logout');

uri('home', 'Home', 'index');
uri('show-article/{id}', 'Home', 'show');
uri('show-category/{id}', 'Home', 'category');
uri('comment-store/{id}', 'Home', 'comment_store', 'POST');
