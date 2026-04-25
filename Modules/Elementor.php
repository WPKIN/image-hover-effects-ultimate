<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules;

class Elementor {
    public function __construct() {
        add_action( 'elementor/widgets/register', [ $this, 'register' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_icon_style' ] );
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
                $options = [];
                $table = $wpdb->prefix . 'image_hover_ultimate_style';
                $rows = $wpdb->get_results( "SELECT id, name FROM {$table} ORDER BY id DESC", ARRAY_A );
                if ( $rows ) {
                    foreach ( $rows as $row ) {
                        $label = ( isset( $row['name'] ) && $row['name'] !== '' ? $row['name'] : 'Image Hover' ) . ' (#' . $row['id'] . ')';
                        $options[ (string) $row['id'] ] = $label;
                    }
                }
                $default = '';
                if ( ! empty( $options ) ) {
                    $keys = array_keys( $options );
                    $default = reset( $keys );
                }
                $this->start_controls_section( 'section_image_hover', [ 'label' => 'Image Hover' ] );
                $this->add_control( 'id', [
                    'label'   => 'Shortcode',
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'options' => $options,
                    'default' => $default,
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
