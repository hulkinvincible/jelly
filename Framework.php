<?php
/**
 * Created by PhpStorm.
 * User: taran
 * Date: 07.02.2017
 * Time: 13:57
 */

namespace Jelly;

interface iFramework {
    public static function initialize();
    public static function exception(string $message);
}

abstract class Framework
{

    public static function initialize() {
        Console::log(__METHOD__ . ': Class ' . static::class . ' initialized');
    }

    public static function exception(string $message) {
        $exceptionClass = static::class . 'Exception';
        return new $exceptionClass($message);
    }
}

class FrameworkException extends \Exception {}