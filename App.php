<?php
/**
 * Created by PhpStorm.
 * User: taran
 * Date: 07.02.2017
 * Time: 15:11
 */

namespace Jelly;


class App extends Components
{
    protected $defaultCharset = 'utf-8';
    protected $defaultTimezone = 'Europe/Kiev';

    protected function init() {
        if ( !date_default_timezone_set($this->timezone) ) {
            Console::log(__METHOD__ . ': Invalid timezone ' . $this->timezone);
        }
        if ( !mb_internal_encoding($this->charset) ) {
            Console::log(__METHOD__ . ': Can\'t set mb_internal_encoding to ' . $this->charset);
        }
        if ( !ini_set('default_charset', $this->charset) ) {
            Console::log(__METHOD__ . ': Can\'t set ini default_charset to ' . $this->charset);
        }
    }
}