<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Dynamic;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Description of Layouts_Query
 *
 * @author biplo
 */
class Layouts_Query {

    /**
     * Database Parent Table
     *
     * @since 9.3.0
     */
    public $parent_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $import_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $child_table;

	public function __construct( $function = '', $rawdata = '', $args = '', $optional = '' ) {
		// Only run if both function and rawdata are provided
		if ( ! empty( $function ) && ! empty( $rawdata ) ) :

			// Define table names
			$this->parent_table = $GLOBALS['wpdb']->prefix . 'image_hover_ultimate_style';
			$this->child_table  = $GLOBALS['wpdb']->prefix . 'image_hover_ultimate_list';

			// Call the requested function dynamically
			if ( method_exists( $this, $function ) ) {
				return $this->{$function}( $rawdata, $args, $optional );
			}
		endif;
	}

    public function __rest_api_post( $style, $args, $optional ) {
		global $wpdb;

		// Decode args if not array
		if ( ! is_array( $args ) ) :
			$args = json_decode( stripslashes( $args ), true );
		endif;

		$args['offset'] = (int) $args['offset'] + ( ( (int) $optional - 1 ) * (int) $args['posts_per_page'] );

		// Decode style if not array
		if ( ! is_array( $style ) ) :
			$style = json_decode( stripslashes( $style ), true );
		endif;

		// Fetch raw data safely
		$rawdata = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM " . esc_sql( $this->parent_table ) . " WHERE id = %d", $style['display_post_id'] ),
			ARRAY_A
		);

		return $this->layouts_query( $rawdata, $args, $style );
	}

	public function layouts_query( $dbdata, $args, $style ) {
		global $wpdb;

		// Fetch posts safely with proper placeholders
		$postdata = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM " . esc_sql( $this->child_table ) . " WHERE styleid = %d LIMIT %d, %d",
				(int) $dbdata['id'],
				(int) $args['offset'],
				(int) $args['posts_per_page']
			),
			ARRAY_A
		);

		// Handle empty data
		if ( count( $postdata ) != (int) $args['posts_per_page'] || count( $postdata ) == 0 ) :
			echo esc_html__( 'Image Hover Empty Data', 'image-hover-effects-ultimate' );
			return;
		endif;

		// Generate class name dynamically
		$StyleName = explode( '-', ucfirst( $dbdata['style_name'] ) );
		$cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $StyleName[0] . '\Render\Effects' . $StyleName[1];

		if ( class_exists( $cls ) ) :
			new $cls( $dbdata, $postdata, 'request' );
		endif;
	}
}
