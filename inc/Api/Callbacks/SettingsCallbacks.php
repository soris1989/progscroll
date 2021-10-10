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
                'position_xs' => isset( $form_data['position_xs'] ) ? $form_data['position_xs'] : '',
                'position_sm' => isset( $form_data['position_sm'] ) ? $form_data['position_sm'] : '',
                'position_md' => isset( $form_data['position_md'] ) ? $form_data['position_md'] : '',
                'position_lg' => isset( $form_data['position_lg'] ) ? $form_data['position_lg'] : '',
                'position_xl' => isset( $form_data['position_xl'] ) ? $form_data['position_xl'] : '',
                'position_xs_unit' => isset( $form_data['position_xs_unit'] ) ? $form_data['position_xs_unit'] : '',
                'position_sm_unit' => isset( $form_data['position_sm_unit'] ) ? $form_data['position_sm_unit'] : '',
                'position_md_unit' => isset( $form_data['position_md_unit'] ) ? $form_data['position_md_unit'] : '',
                'position_lg_unit' => isset( $form_data['position_lg_unit'] ) ? $form_data['position_lg_unit'] : '',
                'position_xl_unit' => isset( $form_data['position_xl_unit'] ) ? $form_data['position_xl_unit'] : '',
                'color' => isset( $form_data['color'] ) ? sanitize_text_field( $form_data['color'] ) : '',
                'z_index' => isset( $form_data['z_index'] ) ? sanitize_text_field( $form_data['z_index'] ) : '',
                'thickness' => isset( $form_data['thickness'] ) ? filter_var($form_data['thickness'], FILTER_SANITIZE_NUMBER_FLOAT) : '',
                'thickness_unit' => isset( $form_data['thickness_unit'] ) ? $form_data['thickness_unit'] : '',
                'direction' => isset( $form_data['direction'] ) ? $form_data['direction'] : '',
            );
        }   

        return $data;
    }

    public function section_manager() {
        echo 'Manage your PostScroll Settings.';
    }
    
    public function text_field( $args ) {
        $name = esc_attr( $args['label_for'] );
        $option_name = esc_attr( $args['option_name' ] );
        $placeholder = isset($args['placeholder']) ? esc_attr( $args['placeholder'] ) : null;
        $description = isset($args['description']) ? esc_html( $args['description'] ) : null;
        $type = isset($args['type']) ? esc_attr( $args['type'] ) : 'text';
       
        $option = get_option( $option_name ); // get option value from db
        $value = isset($option[$name]) && $option[$name] ? $option[$name] : null; 

        // return the input
        $output = '<input type="' . $type . '" class="regular-text" id="' . $name 
            . '" name="' . $option_name . '[' . $name . ']'
            . '" value="' . $value . '" placeholder="' . $placeholder . '">';
        if ($description) {
            $output .= '<div class="description"><small>' . $description . '</small></div>';
        }

        echo $output;
    }

    public function text_field_with_units( $args ) {
        $name = esc_attr( $args['label_for'] );
        $unit_name = $name . '_unit';
        $option_name = esc_attr( $args['option_name' ] );
        $placeholder = isset($args['placeholder']) ? esc_attr( $args['placeholder'] ) : null;
        $description = isset($args['description']) ? esc_html( $args['description'] ) : null;
        $type = isset($args['type']) ? esc_attr( $args['type'] ) : 'text';
       
        $option = get_option( $option_name ); // get option value from db
        $value = isset($option[$name]) && $option[$name] ? $option[$name] : null; 
        $unit = isset($option[$unit_name]) && $option[$unit_name] ? $option[$unit_name] : 'px'; 

        // return the input
        $output = '<div><div class="progscroll-multi-text-fields-wrapper regular-text">'
            . '<input type="' . $type . '" id="' . $name 
            . '" name="' . $option_name . '[' . $name . ']'
            . '" value="' . $value . '" placeholder="' . $placeholder . '">'
            . '<select name="' . $option_name . '[' . $unit_name . ']" id="' . $unit_name . '">';
        
            foreach ($this->units as $value) {
                $output .= '<option value="' . $value . '"' . ($unit === $value ? ' selected' : '') . '>' . $value . '</option>';
            }

            $output .= '</select></div>';
            if ($description) {
                $output .= '<div class="description"><small>' . $description . '</small></div>';
            }
            $output .= '</div>';

        echo $output;
    }

    public function select_field($args) {
        $name = esc_attr( $args['label_for'] );
        $option_name = esc_attr( $args['option_name' ] );
        $select_options = $args['select_options' ] ?? array();

        $option = get_option( $option_name ); // get option value from db
        $value = isset($option[$name]) && $option[$name] ? $option[$name] : null; 

        echo '<select name="' . $option_name . '[' . $name . ']" id="' . $name . '" class="regular-text">';
        foreach ($select_options as $item) {
            echo '<option value="' . $item . '"' . (isset($value) && $item === $value  ? 'selected' : '') . '>' . strtoupper($item) . '</option>';
        }
        echo '</select>';
    }

    public function checkbox_field( $args ) {
        $name = esc_attr( $args['label_for'] );
        $classes = isset($args['class']) ? esc_attr( $args['class'] ) : null;
        $option_name = esc_attr( $args['option_name' ] );
        $description = isset($args['description']) ? esc_html( $args['description'] ) : null;

        $option = get_option( $option_name ); // get option value from db
        $checked = isset($option[$name]) && $option[$name] ? $option[$name] : false;    

        $output = '<div><div class="' . $classes . '">'
            . '<input type="checkbox" id="' . $name
            . '" name="' . $option_name . '[' . $name . ']'
            . '" value="1"' . ($checked ? ' checked' : '') . '>'
            . '<label for="'. $name .'"><div></div></label>'
            . '</div>';
        if ($description) {
            $output .= '<div class="description"><small>' . $description . '</small></div>';
        }
        $output .= '</div>';

        echo $output;
    }
}
