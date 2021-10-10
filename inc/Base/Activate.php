<?php
/**
 * @package ProgScrollPlugin
 */

namespace ProgScroll\Inc\Base;

class Activate {

    private static $option_names = [
        PROGSCROLL_PLUGIN_SLUG
    ];

    public static function activate() {
        flush_rewrite_rules();

        self::init_db_options();
    }

    private static function init_db_options() {
        $default_arr = array();

        foreach (self::$option_names as $name) {
            // check if alecaddd_plugin option exist, so,
            // if exists we don't want to override this 
            //data when user deactivate and then activate again
            if ( !get_option( $name ) ) {
                // update_option update an option if exists, otherwise,
                // it creates the option from scratch
                update_option( $name, $default_arr );
            }        
        }
    }

}   