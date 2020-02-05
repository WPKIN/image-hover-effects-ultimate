<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Helper;

/**
 *
 * @author biplo
 */
trait Uplaod {

    /**
     * Upload Folder
     *
     * @since 9.3.0
     */
    public function upload_folder() {
        $check = $this->check_dir(OXI_IMAGE_HOVER_UPLOAD_PATH);
        if ($check):
            $this->create_upload_folder();
        endif;
    }

    /**
     * Plugin Create Upload Folder
     *
     * @since 2.0.0
     */
    public function create_upload_folder() {
        $upload = wp_upload_dir();
        $upload_dir = $upload['basedir'];
        $dir = $upload_dir . '/oxi-image-hover';
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
    }

    /**
     * Check dir
     *
     * @since 9.3.0
     * return false when folder checked 
     */
    public function check_dir($path) {
        return (is_dir($path) ? FALSE : TRUE);
    }

}
