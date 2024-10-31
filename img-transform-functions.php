<?php
/*
Plugin Name: 		Quick Image Transform
Plugin URI: 		https://wordpress.org/plugins/quick-image-transform/
Description: 		This plugin can be used to quickly transform multiple images to a given aspect ratio or resolution. You can also keep the aspect ratio of images and scale them to different sizes.
Author: 			Finevisuals GmbH
Version: 			1.0.1
Author URI: 		http://finevisuals.de/
Text Domain: 		imgtransform
License:      		GPL2
License URI:  		https://www.gnu.org/licenses/gpl-2.0.html
Domain Path:  		/languages

Quick Image Transform is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Quick Image Transform is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Quick Image Transform. If not, see https://www.gnu.org/licenses/gpl.txt.
*/

/**
 * Uninstall
 */

if (!function_exists('imgtransform_deactivation')) {
    function imgtransform_deactivation()
    {
        // clear tmp folder
        if ($handle = opendir( __DIR__ . "/includes/tmp")) {

            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != "..") {

                    unlink($target_dir . $entry);
                    
                }
            }

            closedir($handle);
        }

    }
}

register_deactivation_hook(__FILE__, 'imgtransform_deactivation');

/*************************
 * ####### Backend #######
 */

/**
 * Admin Styles
 */

if (!function_exists('imgtransform_admin_styles')) {
    function imgtransform_admin_styles()
    {
        if (current_user_can('upload_files')) {
            wp_enqueue_style('imgtransform_admin_styles', plugin_dir_url(__FILE__) . 'admin/css/style.css');
        }
    }
}

add_action('admin_head', 'imgtransform_admin_styles');

/**
 * Admin Scripts
 */
 
if (!function_exists('imgtransform_admin_scripts')) {
    function imgtransform_admin_scripts()
    {
        if (current_user_can('upload_files')) {
            wp_enqueue_script('imgtransform_admin_scripts_dropzone', plugin_dir_url(__FILE__) . 'admin/js/dropzone.js');
            wp_enqueue_script('imgtransform_admin_scripts_custom', plugin_dir_url(__FILE__) . 'admin/js/script.js', ['imgtransform_admin_scripts_dropzone'], true);
        }
    }
}

add_action('admin_head', 'imgtransform_admin_scripts');

/**
 * File Upload Handler
 */

include_once(plugin_dir_path(__FILE__) . '/includes/file-upload.php');

/**
 * File Download Handler
 */

include_once(plugin_dir_path(__FILE__) . '/includes/file-download.php');

/**
 * Custom Widget
 */

function imgtransform_default_widget()
{
    if (current_user_can('upload_files')) {
        include_once(plugin_dir_path(__FILE__) . '/includes/widget.php');
    }
}

/**
 * Load Widgets
 */

function imgtransform_dashboard_widgets()
{
    global $wp_meta_boxes;

    wp_add_dashboard_widget('imgtransform_default_widget', __('Image Transform', 'imgtransform'), 'imgtransform_default_widget');
}

add_action('wp_dashboard_setup', 'imgtransform_dashboard_widgets');