<?php
/**
 * @package ProgScrollPlugin
 */

namespace ProgScroll\Inc\Base;

use ProgScroll\Inc\Base\BaseController;

class SettingsLinks extends BaseController {

    public function register() {
        add_filter( "plugin_action_links_{$this->plugin_name}", array($this, 'settings_link'));
    }

    public function settings_link($links) {
        // add custom settings link
        $settings_link = '<a href="admin.php?page=progscroll_plugin">Settings</a>';
        $links[] = $settings_link; // push $settings_link to links list
        return $links;
    }
}   