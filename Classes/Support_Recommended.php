<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Description of Support_Recommended
 */
class Support_Recommended {

    public $get_plugins = [];
    public $current_plugins = 'image-hover-effects-ultimate/index.php';

    public function __construct() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // get_current_screen() is only available in admin.
        require_once ABSPATH . 'wp-admin/includes/screen.php';
        $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

        // Bail out on the Updates screen to avoid odd timing.
        if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
            return;
        }

        add_action( 'wp_ajax_oxi_image_admin_recommended', [ $this, 'ajax_action' ] );
        add_action( 'admin_notices', [ $this, 'first_install' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
        add_action( 'admin_notices', [ $this, 'dismiss_button_scripts' ] );
    }

    /**
     * First Installation Track
     * Shows "Recommended" notice for companion plugins.
     */
    public function first_install() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $installed_plugins = get_plugins();

        $plugin = [];
        $i      = 1;

        foreach ( $this->get_plugins as $key => $value ) {
            if ( empty( $installed_plugins[ $value['modules-path'] ] ) ) {
                $plugin[ $i ] = $value; // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_explained
                ++$i;
            }
        }

        $recommend = [];

        for ( $p = 1; $p < 100; $p++ ) {
            if ( isset( $plugin[ $p ] ) && count( $recommend ) < 3 ) {
                if ( ! empty( $plugin[ $p ]['dependency'] ) ) {
                    if ( isset( $installed_plugins[ $plugin[ $p ]['dependency'] ] ) ) {
                        $recommend = $plugin[ $p ];
                        $p         = 100;
                    }
                } elseif ( isset( $plugin[ $p ]['modules-path'] ) && $plugin[ $p ]['modules-path'] !== $this->current_plugins ) {
                    $recommend = $plugin[ $p ];
                    $p         = 100;
                }
            } else {
                $p = 100;
            }
        }

        if ( is_array( $recommend ) && ! empty( $recommend['modules-path'] ) ) {
            $plugin_slug = explode( '/', $recommend['modules-path'] )[0];

            $install_url = wp_nonce_url(
                add_query_arg(
                    [
                        'action' => 'install-plugin',
                        'plugin' => $plugin_slug,
                    ],
                    admin_url( 'update.php' )
                ),
                'install-plugin_' . $plugin_slug
            );

            // Prepare recommended message (allow very limited HTML).
            $allowed = [
                'a'      => [
					'href' => [],
					'target' => [],
					'rel' => [],
					'class' => [],
				],
                'strong' => [],
                'em'     => [],
                'br'     => [],
                'span'   => [ 'class' => [] ],
            ];
            $modules_message = '';
            if ( isset( $recommend['modules-massage'] ) ) { // Keeping source key name as given.
                $modules_message = wp_kses( (string) $recommend['modules-massage'], $allowed );
            }
            ?>
            <div class="oxi-addons-admin-notifications" style="width:auto;">
                <h3>
                    <span class="dashicons dashicons-flag" aria-hidden="true"></span>
                    <?php esc_html_e( 'Notifications', 'image-hover-effects-ultimate' ); ?>
                </h3>
                <p></p>
                <div class="oxi-addons-admin-notifications-holder">
                    <div class="oxi-addons-admin-notifications-alert">
                        <p>
                            <?php
                            printf(
                                /* translators: %s: Plugin name. */
                                esc_html__( 'Thank you for using our %s.', 'image-hover-effects-ultimate' ),
                                'Image Hover Effects Ultimate'
                            );
                            echo ' '; // Space before the recommended message.
                            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already sanitized via wp_kses above.
                            echo $modules_message;
                            ?>
                        </p>
                        <p>
                            <a href="<?php echo esc_url( $install_url ); ?>" class="button button-large button-primary">
                                <?php esc_html_e( 'Install Now', 'image-hover-effects-ultimate' ); ?>
                            </a>
                            &nbsp;&nbsp;
                            <a href="#" class="button button-large button-secondary oxi-image-admin-recommended-dismiss">
                                <?php esc_html_e( 'No, Thanks', 'image-hover-effects-ultimate' ); ?>
                            </a>
                        </p>
                    </div>
                </div>
                <p></p>
            </div>
            <?php
        }
    }

    /**
     * Admin Notice JS file loader
     */
    public function dismiss_button_scripts() {
        wp_enqueue_script(
            'oxi-image-admin-recommended',
            OXI_IMAGE_HOVER_URL . 'assets/backend/js/admin-recommended.js',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );

        wp_localize_script(
            'oxi-image-admin-recommended',
            'oxi_image_admin_recommended',
            [
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'image_hover_ultimate' ),
            ]
        );
    }

    /**
     * Admin Notice CSS/JS loader
     */
    public function admin_enqueue_scripts() {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_style(
            'oxi-image-admin-notice-css',
            OXI_IMAGE_HOVER_URL . 'assets/backend/css/notice.css',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION
        );
        $this->dismiss_button_scripts();
    }

    /**
     * AJAX: Dismiss / Save notice preference
     */
    public function ajax_action() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error(
                [ 'message' => esc_html__( 'Unauthorized.', 'image-hover-effects-ultimate' ) ],
                403
            );
        }

        $wpnonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) : '';

        if ( ! wp_verify_nonce( $wpnonce, 'image_hover_ultimate' ) ) {
            wp_send_json_error(
                [ 'message' => esc_html__( 'Invalid nonce.', 'image-hover-effects-ultimate' ) ],
                400
            );
        }

        $notice = isset( $_POST['notice'] ) ? sanitize_text_field( wp_unslash( $_POST['notice'] ) ) : '';

        update_option( 'oxi_image_hover_recommended', $notice );

        wp_send_json_success(
            [
                'message' => esc_html__( 'Preference saved.', 'image-hover-effects-ultimate' ),
                'notice'  => $notice,
            ],
            200
        );
    }
}
