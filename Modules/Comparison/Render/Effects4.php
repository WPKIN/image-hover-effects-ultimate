<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Comparison\Render;

if (!defined('ABSPATH')) {
    exit;
}

use OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render;

class Effects4 extends Public_Render
{
    public function public_css()
    {
        wp_enqueue_style('oxi-image-hover-comparison-box', OXI_IMAGE_HOVER_URL . '/Modules/Comparison/Files/Comparison.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        wp_enqueue_style('oxi-image-hover-comparison-style-4', OXI_IMAGE_HOVER_URL . '/Modules/Comparison/Files/style-4.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
       }
      /*
     * Shortcode Addons Media Render.
     * image
     * @since 2.1.0
     */
    public function custom_media_render($id, $style) {
        $url = '';
        if (array_key_exists($id . '-select', $style)):
            if ($style[$id . '-select'] == 'media-library'):
                return $style[$id . '-image'];
            else:
                return $style[$id . '-url'];
            endif;
        endif;
    }
   
    public function default_render($style, $child, $admin)
    {   
        foreach ($child as $key => $val) {
            $data = json_decode(stripslashes($val['rawdata']), true); 
            
            echo '<div class="oxi_addons_image_style_4_box oxi-addons-main-wrapper-image-comparison ' . $this->column_render('oxi-image-hover-col', $style) . ' ' . ($admin == "admin" ? 'oxi-addons-admin-edit-list' : '') . '">
                    <div class="oxi_addons_image_style_4_box_body oxi-addons-main '.$style['oxi_image_magnifier_image_switcher'].'">
                            <div class="oxi_addons_hover_view_img" style="background: url(\'' . $this->custom_media_render('oxi_image_comparison_image_one', $data) . '\') no-repeat fixed;">';
                                $width = 100;
                                $loop = $style['oxi_image_comparison_hover_width-size'];
                                $pwidth = $width / $loop;
                                for ($i = 0; $i < $loop; $i++) {
                                    echo'<div class="oxi_addons_font_view_img" style="background: url(\'' . $this->custom_media_render('oxi_image_comparison_image_two', $data) . '\') no-repeat fixed;"></div>';
                                }
                        echo'</div>
                </div>';
                if ($admin == 'admin'):
                    echo '<div class="oxi-addons-admin-absulote">
                                <div class="oxi-addons-admin-absulate-edit">
                                    <button class="btn btn-primary shortcode-addons-template-item-edit" type="button" value="' . $val['id'] . '">Edit</button>
                                </div>
                                <div class="oxi-addons-admin-absulate-delete">
                                        <button class="btn btn-danger shortcode-addons-template-item-delete" type="submit" value="' . $val['id'] . '">Delete</button>
                                </div>
                            </div>';
                endif;
            echo '</div>';
        } 
    }


 

}
