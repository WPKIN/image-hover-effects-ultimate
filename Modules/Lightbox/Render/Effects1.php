<?php
/**
 * Lightbox Effects1 Render Class
 *
 * @package OXI_IMAGE_HOVER_PLUGINS
 */

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Lightbox\Render;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render;

class Effects1 extends Public_Render {

    /**
     * Enqueue public CSS files
     */
    public function public_css() {
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
            'oxi-image-hover-glightbox',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/glightbox.min.css',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION
        );
    }

    /**
     * Enqueue public JS files
     */
    public function public_jquery() {
        wp_enqueue_script( 'jquery' );

        wp_enqueue_script(
            'oxi-image-hover-glightbox',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/glightbox.min.js',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );

        $this->JSHANDLE = 'oxi-image-hover-glightbox';
    }

    /**
     * Return media URL based on type
     *
     * @param string $id    Media field ID.
     * @param array  $style Style data.
     * @return string
     */
    public function custom_media_render( $id, $style ) {
        if ( array_key_exists( $id . '-select', $style ) ) {
            return ( 'media-library' === $style[ $id . '-select' ] ) ? $style[ $id . '-image' ] : $style[ $id . '-url' ];
        }
        return '';
    }

    /**
     * Render default lightbox
     *
     * @param array  $style  Settings data.
     * @param array  $child  Child elements.
     * @param string $admin  Admin flag.
     */
    public function default_render( $style, $child, $admin ) {
        foreach ( $child as $key => $val ) {
            $value = json_decode( stripslashes( $val['rawdata'] ), true );
            if ( ! is_array( $value ) ) {
                continue;
            }

            $is_image  = ( isset( $value['oxi_image_light_box_select_type'] ) && 'image' === $value['oxi_image_light_box_select_type'] && '' !== $this->custom_media_render( 'oxi_image_light_box_image', $value ) );
            $media_url = $is_image
                ? $this->custom_media_render( 'oxi_image_light_box_image', $value )
                : ( isset( $value['oxi_image_light_box_video'] ) ? $value['oxi_image_light_box_video'] : '' );

            // Build sub-html (title + description), then sanitize with wp_kses_post().
            $sub_html = '';

            if ( ! empty( $value['oxi_image_light_box_title'] ) ) {
                $allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'p', 'span' ];
                $raw_tag      = isset( $style['oxi_image_light_box_tag'] ) ? strtolower( (string) $style['oxi_image_light_box_tag'] ) : 'h3';
                $tag          = in_array( $raw_tag, $allowed_tags, true ) ? $raw_tag : 'h3';

                $sub_html .= '<' . $tag . ' class="oxi_addons__heading">' . $this->return_text( $value['oxi_image_light_box_title'] ) . '</' . $tag . '>';
            }

            if ( ! empty( $value['oxi_image_light_box_desc'] ) ) {
                $sub_html .= '<div class="oxi_addons__details">' . $this->return_text( $value['oxi_image_light_box_desc'] ) . '</div>';
            }

            $sub_html_safe = wp_kses_post( $sub_html );
            $sub_id        = 'oxi_lg_sub_html_' . (int) $this->oxiid . '_' . (int) $key;
            ?>
            <div class="oxi_addons__light_box_style_1 oxi_addons__light_box <?php $this->column_render( 'oxi-image-hover-col', $style ); ?> <?php echo ( 'admin' === $admin ) ? 'oxi-addons-admin-edit-list' : ''; ?>">
                <div class="oxi_addons__light_box_parent oxi_addons__light_box_parent-<?php echo esc_attr( (int) $this->oxiid . '-' . (int) $key ); ?>">

                    <div id="<?php echo esc_attr( $sub_id ); ?>" class="oxi_addons__lg_subhtml" style="display:none;">
                        <?php echo $sub_html_safe; ?>
                    </div>

                    <a class="glightbox oxi_addons__light_box_item"
                        href="<?php echo esc_url( $media_url ); ?>"
                        data-caption-id="<?php echo esc_attr( $sub_id ); ?>"
                        data-type="<?php echo esc_attr( $is_image ? 'image' : 'video' ); ?>">

                        <?php if ( isset( $style['oxi_image_light_box_clickable'] ) && 'image' === $style['oxi_image_light_box_clickable'] && '' !== $this->custom_media_render( 'oxi_image_light_box_image_front', $value ) ) : ?>
                            <div class="oxi_addons__image_main <?php echo esc_attr( isset( $style['oxi_image_light_box_custom_width_height_swither'] ) ? $style['oxi_image_light_box_custom_width_height_swither'] : '' ); ?>"
                                style="background-image: url('<?php echo esc_url( $this->custom_media_render( 'oxi_image_light_box_image_front', $value ) ); ?>');">
                                <div class="oxi_addons__overlay">
                                    <?php $this->font_awesome_render( isset( $style['oxi_image_light_box_bg_overlay_icon'] ) ? $style['oxi_image_light_box_bg_overlay_icon'] : '' ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $value['oxi_image_light_box_button_text'] ) && ( isset( $style['oxi_image_light_box_clickable'] ) && 'button' === $style['oxi_image_light_box_clickable'] ) ) : ?>
                            <div class="oxi_addons__button_main">
                                <button class="oxi_addons__button"><?php $this->text_render( $value['oxi_image_light_box_button_text'] ); ?></button>
                            </div>
                        <?php endif; ?>

                    </a>
                </div>

                <?php
                if ( 'admin' === $admin ) {
                    $this->oxi_addons_admin_edit_delete_clone( (int) $val['id'] );
                }
                ?>
            </div>
            <?php
        }
    }

    /**
     * Inline initialization for LightGallery
     *
     * @return string
     */
    public function inline_public_jquery() {
        $jquery = '';
        foreach ( $this->child as $key => $val ) {
            $jquery .= 'jQuery(function($){
                var $wrap = $(".' . esc_js( $this->WRAPPER ) . ' .oxi_addons__light_box_parent-' . esc_js( $this->oxiid ) . '-' . esc_js( $key ) . '");
                var $a = $wrap.find("a.oxi_addons__light_box_item");
                if (!$a.length || typeof GLightbox === "undefined") return;
                var captionId = $a.attr("data-caption-id");
                var captionEl = captionId ? document.getElementById(captionId) : null;
                var elements = [{
                    href: $a.attr("href"),
                    type: $a.attr("data-type") || undefined,
                    description: captionEl ? captionEl.innerHTML : ""
                }];
                var lightbox = GLightbox({ elements: elements, touchNavigation: true, loop: true });
                $a.on("click", function(e){ e.preventDefault(); lightbox.open(); });
            });';
        }
        return $jquery;
    }
}
