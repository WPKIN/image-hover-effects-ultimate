<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Description of Support_Reviews
 *
 * @author $richard
 */
class Support_Reviews {

	/**
     * Revoke this function when the object is created.
     */
    public function __construct() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        add_action( 'wp_ajax_oxi_image_admin_notice', [ $this, 'ajax_action' ] );
        add_action( 'admin_notices', [ $this, 'first_install' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
        add_action( 'admin_notices', [ $this, 'dismiss_button_scripts' ] );
    }

    /**
     * Review request notice.
     *
     * Shown once the plugin has been in use for more than 7 days
     * (gated by Admin_helper::admin_notice()).
     *
     * @return void
     */
    public function first_install() {

        $image  = OXI_IMAGE_HOVER_URL . 'image/logo.png';
        $review = 'https://wordpress.org/support/plugin/image-hover-effects-ultimate/reviews/?filter=5#new-post';
        ?>
        <div class="notice oxi-iheu-review-notice oxilab-image-hover-review-notice">

            <div class="oxi-iheu-review-notice__logo">
                <img src="<?php echo esc_url( $image ); ?>"
                    alt="<?php esc_attr_e( 'Image Hover Effects Ultimate', 'image-hover-effects-ultimate' ); ?>">
            </div>

            <div class="oxi-iheu-review-notice__body">

                <div class="oxi-iheu-review-notice__stars" aria-hidden="true">
                    <span class="dashicons dashicons-star-filled"></span>
                    <span class="dashicons dashicons-star-filled"></span>
                    <span class="dashicons dashicons-star-filled"></span>
                    <span class="dashicons dashicons-star-filled"></span>
                    <span class="dashicons dashicons-star-filled"></span>
                </div>

                <h3 class="oxi-iheu-review-notice__title">
                    <?php esc_html_e( 'Enjoying Image Hover Effects Ultimate?', 'image-hover-effects-ultimate' ); ?>
                </h3>

                <p class="oxi-iheu-review-notice__text">
                    <?php esc_html_e( 'You have been creating hover effects with us for over a week now, and that is awesome! A quick 5-star review on WordPress.org takes less than a minute, and it genuinely helps us keep improving the plugin.', 'image-hover-effects-ultimate' ); ?>
                </p>

                <div class="oxi-iheu-review-notice__actions">
                    <?php // Opens the review form only, the notice deliberately stays put. ?>
                    <a class="oxi-iheu-review-btn oxi-iheu-review-btn--primary"
                        href="<?php echo esc_url( $review ); ?>"
                        target="_blank"
                        rel="noopener noreferrer">
                        <span class="dashicons dashicons-star-filled" aria-hidden="true"></span>
                        <?php esc_html_e( 'Sure, you deserve it!', 'image-hover-effects-ultimate' ); ?>
                    </a>

                    <button type="button"
                        class="oxi-iheu-review-btn oxi-iheu-review-btn--ghost oxi-image-support-reviews"
                        sup-data="success">
                        <span class="dashicons dashicons-yes-alt" aria-hidden="true"></span>
                        <?php esc_html_e( 'I already did', 'image-hover-effects-ultimate' ); ?>
                    </button>

                    <button type="button"
                        class="oxi-iheu-review-btn oxi-iheu-review-btn--quiet oxi-image-support-reviews"
                        sup-data="never">
                        <?php esc_html_e( 'Never show this again', 'image-hover-effects-ultimate' ); ?>
                    </button>
                </div>
            </div>

            <button type="button"
                class="oxi-iheu-review-notice__close oxi-image-support-reviews"
                sup-data="maybe"
                aria-label="<?php esc_attr_e( 'Remind me later', 'image-hover-effects-ultimate' ); ?>">
                <span class="dashicons dashicons-no-alt" aria-hidden="true"></span>
            </button>
        </div>
        <?php
    }

    /**
     * Admin Notice JS file loader
     * @return void
     */
    public function dismiss_button_scripts() {
        wp_enqueue_script( 'oxi-image-admin-notice', OXI_IMAGE_HOVER_URL . 'assets/backend/js/admin-notice.js', [ 'jquery' ], filemtime( OXI_IMAGE_HOVER_PATH . 'assets/backend/js/admin-notice.js' ), true );
        wp_localize_script(
            'oxi-image-admin-notice',
            'oxi_image_admin_notice',
            [
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'image_hover_ultimate' ),
            ]
        );
    }

    /**
     * Admin Notice CSS file loader
     * @return void
     */
    public function admin_enqueue_scripts() {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_style( 'oxi-image-admin-notice-css', OXI_IMAGE_HOVER_URL . 'assets/backend/css/notice.css', false, filemtime( OXI_IMAGE_HOVER_PATH . 'assets/backend/css/notice.css' ) );
        $this->dismiss_button_scripts();
    }

    public function ajax_action() {
        $wpnonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ) : '';
        if ( ! wp_verify_nonce( $wpnonce, 'image_hover_ultimate' ) ) :
            return new \WP_REST_Request( __( 'Invalid URL', 'image-hover-effects-ultimate' ), 422 );
            die();
        endif;

        $notice = isset( $_POST['notice'] ) ? sanitize_text_field( wp_unslash( $_POST['notice'] ) ) : '';
        if ( $notice === 'maybe' ) :
            $data = strtotime( 'now' );
            update_option( 'oxi_image_hover_activation_date', $data );
        else :
            update_option( 'oxi_image_hover_nobug', $notice );
        endif;

        return 'Done';
        die();
    }
}
