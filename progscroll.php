<?php
/**
 * @package ProgScrollPlugin
 */
/*
Plugin Name: ProgScroll
Plugin URI: https://progscroll.os-studio.co.il/
Description: A progressbar describes how much a user scrolled a page by horizontial scrollbar.
Version: 1.0.0
Author: Ori Saati
Author URI: https://www.os-studio.co.il/
License: GPLv2 or later
Text Domain: progscroll
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2021 o.s-studio
*/

// if this file is called directly, abort!
if (!function_exists('add_action')) {
    echo 'You cannot access this file.';
    exit;
}

// require once the composer autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

// define CONSTANTS
define('PROGSCROLL_PLUGIN_FILE', basename(__FILE__)); // get the name of the file with php ext
define('PROGSCROLL_PLUGIN_NAME', basename(__FILE__, '.php')); // get the name of the file without php ext
define('PROGSCROLL_PLUGIN_SLUG', 'progscroll_plugin'); // get the name of the file without php ext



// register activation hook with some code
function progscroll_plugin_activate() {
    ProgScroll\Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'progscroll_plugin_activate' );


// register deactivation hook with some code
function progscroll_plugin_deactivate() {
    ProgScroll\Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'progscroll_plugin_deactivate' );


/**
 * Initialize all the core classes of the plugin
 */
if (class_exists('ProgScroll\\Inc\\Init')) {
    ProgScroll\Inc\Init::register_services();
}