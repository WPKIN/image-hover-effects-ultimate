<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Lightbox\Render;

if (!defined('ABSPATH')) {
    exit;
}

use OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render;

class Effects1 extends Public_Render
{
    /**
     * Enqueue public CSS files
     */
    public function public_css()
    {
        wp_enqueue_style(
            'oxi-image-hover-light-box',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/Lightbox.css',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION
        );

        wp_enqueue_style(
            'oxi-image-hover-light-style-1',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/style-1.css',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION
        );

        wp_enqueue_style(
            'oxi-image-hover-lightgallery',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/lightgallery.min.css',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION
        );
    }

    /**
     * Enqueue public JS files
     */
    public function public_jquery()
    {
        wp_enqueue_script('jquery');

        wp_enqueue_script(
            'oxi-image-hover-lightgallery',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/lightgallery.min.js',
            ['jquery'],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );

		$this->JSHANDLE = 'oxi-image-hover-lightgallery';

        wp_enqueue_script(
            'oxi-image-hover-lightgallery-video',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/lg-video.min.js',
            ['oxi-image-hover-lightgallery', 'jquery'],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );

		$this->JSHANDLE = 'oxi-image-hover-lightgallery-video';

        wp_enqueue_script(
            'oxi-image-hover-lightgallery-mousewheel',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/jquery.mousewheel.min.js',
            ['jquery'],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );

		$this->JSHANDLE = 'oxi-image-hover-lightgallery-mousewheel';
    }

    /**
     * Return media URL based on type
     */
    public function custom_media_render($id, $style)
    {
        if (array_key_exists($id . '-select', $style)) {
            return $style[$id . '-select'] === 'media-library' ? $style[$id . '-image'] : $style[$id . '-url'];
        }
        return '';
    }

    /**
     * Render default lightbox
     */
    public function default_render($style, $child, $admin)
    {
        foreach ($child as $key => $val) {
            $value = json_decode(stripslashes($val['rawdata']), true);
            ?>
            <div class="oxi_addons__light_box_style_1 oxi_addons__light_box <?php $this->column_render('oxi-image-hover-col', $style); ?> <?php echo ($admin === 'admin') ? 'oxi-addons-admin-edit-list' : ''; ?>">
                <div class="oxi_addons__light_box_parent oxi_addons__light_box_parent-<?php echo (int)$this->oxiid; ?>-<?php echo (int)$key; ?>">

                    <?php
                    $is_image = ($value['oxi_image_light_box_select_type'] === 'image' && $this->custom_media_render('oxi_image_light_box_image', $value) !== '');
                    $media_url = $is_image ? $this->custom_media_render('oxi_image_light_box_image', $value) : $value['oxi_image_light_box_video'];

                    $sub_html = '';
                    if (!empty($value['oxi_image_light_box_title'])) {
                        $tag = esc_attr($style['oxi_image_light_box_tag']);
                        $sub_html .= '<' . $tag . ' class="oxi_addons__heading">' . esc_html($value['oxi_image_light_box_title']) . '</' . $tag . '>';
                    }
                    if (!empty($value['oxi_image_light_box_desc'])) {
                        $sub_html .= '<div class="oxi_addons__details">' . esc_html($value['oxi_image_light_box_desc']) . '</div>';
                    }
                    ?>

                    <a class="oxi_addons__light_box_item"
                       href="<?php echo esc_url($media_url); ?>"
                       data-sub-html="<?php echo esc_attr($sub_html); ?>">

                        <?php if ($style['oxi_image_light_box_clickable'] === 'image' && $this->custom_media_render('oxi_image_light_box_image_front', $value) !== ''): ?>
                            <div class="oxi_addons__image_main <?php echo esc_attr($style['oxi_image_light_box_custom_width_height_swither']); ?>"
                                 style="background-image: url('<?php echo esc_url($this->custom_media_render('oxi_image_light_box_image_front', $value)); ?>');">
                                <div class="oxi_addons__overlay">
                                    <?php $this->font_awesome_render($style['oxi_image_light_box_bg_overlay_icon']); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($value['oxi_image_light_box_button_text']) && $style['oxi_image_light_box_clickable'] === 'button'): ?>
                            <div class="oxi_addons__button_main">
                                <button class="oxi_addons__button"><?php echo esc_html($value['oxi_image_light_box_button_text']); ?></button>
                            </div>
                        <?php endif; ?>

                    </a>
                </div>

                <?php if ($admin === 'admin') $this->oxi_addons_admin_edit_delete_clone($val['id']); ?>
            </div>
            <?php
        }
    }

    /**
     * Inline initialization for LightGallery
     */
    public function inline_public_jquery()
    {
        $jquery = '';
        foreach ($this->child as $key => $val) {
            $jquery .= 'jQuery(document).ready(function($){
                $(".'.$this->WRAPPER.' .oxi_addons__light_box_parent-'.$this->oxiid.'-'.$key.'").lightGallery({
                    share: false,
					addClass: "oxi_addons_light_box_overlay_'.$this->oxiid.'"
                });
            });';
        }
        return $jquery;
    }
}
