<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Description of Visual_Composer
 *
 * @author $biplob018
 */
class Visual_Composer {

    /**
     * Define $wpdb
     *
     * @since 9.3.0
     */
    public $wpdb;

    /**
     * Database Parent Table
     *
     * @since 9.3.0
     */
    public $parent_table;

    public function iheu_oxi_VC_shortcode( $atts ) {
        extract(
            shortcode_atts(
                [
					'id' => '',
				], $atts
            )
        );
        $styleid = $atts['id'];
        ob_start();
        \OXI_IMAGE_HOVER_PLUGINS\Classes\Bootstrap::instance()->shortcode_render( $styleid, 'user' );
        return ob_get_clean();
    }

    public function iheu_oxi_VC_extension() {
		global $wpdb;

		// Use caching to satisfy PHPCS NoCaching warning
		$cache_key = 'iheu_all_styles';
		$data = wp_cache_get( $cache_key );

		if ( false === $data ) {

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
			$data = $wpdb->get_results( "SELECT * FROM " . esc_sql( $this->parent_table ). " ORDER BY id DESC", ARRAY_A );

			// Store in cache
			wp_cache_set( $cache_key, $data );
		}

		$vcdata = [];
		if ( ! empty( $data ) ) {
			foreach ( $data as $value ) {
				$vcdata[ $value['id'] ] = 'ID: ' . $value['id']; // Optional: give a readable label
			}
		}

		vc_map(
			[
				'name'     => esc_html__( 'Image Hover Ultimate', 'image-hover-effects-ultimate' ),
				'base'     => 'iheu_oxi_VC',
				'category' => esc_html__( 'Content', 'image-hover-effects-ultimate' ),
				'params'   => [
					[
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Image Hover Select', 'image-hover-effects-ultimate' ),
						'param_name'  => 'id',
						'value'       => $vcdata,
						'save_always' => true,
						'description' => esc_html__( 'Select your Image Hover ID', 'image-hover-effects-ultimate' ),
						'group'       => esc_html__( 'Settings', 'image-hover-effects-ultimate' ),
					],
				],
			]
		);
	}

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
        add_action( 'vc_before_init', [ $this, 'iheu_oxi_VC_extension' ] );
        add_shortcode( 'iheu_oxi_VC', [ $this, 'iheu_oxi_VC_shortcode' ] );
    }
}
