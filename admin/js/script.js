Dropzone.autoDiscover = false;

if (jQuery('.dropzone').length > 0) {
    var $dropZone = new Dropzone(".dropzone"),
        $widget = jQuery('#imgtransform'),
        downloadPath = $widget.data('download'),
        $x = jQuery('#imgtransform-x'),
        $y = jQuery('#imgtransform-y');

    if ($dropZone) {
        $dropZone.options.maxFilesize = parseInt($widget.data('limit')) / 1000 / 1000;
        $dropZone.options.acceptedFiles = ".jpeg,.jpg,.png,.gif";

        $dropZone.on('complete', function (file) {
            
            if (file.xhr && file.xhr.status === 200) {
                var response = JSON.parse(file.xhr.response),
                    win = window.open(downloadPath + "&path=" + response.path + "&name=" + file.name, '_blank');

                win ? win.focus() : alert($widget.data('allow'));
            }
        });

        $dropZone.on('sending', function (file, xhr, formData) {
            formData.append('action', 'imgtransform_upload');
            formData.append('x', $x.attr('value'));
            formData.append('y', $y.attr('value'));
            formData.append('nonce', $widget.data('nonce'));
        });
    }
}