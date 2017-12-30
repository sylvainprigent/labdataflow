<?php

namespace Mumux\server;

class Registery
{
    private static $_objects;

    public static function set($key, $object)
    {

        if (!self::$_objects){
            self::$_objects = array();
        }

        if (!array_key_exists($key, self::$_objects)) self::$_objects[$key] = $object;
    }

    public static function get($key)
    {
        if (!self::$_objects){
            self::$_objects = array();
        }

        if (array_key_exists($key, self::$_objects)) return self::$_objects[$key];
        else return false;
    }
}