<?php

/**
 * Handle the incoming file and resize it.
 * Store it in a tmp folder and delete it afterwards.
 * 
 * Incoming parameters: x (int), y (int), nonce (string), file (file / filename string)
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function imgtransform_upload() {
    
    // response method
    if (!function_exists('http_response_code')) {
        function http_response_code($newcode = NULL)
        {
            static $code = 200;
            if ($newcode !== NULL) {
                header('X-PHP-Response-Code: ' . $newcode, true, $newcode);
                if (!headers_sent())
                    $code = $newcode;
            }
            return $code;
        }
    }

    // check privilege
    if (!current_user_can('upload_files')) {
        http_response_code(400);
        wp_die();
    }

    // validate & verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'imgtransform_upload')) {
        http_response_code(400);
        wp_die();
    }

    $x = null;
    $y = null;

    // validate, verify & sanatize x and y values
    if (isset($_POST['x']) && $_POST['x'] != "" && is_numeric($_POST['x'])) {
        // cast to integer
        $x = (int)$_POST['x'];
    }

    if (isset($_POST['y']) && $_POST['y'] != "" && is_numeric($_POST['y'])) {
        // cast to integer
        $y = (int)$_POST['y'];
    }

    // abort if both are not set
    if ($x == null && $y == null) {
        http_response_code(400);
        wp_die();
    }

    // status of upload / resize
    $status = 0;

    // setup tmp filename & storage
    $target_dir = __DIR__ . "/tmp/";

    // validate filename
    if (!isset($_FILES['file']['name'])) {
        http_response_code(400);
        wp_die();
    }

    $filename = time() . '-' . sanitize_file_name(stripslashes(str_replace('/', '', $_FILES['file']['name'])));
    
    $fullpath = $target_dir . $filename;

    try {
        // store tmp file
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $fullpath)) {
            $status = 1;
        }

        // resize image
        $image = wp_get_image_editor($fullpath);

        if (!is_wp_error($image)) {
            $image->resize($x, $y, true);
            $image->save($fullpath);
        } else {
            $status = 0;
        }

        if ($status == 0) {
            http_response_code(400);
            die();
        }

        // return filename as json
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['path' => $filename]);
        wp_die();
    } catch (Exception $e) {
        http_response_code(400);
        die();
    }

	wp_die();
}

add_action( 'wp_ajax_imgtransform_upload', 'imgtransform_upload' );