<?php

class Filters
{
    private static $_events = array();

    static function register_filter($event, $callback = null)
    {
        if ($callback !== null) {
            if (!is_string($callback)) {
                // TODO Exception
                return;
            }

            if (!isset(self::$_events[$event]) || !is_array(self::$_events[$event])) {
                self::$_events[$event] = array();
            }

            self::$_events[$event][] = $callback;
        }
    }

    static function call_filter($event, $value)
    {
        if (isset(self::$_events[$event]) && is_array(self::$_events[$event])) {
            foreach (self::$_events[$event] as $function) {
                call_user_func($function, array($value));
            }
        }
    }
}

function register_filter($event, $callback = null)
{
    Filters::register_filter($event, $callback);
}

function call_filter($event, $value)
{
    Filters::call_filter($event, $value);
}
