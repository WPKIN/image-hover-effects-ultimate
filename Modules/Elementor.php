<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules;

class Elementor {
    public function __construct() {
        add_action( 'elementor/widgets/register', [ $this, 'register' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_icon_style' ] );
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_enqueue_scripts' ] );
    }

    public function editor_enqueue_scripts() {
        wp_enqueue_script(
            'iheu-elementor-edit-btn',
            OXI_IMAGE_HOVER_URL . 'assets/frontend/js/elementor-edit-btn.js',
            [ 'elementor-editor' ],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );
    }

    public function editor_icon_style() {
        $icon_url = OXI_IMAGE_HOVER_URL . 'image/dash-icon.svg';
        echo '<style>
            i.icon-image-hover-ultimate::before { display: none !important; }
            i.icon-image-hover-ultimate {
                display: inline-block !important;
                width: 1em;
                height: 1em;
                background-image: url(' . esc_url( $icon_url ) . ');
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                vertical-align: middle;
            }
        </style>';
    }

    public function register( $widgets_manager ) {
        if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
            return;
        }
        if ( ! class_exists( __NAMESPACE__ . '\Image_Hover_Elementor_Widget' ) ) {
            oxilab_define_image_hover_elementor_widget();
        }
        $widgets_manager->register( new Image_Hover_Elementor_Widget() );
    }
}
function oxilab_define_image_hover_elementor_widget() {
    if ( class_exists( '\Elementor\Widget_Base' ) && ! class_exists( __NAMESPACE__ . '\Image_Hover_Elementor_Widget' ) ) {
        class Image_Hover_Elementor_Widget extends \Elementor\Widget_Base {
            public function get_name() { return 'iheu_image_hover'; }
            public function get_title() { return 'Image Hover'; }
            public function get_icon() { return 'icon-image-hover-ultimate'; }
            public function get_categories() { return [ 'general' ]; }
            public function get_style_depends() {
                return [
                    'oxi-animation', 'oxi-image-hover',
                    'oxi-image-hover-carousel-swiper.min.css', 'oxi-image-hover-style-3',
                    'oxi-image-hover-filter-style-1', 'oxi-image-hover-filter-style-2',
                    'oxi-image-hover-comparison-box', 'oxi-image-hover-comparison-style-1', 'oxi-addons-main-wrapper-image-comparison-style-1',
                    'oxi-image-hover-light-box', 'oxi-image-hover-light-style-1', 'image_zoom.css',
                    'oxi-image-hover-glightbox',
                    'oxi-image-hover-display-style-1',
                ];
            }
            public function get_script_depends() {
                return [
                    'jquery', 'waypoints.min', 'oxi-image-hover',
                    'oxi-image-carousel-swiper.min.js', 'oxi-iheu-elementor-carousel',
                    'imagesloaded.pkgd.min', 'jquery.isotope',
                    'jquery-event-move', 'jquery-twentytwenty',
                    'image_zoom',
                    'oxi-image-hover-glightbox',
                    'oxi_image_style_1_loader',
                ];
            }

            protected function register_controls() {
                global $wpdb;
                $options   = [];
                $edit_urls = [];
                $table     = $wpdb->prefix . 'image_hover_ultimate_style';
                $rows      = $wpdb->get_results( "SELECT id, name, style_name FROM {$table} ORDER BY id DESC", ARRAY_A );
                if ( $rows ) {
                    foreach ( $rows as $row ) {
                        $label = ( isset( $row['name'] ) && $row['name'] !== '' ? $row['name'] : 'Image Hover' ) . ' (#' . $row['id'] . ')';
                        $options[ (string) $row['id'] ] = $label;

                        $parts      = explode( '-', $row['style_name'] );
                        $effects    = isset( $parts[0] ) ? strtolower( $parts[0] ) : '';
                        $edit_urls[ (string) $row['id'] ] = admin_url(
                            'admin.php?page=oxi-image-hover-ultimate&effects=' . $effects . '&styleid=' . $row['id']
                        );
                    }
                }
                $default = '';
                if ( ! empty( $options ) ) {
                    $keys    = array_keys( $options );
                    $default = reset( $keys );
                }

                $this->start_controls_section( 'section_image_hover', [ 'label' => 'Image Hover' ] );

                $this->add_control( 'id', [
                    'label'   => 'Shortcode',
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => $options,
                    'default' => $default,
                ] );

                // Edit button — URL is managed by elementor-edit-btn.js via
                // Elementor's native panel/open_editor hook + model change event.
                $edit_urls_json = esc_attr( wp_json_encode( $edit_urls ) );
                $this->add_control( 'edit_shortcode_btn', [
                    'type'      => \Elementor\Controls_Manager::RAW_HTML,
                    'raw'       => '<a class="iheu-edit-shortcode-btn" href="#" target="_blank"
                                        data-urls="' . $edit_urls_json . '"
                                        style="display:inline-flex;align-items:center;gap:6px;margin-top:4px;
                                               padding:7px 18px;background:#f75186;color:#fff;border-radius:4px;
                                               text-decoration:none;font-size:13px;font-weight:600;
                                               transition:background .2s;"
                                        onmouseover="this.style.background=\'#e0406f\'"
                                        onmouseout="this.style.background=\'#f75186\'">
                                        ✏️ Edit Shortcode
                                    </a>',
                    'separator' => 'before',
                ] );

                $this->end_controls_section();
            }

            protected function render() {
                $settings = $this->get_settings_for_display();
                $id = isset( $settings['id'] ) ? $settings['id'] : '';
                echo do_shortcode( '[iheu_ultimate_oxi id="' . esc_attr( $id ) . '"]' );
            }
        }
    }
}
