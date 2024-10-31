<?php
/**
 * Upload Widget (using dropzone)
 */
?>

<div id="imgtransform"
     class="imgtransform"
     data-download="<?= get_admin_url(); ?>?imgtransform_download=true"
     data-limit="<?= wp_max_upload_size(); ?>"
     data-allow="<?php _e("Bad Request.", 'imgtransform'); ?>"
     data-nonce="<?= wp_create_nonce('imgtransform_upload'); ?>"
>
    <p><?php _e('In order to download the image you MUST accept popups for this page. If the upload fails check if a popup was blocked. Then try again.', 'imgtransform'); ?></p>

    <div class="imgtransform-inputs">
        <label for="imgtransform-x"><?php _e('Width in px', 'imgtransform'); ?></label>
        <input id="imgtransform-x" type="number" value="1024"/>
    </div>

    <div class="imgtransform-inputs">
        <label for="imgtransform-y"><?php _e('Height in px', 'imgtransform'); ?></label>
        <input id="imgtransform-y" type="number" value="400"/>
    </div>

    <form action="<?= admin_url('admin-ajax.php'); ?>"
          class="dropzone"
          enctype="multipart/form-data"
          method="post"
          id="dropzone-widget"
    >
    </form>
</div>
