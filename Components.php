<?php
/**
 * Created by PhpStorm.
 * User: taran
 * Date: 07.02.2017
 * Time: 12:46
 */

namespace Jelly;

interface iComponents {
    public static function initial(&$config = null);
    public function __get($prop);
    public function __destruct();
}

abstract class Components implements iComponents extends Framework
{

    public static function initial($config = null) {
        return new static($config);
    }

    protected function __construct(&$config = []) {
        //Defining properties
        foreach ($config as $prop=>&$val) {
            $this->$prop = $val;
        }

        //Bootstrap components
        if ( isset($this->bootstrap) && is_array($this->bootstrap) ) {
            foreach ($this->bootstrap as &$com) {
                $this->$com; //Initializing a component
            }
        }

        $this->init();
    }
    
    protected function init() {}

    public function __get($prop) {
        if ( isset($this->components[$prop]) ) { //Component lazy load
            $component = &$this->components[$prop];
            if ( is_object($component) ) {
                return $component;
            } else {
                $component = (array)$component;

                if ( !isset($component[0]) or !is_string($component[0]) ) {
                    throw static::exception('Component "' . $prop . '" class "' . $class . '" is not defined');
                }

                $class = (string)$component[0];
                unset($component[0]);

                if ( !class_exists($class) ) {
                    throw static::exception('Component class "' . $class . '" is not declared');
                }

                if ( !($class instanceof self) ) {
                    throw static::exception('Component class is need to be instance of "' . __CLASS__ . '"');
                }

                $component = $class::initial($component);
                $component->owner = $this;
                return $component;
            }
        }

        $defaultValue = 'default' . ucfirst(strtolower($component));
        return $this->$defaultValue ?? null;
    }

    protected function close() {}

    public function __destruct() {
        $this->close();
        foreach ($this->components as &$component) {
            $component = null;
        }
    }
}

class ComponentsException extends \Exception {}