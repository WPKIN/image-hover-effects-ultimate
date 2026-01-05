<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Includes;

/**
 * Assets Handler Class
 *
 * @since 2.10.1
 */
class Assets {

	/**
	 * Assets class constructor
	 *
	 * @since 2.10.1
	 */
	public function __construct() {

		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scriptss' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'public_enqueue_scripts' ] );
	}

	/**
	 * Method admin_enqueue_scriptss.
	 *
	 * @since 2.10.1
	 */
	public function admin_enqueue_scriptss() {
		$current_screen = get_current_screen()->id;
		$current_page   = isset( $_GET['page'] ) && $_GET['page'] ? $_GET['page'] : '';

		wp_enqueue_style( 'image-hover-ultimate-global-admin-style', OXI_IMAGE_HOVER_URL . 'assets/backend/css/global-admin.css', false, filemtime( OXI_IMAGE_HOVER_PATH . 'assets/backend/css/global-admin.css' ) );

		if ( 'oxi-image-hover-ultimate' === $current_page || 'oxi-image-hover-shortcode' === $current_page || 'oxi-image-hover-ultimate-settings' === $current_page ) {
			$this->loader_font_familly_validation( [ 'Bree+Serif', 'Source+Sans+Pro' ] );
			wp_enqueue_style( 'oxilab-image-hover-bootstraps', OXI_IMAGE_HOVER_URL . 'assets/backend/css/bootstrap.min.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION );
			wp_enqueue_style( 'font-awsome.mins', OXI_IMAGE_HOVER_URL . 'assets/frontend/css/font-awsome.min.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION );
			wp_enqueue_style( 'oxilab-image-hover-admin-css', OXI_IMAGE_HOVER_URL . 'assets/backend/css/admin.css', false, filemtime( OXI_IMAGE_HOVER_PATH . 'assets/backend/css/admin.css' ) );

            // Load single editor page CSS only on editor page
            // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.NonceVerification.Recommended
            if ( isset( $_GET['effects'] ) && isset( $_GET['styleid'] ) ) {
                wp_enqueue_style( 'oxilab-image-hover-single-editor-css', OXI_IMAGE_HOVER_URL . 'assets/backend/css/single_editor_page.css', false, filemtime( OXI_IMAGE_HOVER_PATH . 'assets/backend/css/single_editor_page.css' ) );
            }
		}

		if ( 'image-hover-ultimate-getting-started' === $current_page ) {
			//CSS
			wp_enqueue_style( 'image-hover-ultimate-admin-welcome', OXI_IMAGE_HOVER_URL . 'assets/backend/css/getting-started.css', false, filemtime( OXI_IMAGE_HOVER_PATH . 'assets/backend/css/getting-started.css' ) );
			//JS
			wp_enqueue_script( 'image-hover-ultimate-admin-welcome-js', OXI_IMAGE_HOVER_URL . 'assets/backend/js/getting-started.js', [ 'jquery' ], filemtime( OXI_IMAGE_HOVER_PATH . 'assets/backend/js/getting-started.js' ), true );
		}
	}

	public function loader_font_familly_validation( $data = [] ) {
        foreach ( $data as $value ) {
            wp_enqueue_style( '' . $value . '', 'https://fonts.googleapis.com/css?family=' . $value . '', false, OXI_IMAGE_HOVER_PLUGIN_VERSION );
        }
    }

	/**
	 * Method public_enqueue_scripts.
	 *
	 * @since 2.10.1
	 */
	public function public_enqueue_scripts() {
	}
}
