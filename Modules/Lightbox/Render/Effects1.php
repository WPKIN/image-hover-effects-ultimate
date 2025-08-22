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
            'oxi-image-hover-lightgallery',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/lightgallery.min.css',
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
            'oxi-image-hover-lightgallery',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/lightgallery.min.js',
            [ 'jquery' ],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );

        wp_enqueue_script(
            'oxi-image-hover-lightgallery-video',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/lg-video.min.js',
            [ 'oxi-image-hover-lightgallery', 'jquery' ],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );

        $this->JSHANDLE = 'oxi-image-hover-lightgallery-video';

        wp_enqueue_script(
            'oxi-image-hover-lightgallery-mousewheel',
            OXI_IMAGE_HOVER_URL . 'Modules/Lightbox/Files/jquery.mousewheel.min.js',
            [ 'jquery' ],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );

        $this->JSHANDLE = 'oxi-image-hover-lightgallery-mousewheel';
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

                $sub_html .= '<' . $tag . ' class="oxi_addons__heading">' . esc_html( $value['oxi_image_light_box_title'] ) . '</' . $tag . '>';
            }

            if ( ! empty( $value['oxi_image_light_box_desc'] ) ) {
                $sub_html .= '<div class="oxi_addons__details">' . esc_html( $value['oxi_image_light_box_desc'] ) . '</div>';
            }

            // IMPORTANT: Sanitize as safe HTML, then escape for attribute context.
            $sub_html_safe = wp_kses_post( $sub_html );
            ?>
            <div class="oxi_addons__light_box_style_1 oxi_addons__light_box <?php $this->column_render( 'oxi-image-hover-col', $style ); ?> <?php echo ( 'admin' === $admin ) ? 'oxi-addons-admin-edit-list' : ''; ?>">
                <div class="oxi_addons__light_box_parent oxi_addons__light_box_parent-<?php echo esc_attr( (int) $this->oxiid . '-' . (int) $key ); ?>">

                    <a class="oxi_addons__light_box_item"
                        href="<?php echo esc_url( $media_url ); ?>"
                        data-sub-html="<?php echo esc_attr( $sub_html_safe ); ?>">

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
                                <button class="oxi_addons__button"><?php echo esc_html( $value['oxi_image_light_box_button_text'] ); ?></button>
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
     * (Optionally sanitizes data-sub-html via DOMPurify if present.)
     *
     * @return string
     */
    public function inline_public_jquery() {
        $jquery = '';
        foreach ( $this->child as $key => $val ) {
            $jquery .= 'jQuery(function($){
                var $wrap = $(".' . esc_js( $this->WRAPPER ) . ' .oxi_addons__light_box_parent-' . esc_js( $this->oxiid ) . '-' . esc_js( $key ) . '");
                if (window.DOMPurify) {
                    $wrap.find("a.oxi_addons__light_box_item").each(function(){
                        var html = $(this).attr("data-sub-html");
                        if (typeof html === "string") {
                            try {
                                var clean = DOMPurify.sanitize(html, {
                                    ALLOWED_TAGS: ["a","b","strong","em","i","u","p","br","span","div","h1","h2","h3","h4","h5","h6"],
                                    ALLOWED_ATTR: ["href","class","target","rel"]
                                });
                                $(this).attr("data-sub-html", clean);
                            } catch(e) {}
                        }
                    });
                }
                $wrap.lightGallery({
                    share: false,
                    addClass: "oxi_addons_light_box_overlay_' . esc_js( $this->oxiid ) . '"
                });
            });';
        }
        return $jquery;
    }
}
