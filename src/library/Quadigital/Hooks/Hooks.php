<?php

class Hooks
{
    private static $_events = array();

    static function register_hook($event, $callback = null)
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

    static function call_hook($event)
    {
        if (isset(self::$_events[$event]) && is_array(self::$_events[$event])) {
            foreach (self::$_events[$event] as $function) {
                call_user_func($function);
            }
        }
    }
}

function register_hook($event, $callback = null)
{
    Hooks::register_hook($event, $callback);
}

function call_hook($event)
{
    Hooks::call_hook($event);
}
