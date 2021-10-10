<?php
/**
 * @package ProgScrollPlugin
 */

namespace ProgScroll\Inc;

final class Init {

    /**
     * Store all the classes inside an array
     * @return array Full list classes
     */
    public static function get_services() {
        return array(
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Base\SettingsController::class
        );
    }

    /**
     * Loop through the classes, initialize them,
     * and call register method if exists
     * @return
     */
    public static function register_services() {
        foreach (self::get_services() as $class) {
            $service = self::instansiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize a class
     * @param class $class      class from the services array
     * @return class instance   new instance of the class
     */
    private static function instansiate($class) {
        $service = new $class();
        return $service;
    }
}