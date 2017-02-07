<?php
/**
 * Created by PhpStorm.
 * User: taran
 * Date: 07.02.2017
 * Time: 16:14
 */

namespace Jelly;

interface iConsole {
    public static function log(string $message);
    public static function get();
}

class Console extends Framework
{
    private $log = [];

    protected static function &getLog() {
        return self::$log;
    }

    public static function log(string $message) {
        $log = static::getLog();
        $log[] = $message;
    }

    public static function get() {
        $log = static::getLog();
        return $log;
    }
}