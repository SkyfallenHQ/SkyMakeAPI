<?php
/**
 * Class Router
 * Handles url routing
 */

class Router
{
    /**
     * Routes a specific path to a function
     * @param String $path The path to route
     * @param String $func The function to route to
     */
    public static function routePage($path, $func)
    {
        if (REQUEST == $path or REQUEST == $path . "/") {
            define("ROUTED", true);
            $func();
        }
    }

    /**
     * Routes urls with a specific beginning to a function
     * @param String $prefix Prefix to look for
     * @param String $func Function to redirect to
     * @param Boolean $noEndTrailingSlash Remove trailing slash from the remaining path
     * @param String $fallbackfunc What to do if user is not logged in, name of a function
     */
    public static function routePrefix($prefix, $func, $noEndTrailingSlash = false)
    {
        if (substr(REQUEST, 0, strlen($prefix) + 1) == $prefix . "/") {
            $remainingPath = "";
            if ($noEndTrailingSlash && substr(REQUEST, strlen(REQUEST) - 2, strlen(REQUEST) - 1) == "/") {
                $remainingPath = substr(REQUEST, strlen($prefix), strlen(REQUEST) - 2);
            }
            $remainingPath = substr(REQUEST, strlen($prefix) + 1, strlen(REQUEST));
            define("ROUTED", true);
            $func($remainingPath);
        }
    }
}