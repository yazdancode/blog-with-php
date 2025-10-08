<?php
require_once __DIR__ . '/admindashboard/Category.php';
require_once __DIR__ . '/Database/CreateDB.php';

function uri($uriPattern, $className, $methodName, $requestMethod = 'GET')
{
    $params = [];
    $patternParts = explode('/', trim($uriPattern, '/'));
    $requestParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    if (empty($requestParts[0])) {
        $requestParts[0] = 'home';
    }
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
    } else {
        if (!empty($params)) {
            $object->$methodName(implode(',', $params));
        } else {
            $object->$methodName();
        }
    }
}
