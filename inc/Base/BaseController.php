<?php
/**
 * @package ProgScrollPlugin
 */

namespace ProgScroll\Inc\Base;

class BaseController {
    public $plugin_path;
    public $plugin_url;
    public $plugin_name;

    public function __construct() {
        $this->plugin_path = plugin_dir_path( dirname(__FILE__, 2) );
        $this->plugin_url = plugin_dir_url( dirname(__FILE__, 2) );
        $this->plugin_name = plugin_basename( dirname(__FILE__, 3)) . '/' . PROGSCROLL_PLUGIN_FILE;
    }

    protected function activated ( string $key ) {
        $option = get_option( PROGSCROLL_PLUGIN_SLUG ); // get option value from db
        return isset($option[$key]) && $option[$key];
    }

    protected function print_var($var) {
        echo '<pre>' . esc_attr( $var ) . '</pre>';
    }

    protected function print_arr(array $arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    protected function dump_var($x) {
        echo '<pre>';
        var_dump($x);
        echo '</pre>';
    }
}