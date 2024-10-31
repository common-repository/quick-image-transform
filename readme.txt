=== Quick Image Transform ===
Contributors: frankobingen
Tags: image, resize, dropzone
Requires at least: 4.0.1
Tested up to: 4.9.4
Requires PHP: 5.5
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
This plugin can be used to quickly transform multiple images to a given aspect ratio or resolution. You can also keep the aspect ratio of images and scale them to different sizes.
 
== Description ==
 
Quick Image Transform provides a simple widget on your dashboard to quickly upload and resize multiple images to a specific size.

You can 

1. Provide width and height
2. Provide only width and keep aspect ratio 
3. Provide only height and keep aspect ratio 

The Images will be uploaded to the plugins folder. After the upload the download is triggered automatically.
It requires the uploader to allow popups to open since the image will be opened in a new window in order to download it.

Possible future development:

- Auto upload to library
-  Remember specific sizes (like banner)
- Defined cropping position (top, bottom, center, left, right)
 
== Installation ==
 
This section describes how to install the plugin and get it working.
 
1. Upload `img-transfor-functions.php`, the `includes` folder and the `admin` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Open Dashboard
 
== Frequently Asked Questions ==
 
= Will the stored images be deleted automatically =
 
The images are prefixed with a timestamp. When uploading a new image every image older than 5 minutes will be deleted.
 
= What is the upload limit =
 
The limit is determined by your server / wordpress. The widget will adjust to these values.
 
== Screenshots ==
 
1. Upload of files on dashboard
2. Uploaded files
3. Example file before
4. Example file after
5. General Crop Concept
 
== Changelog ==
 
= 1.0 =
* Initial release

= 1.0.1 =
* Added helper text for popup