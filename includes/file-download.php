<?php

/**
 * Handle an incoming request to download a requested file.
 * Delete file after the download.
 *
 * incoming parameters: name (name of file after download), path (name of local file)
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function imgtransform_file_download() {

    if (!isset($_GET['imgtransform_download'])) {
        return;
    }

    // check privilege
    if (!current_user_can('upload_files')) {
        _e('Missing role privilege.', 'imgtransform');
        die();
    }

    // check request parameters
    if (!isset($_GET['name']) || !isset($_GET['path']))
    {
        _e('Invalid request.', 'imgtransform');
        die();
    }

    // prepare filenames & paths
    // remove all slahes to ensure user cannot access other folders
    // in this case path is the actual file name while name is the name of the download file
    // therefore both parameters are sanatized as filenames

    $target_dir = __DIR__ . '/tmp/';

    $filename = sanitize_file_name(stripslashes(str_replace('/', '', $_GET['name'])));
    $fullpath = realpath($target_dir . sanitize_file_name(stripslashes(str_replace('/', '', $_GET['path']))));
	
	if (!$fullpath) {
		_e('Invalid file path.', 'imgtransform');
        die();
	}

    // delete all files in tmp folder that are older than 10 minutes
    if ($handle = opendir($target_dir)) {

        while (false !== ($entry = readdir($handle))) {

            if ($entry != "." && $entry != "..") {

                $p = explode("-", $entry);
                
                if (isset($p) && isset($p[0])) {
                    $ts = (int) $p[0];

                    if (time() - $ts > 600) {
                        unlink($target_dir . $entry);
                    }
                }
                
            }
        }

        closedir($handle);
    }
	
	$mime = wp_get_image_mime($fullpath);
	
	if ($mime !== "image/jpeg" && $mime !== "image/png" && $mime !== "image/gif") {
		_e('Invalid file.', 'imgtransform');
        die();
	}
	
    if (file_exists($fullpath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.urldecode($filename).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fullpath));
        readfile($fullpath);
        exit;
    }
	
	_e('File does no longer exist.', 'imgtransform');
    wp_die();
}

add_action( 'admin_init', 'imgtransform_file_download' );