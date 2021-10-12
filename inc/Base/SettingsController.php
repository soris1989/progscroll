<?php
/**
 * @package ProgScrollPlugin
 */

namespace ProgScroll\Inc\Base;

use ProgScroll\Inc\Api\SettingsApi;
use ProgScroll\Inc\Base\BaseController;
use ProgScroll\Inc\Api\Callbacks\SettingsCallbacks;

/**
* 
*/
class SettingsController extends BaseController
{
    public $settings;

    public $callbacks;

    public $pages = array();
    // public $subpages = array();
   
    public function __construct() {
        // call parent's constructor
        parent::__construct();

        $this->settings = new SettingsApi();
        $this->callbacks = new SettingsCallbacks();
    }

    public function register() {
       // guard feature not to be added to admin sidebar menu if not activated
       if ( get_option( PROGSCROLL_PLUGIN_SLUG ) === null ) return;
        
        $this->set_pages();

        $this->set_settings();
        $this->set_sections();
        $this->set_fields();

        $this->settings->add_pages($this->pages)
            ->with_sub_page(PROGSCROLL_PLUGIN_SLUG, 'Dashboard')
            ->register();

        add_action( 'wp_footer', array($this, 'add_progscroll_template') );
    }

    public function set_pages() {
        $this->pages = array(
            array(
                'page_title' => 'ProgScroll',
                'menu_title' => 'ProgScroll',
                'capability' => 'manage_options',
                'menu_slug' => PROGSCROLL_PLUGIN_SLUG,
                'callback' => function() { 
                    $this->callbacks->settings_template();
                 },
                'icon_url' => 'dashicons-minus',
                'position' => 120
            )
        );
    }

    public function set_settings() {
        $args = array(
            array(
                'option_group' => 'progscroll_plugin_settings',
                // should be identical to set_fields method -> page
                'option_name' => PROGSCROLL_PLUGIN_SLUG,
                'callback' => array($this->callbacks, 'submission_sanitize')
            )
        );

        $this->settings->set_settings($args);
    }

    public function set_sections() {
        $args = array(
            array(
                'id' => 'progscroll_admin_index',
                'title' => 'Settings Manager',
                'callback' => array($this->callbacks, 'section_manager'),
                // in order to get the page we need to refer to the menu slug of the first page
                'page' => PROGSCROLL_PLUGIN_SLUG 
            )
        );

        $this->settings->set_sections($args);
    }

    public function set_fields() {
        $args = array();

        $args = array(
            array(
                'id' => 'active', 
                'title' => 'Active',
                'callback' => array($this->callbacks, 'checkbox_field'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'active',
                    'class' => 'ui-toggle',
                    'description' => 'activate/deactivate progscroll on site',                  
                )
            ),
            array(
                'id' => 'position_xs', 
                'title' => 'Position (xs)',
                'callback' => array($this->callbacks, 'text_field_with_units'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'position_xs',
                    'placeholder' => 'Insert a numeric value',
                    'description' => 'position is relative to page top for extra small device (< 576px)', 
                )
            ),
            array(
                'id' => 'position_sm', 
                'title' => 'Position (sm)',
                'callback' => array($this->callbacks, 'text_field_with_units'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'position_sm',
                    'placeholder' => 'Insert a numeric value',
                    'description' => 'position is relative to page top for small device (576px - 767px)',
                )
            ),
            array(
                'id' => 'position_md', 
                'title' => 'Position (md)',
                'callback' => array($this->callbacks, 'text_field_with_units'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'position_md',
                    'placeholder' => 'Insert a numeric value',
                    'description' => 'position is relative to page top for medium device (768px - 991px)',          
                )
            ),
            array(
                'id' => 'position_lg', 
                'title' => 'Position (lg)',
                'callback' => array($this->callbacks, 'text_field_with_units'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'position_lg',
                    'placeholder' => 'Insert a numeric value',
                    'description' => 'position is relative to page top for large device (992px - 1199px)',        
                )
            ),
            array(
                'id' => 'position_xl', 
                'title' => 'Position (xl)',
                'callback' => array($this->callbacks, 'text_field_with_units'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'position_xl',
                    'placeholder' => 'Insert a numeric value',
                    'description' => 'position is relative to page top for extra large device (>= 1200px)',    
                )
            ),
            array(
                'id' => 'thickness', 
                'title' => 'Thickness',
                'callback' => array($this->callbacks, 'text_field_with_units'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'thickness',
                    'placeholder' => 'Insert a numeric value',  
                )
            ),
            array(
                'id' => 'color', 
                'title' => 'Color',
                'callback' => array($this->callbacks, 'text_field'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'color',
                    'placeholder' => 'e.g. white, #fffff, rgb(0, 0, 0), rgba(0, 0, 0, 0.3)'
                )
            ),
            array(
                'id' => 'z_index', 
                'title' => 'z-index',
                'callback' => array($this->callbacks, 'text_field'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'z_index',
                    'placeholder' => 'Insert a numeric value',
                    
                )
            ),
            array(
                'id' => 'direction', 
                'title' => 'Direction',
                'callback' => array($this->callbacks, 'select_field'),
                'page' => PROGSCROLL_PLUGIN_SLUG,
                'section' => 'progscroll_admin_index',
                'args' => array(
                    'option_name' => PROGSCROLL_PLUGIN_SLUG,
                    'label_for' => 'direction',
                    'select_options' => array('ltr', 'rtl')
                )
            ),
        );


        $this->settings->set_fields($args);
    }

    public function add_progscroll_template() {
        $file = $this->plugin_path . 'templates/progscroll.php';

        if (file_exists($file)) {
            // second parameter - true, it tells wordpress to load
            // the template just once (like require_once).
            // and it will be loaded in every page in the header.
            load_template( $file, true );
        }
    }
}

