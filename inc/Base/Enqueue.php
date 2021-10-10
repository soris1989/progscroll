<?php
/**
 * @package ProgScrollPlugin
 */

namespace ProgScroll\Inc\Base;

use ProgScroll\Inc\Base\BaseController;

/**
* 
*/
class Enqueue extends BaseController
{
    public function register() {
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));
        add_action('wp_enqueue_scripts', array($this, 'client_enqueue'));
    }

    function admin_enqueue() {
        // enqueue all our scripts
        wp_enqueue_style( 'progscroll-plugin-admin-style', $this->plugin_url . 'assets/settings.css', array(), time()  );
        wp_enqueue_script( 'progscroll-plugin-admin-script', $this->plugin_url . 'assets/settings.js', array('jquery'), time(), true );
    }

    function client_enqueue() {
        // enqueue all our scripts
        wp_enqueue_style( 'progscroll-plugin-client-style', $this->plugin_url . 'assets/frontend.css', array(), time()  );
        wp_enqueue_script( 'progscroll-plugin-client-script', $this->plugin_url . 'assets/frontend.js', array('jquery'), time(), true );
    }
}

