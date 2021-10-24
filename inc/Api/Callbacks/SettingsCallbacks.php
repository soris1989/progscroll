<?php
/**
 * @package ProgScrollPlugin
 */

namespace ProgScroll\Inc\Api\Callbacks;

use ProgScroll\Inc\Base\BaseController;

/**
 * This class extends everthing 
 */
class SettingsCallbacks extends BaseController {

    private $units = array(
        'cm', 'mm', 'Q', 'in', 'pc', 'pt', 'px',
        'em', 'ex', 'ch', 'rem', 'lh', 'vw', 'vh', 'vmin', 'vmax', '%',
    );
    
    public function settings_template($errors = array()) {
        return require_once("{$this->plugin_path}/templates/settings.php");
    }

    public function validate($form_data) {
        $errors = array();

        if (!empty($form_data['position_xs']) && !is_numeric($form_data['position_xs'])) {
            $valid = false;
            $errors[] = array('invalid_position', 'Position (xs) must be numeric.');
        }
        if (!empty($form_data['position_sm']) && !is_numeric($form_data['position_sm'])) {
            $valid = false;
            $errors[] = array('invalid_position', 'Position (sm) must be numeric.');
        }
        if (!empty($form_data['position_md']) && !is_numeric($form_data['position_md'])) {
            $valid = false;
            $errors[] = array('invalid_position', 'Position (md) must be numeric.');
        }
        if (!empty($form_data['position_lg']) && !is_numeric($form_data['position_lg'])) {
            $valid = false;
            $errors[] = array('invalid_position', 'Position (lg) must be numeric.');
        }
        if (!empty($form_data['position_xl']) && !is_numeric($form_data['position_xl'])) {
            $valid = false;
            $errors[] = array('invalid_position', 'Position (xl) must be numeric.');
        }

        if (!is_numeric($form_data['thickness'])) {
            $valid = false;
            $errors[] = array('invalid_thickness', 'Thickness must be numeric.');
        }

        if (!is_numeric($form_data['z_index'])) {
            $valid = false;
            $errors[] = array('invalid_z_index', 'z-index must be numeric.');
        }

        return $errors;
    }

    public function submission_sanitize( $form_data ) {
        $errors = $this->validate($form_data);

        $data = array();

        // Ignore the user's changes and use the old database value.
        if ( $errors ) {
            foreach ($errors as $err) {
                add_settings_error( 'my_option_notice', $err[0], $err[1] );
            }

            $data = get_option( 'progscroll_plugin' );
        }
        else {
            $data = array(
                'active' => isset( $form_data['active'] ),
                'position_xs' => isset( $form_data['position_xs'] ) ? sanitize_text_field( $form_data['position_xs'] ) : '',
                'position_sm' => isset( $form_data['position_sm'] ) ? sanitize_text_field( $form_data['position_sm'] ) : '',
                'position_md' => isset( $form_data['position_md'] ) ? sanitize_text_field( $form_data['position_md'] ) : '',
                'position_lg' => isset( $form_data['position_lg'] ) ? sanitize_text_field( $form_data['position_lg'] ) : '',
                'position_xl' => isset( $form_data['position_xl'] ) ? sanitize_text_field( $form_data['position_xl'] ) : '',
                'position_xs_unit' => isset( $form_data['position_xs_unit'] ) ? sanitize_text_field( $form_data['position_xs_unit'] ) : '',
                'position_sm_unit' => isset( $form_data['position_sm_unit'] ) ? sanitize_text_field( $form_data['position_sm_unit'] ) : '',
                'position_md_unit' => isset( $form_data['position_md_unit'] ) ? sanitize_text_field( $form_data['position_md_unit'] ) : '',
                'position_lg_unit' => isset( $form_data['position_lg_unit'] ) ? sanitize_text_field( $form_data['position_lg_unit'] ) : '',
                'position_xl_unit' => isset( $form_data['position_xl_unit'] ) ? sanitize_text_field ($form_data['position_xl_unit'] ) : '',
                'color' => isset( $form_data['color'] ) ? sanitize_text_field( $form_data['color'] ) : '',
                'z_index' => isset( $form_data['z_index'] ) ? sanitize_text_field( $form_data['z_index'] ) : '',
                'thickness' => isset( $form_data['thickness'] ) ? sanitize_text_field( $form_data['thickness'] ) : '',
                'thickness_unit' => isset( $form_data['thickness_unit'] ) ? sanitize_text_field( $form_data['thickness_unit'] ) : '',
                'direction' => isset( $form_data['direction'] ) ? sanitize_text_field( $form_data['direction'] ) : '',
            );
        }   

        return $data;
    }

