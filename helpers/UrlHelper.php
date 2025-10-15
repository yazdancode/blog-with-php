<?php

namespace helpers;

class UrlHelper
{
    public static function siturl(string $route): string
    {
        return 'http://localhost/project/' . ltrim($route, '/');
    }

    public static function assetsUrl(string $route): string
    {
        return self::siturl('public/' . ltrim($route, '/'));
    }
}
