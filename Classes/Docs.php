<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * "How to use?" documentation menu.
 *
 * One source of links, rendered into both admin headers: the plugin's own menu
 * bar (Helper/Admin_helper.php) and the full-screen effect editor header
 * (Page/Admin_Render.php).
 *
 * @since 9.11.8
 */
class Docs {

	/**
	 * Documentation entries, in menu order.
	 *
	 * @return array<int, array{label: string, url: string}>
	 */
	public static function links() {
		return [
			[
				'label' => __( 'Creating your first hover effect', 'image-hover-effects-ultimate' ),
				'url'   => 'https://oxilab.dev/docs/image-hover-effects/ihe-getting-started/creating-your-first-hover-effect/',
			],
			[
				'label' => __( 'Using the native Gutenberg block', 'image-hover-effects-ultimate' ),
				'url'   => 'https://oxilab.dev/docs/image-hover-effects/page-builder-integration/using-the-native-gutenberg-block/',
			],
			[
				'label' => __( 'Using it with Elementor', 'image-hover-effects-ultimate' ),
				'url'   => 'https://oxilab.dev/docs/image-hover-effects/page-builder-integration/how-to-use-image-hover-effects-with-elementor/',
			],
			[
				'label' => __( 'Using it with WPBakery', 'image-hover-effects-ultimate' ),
				'url'   => 'https://oxilab.dev/docs/image-hover-effects/page-builder-integration/how-to-use-with-wpbakery-visual-composer/',
			],
			[
				'label' => __( 'Using it as a WordPress widget', 'image-hover-effects-ultimate' ),
				'url'   => 'https://oxilab.dev/docs/image-hover-effects/page-builder-integration/using-as-a-wordpress-widget-in-gutenberg/',
			],
			[
				'label' => __( 'Browse all documentation', 'image-hover-effects-ultimate' ),
				'url'   => 'https://oxilab.dev/docs/image-hover-effects/',
			],
		];
	}

	/**
	 * The dropdown panel shared by both headers.
	 *
	 * @return string
	 */
	private static function panel() {
		$out = '<ul class="oxi-howto-menu">';
		foreach ( self::links() as $link ) {
			$out .= '<li><a href="' . esc_url( $link['url'] ) . '" target="_blank" rel="noopener noreferrer">'
				. esc_html( $link['label'] ) . '</a></li>';
		}
		$out .= '</ul>';

		return $out;
	}

	/**
	 * Menu item for the plugin's main admin menu bar (a list item in
	 * ul.oxilab-sa-admin-menu2).
	 *
	 * @return string
	 */
	public static function nav_item() {
		return '<li class="saadmin-doc oxi-howto-item">'
			. '<a href="' . esc_url( self::links()[0]['url'] ) . '" target="_blank" rel="noopener noreferrer" class="oxi-howto-toggle">'
			. '<span class="dashicons dashicons-editor-help" aria-hidden="true"></span>'
			. esc_html__( 'How to use?', 'image-hover-effects-ultimate' )
			. '</a>'
			. self::panel()
			. '</li>';
	}

	/**
	 * Menu item for the full-screen effect editor header.
	 *
	 * @return string
	 */
	public static function editor_item() {
		return '<div class="oxi-howto-item oxi-howto-item--editor">'
			. '<a href="' . esc_url( self::links()[0]['url'] ) . '" target="_blank" rel="noopener noreferrer" class="oxi-btn-howto oxi-howto-toggle">'
			. '<i class="fa fa-question-circle" aria-hidden="true"></i> '
			. esc_html__( 'How to use?', 'image-hover-effects-ultimate' )
			. '</a>'
			. self::panel()
			. '</div>';
	}
}