    public function section_manager() {
        echo 'Manage your PostScroll Settings.';
    }
    
    public function text_field( $args ) {
        $name = $args['label_for'];
        $option_name = $args['option_name' ];
        $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
        $description = isset($args['description']) ? $args['description'] : '';
        $type = isset($args['type']) ? $args['type'] : 'text';
       
        $option = get_option( $option_name ); // get option value from db
        $value = isset($option[$name]) && $option[$name] ? $option[$name] : ''; 

        // return the input
        echo '<input type="' . esc_attr( $type ) . '" class="regular-text" id="' . esc_attr( $name ) 
            . '" name="' . esc_attr( $option_name . '[' . $name . ']' )
            . '" value="' .  esc_attr($value) . '" placeholder="' . esc_attr( $placeholder ) . '">';
        if ($description) {
            echo '<div class="description"><small>' . esc_html( $description ) . '</small></div>';
        }
    }

    public function text_field_with_units( $args ) {
        $name = $args['label_for'];
        $unit_name = $name . '_unit';
        $option_name = $args['option_name'];
        $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
        $description = isset($args['description']) ? $args['description'] : '';
        $type = isset($args['type']) ? $args['type'] : 'text';
       
        $option = get_option( $option_name ); // get option value from db
        $value = isset($option[$name]) && $option[$name] ? $option[$name] : null; 
        $unit = isset($option[$unit_name]) && $option[$unit_name] ? $option[$unit_name] : 'px'; 

        // return the input
        echo '<div><div class="progscroll-multi-text-fields-wrapper regular-text">'
            . '<input type="' . esc_attr( $type ) . '" id="' . esc_attr( $name )
            . '" name="' . esc_attr( $option_name . '[' . $name . ']' )
            . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $placeholder ) . '">'
            . '<select name="' . esc_attr( $option_name . '[' . $unit_name . ']' )  . '" id="' . esc_attr( $unit_name ) . '">';
        
        foreach ($this->units as $value) {
            echo '<option value="' . esc_attr( $value ) . '"' . ( ($unit === $value) ? ' selected' : '' ) . '>' . esc_html( $value ) . '</option>';
        }

        echo '</select></div>';
        if ($description) {
            echo '<div class="description"><small>' . esc_html( $description ) . '</small></div>';
        }
        echo '</div>';
    }

    public function select_field($args) {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $select_options = $args['select_options'] ?? array();

        $option = get_option( $option_name ); // get option value from db
        $value = isset($option[$name]) && $option[$name] ? $option[$name] : null; 

        echo '<select name="' . esc_attr( $option_name . '[' . $name . ']' ) . '" id="' . esc_attr( $name ) . '" class="regular-text">';
        foreach ($select_options as $item) {
            echo '<option value="' . esc_attr( $item  ) . '"' . ( (isset($value) && $item === $value)  ? 'selected' : '') . '>' . esc_html( strtoupper($item) ) . '</option>';
        }
        echo '</select>';

    }

    public function checkbox_field( $args ) {
        $name = $args['label_for'] ;
        $classes = isset($args['class']) ? $args['class'] : '';
        $option_name = $args['option_name' ];
        $description = isset($args['description']) ? $args['description'] : '';

        $option = get_option( $option_name ); // get option value from db
        $checked = isset($option[$name]) && $option[$name] ? $option[$name] : false;    

        echo '<div><div class="' . esc_attr( $classes ) . '">'
            . '<input type="checkbox" id="' . esc_attr( $name )
            . '" name="' . esc_attr( $option_name  . '[' . $name . ']' )
            . '" value="1"' . ($checked ? ' checked' : '') . '>'
            . '<label for="'. esc_attr( $name ) .'"><div></div></label>'
            . '</div>';
        if ($description) {
            echo '<div class="description"><small>' . esc_html( $description ) . '</small></div>';
        }
        echo '</div>';
    }
}
