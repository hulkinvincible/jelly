<?php
/**
 * Created by PhpStorm.
 * User: taran
 * Date: 07.02.2017
 * Time: 16:06
 */

namespace Jelly;

interface iAutoload {
    public static function initialize();
    public static function load($class);
}

class Autoload extends Framework
{
    public static $ext = '.php';

    public static function initialize() {
        if ( !spl_autoload_register([static::class, 'load'], false, true) ) {
            Console::log(__METHOD__ . ': Can\'t register jelly autoloader');
        }
    }

    public static function load($class) {
        Console::log(__METHOD__ . ': Trying to load ' . $class);
        $file = explode('\\', $class);
        if ( $file[0] != __NAMESPACE__ ) {
            Console::log(__METHOD__ . ': Namespace ' . $file[0] . ' is not supporting');
            return;
        }
        $file = __DIR__ . DIRECTORY_SEPARATOR . implode('/', $file) . static::$ext;

        if ( file_exists($file) ) {
            include $file;
            Console::log(__METHOD__ . ': File ' . $file . ' included');
        } else {
            Console::log(__METHOD__ . ': File ' . $file . ' not found');
        }

        if ( class_exists($class, false) ) {
            if ( method_exists($class, 'initialize') ) {
                $reflection = new \ReflectionMethod($class, 'initialize');
                if ( $reflection->isStatic() ) {
                    $class::initialize();
                    Console::log(__METHOD__ . ': Class ' . $class . ' initialized');
                    return;
                }
            }
            Console::log(__METHOD__ . ': Class ' . $class . ' hasn\'t a static initialize method');
        } else {
            Console::log(__METHOD__ . ': File ' . $file . ' included but class is not declared');
        }
    }
}