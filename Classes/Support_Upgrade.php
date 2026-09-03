<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Pro upgrade notice.
 *
 * Shown to free users who have had the plugin installed for more than 10 days.
 *
 * Scope is deliberately narrow, per the WordPress.org plugin guidelines
 * (guideline 11, "Plugins should not hijack the admin dashboard"): upgrade
 * prompts must be limited in scope and used sparingly, contextually or only on
 * the plugin's own screens. So this notice renders ONLY on this plugin's admin
 * pages, never site-wide, and is dismissible both temporarily and permanently.
 * The pricing link carries no referral or tracking parameters (guideline 7).
 *
 * @since 9.11.8
 */
class Support_Upgrade {

	/**
	 * Admin pages this notice is allowed to appear on.
	 *
	 * @var string[]
	 */
	private $allowed_pages = [
		'oxi-image-hover-ultimate',
		'oxi-image-hover-shortcode',
		'oxi-image-hover-ultimate-settings',
	];

	public function __construct() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		add_action( 'wp_ajax_oxi_image_admin_upgrade_notice', [ $this, 'ajax_action' ] );
		add_action( 'admin_notices', [ $this, 'render' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
	}

	/**
	 * Whether the current request is one of this plugin's own admin screens.
	 *
	 * The full-screen effect editor is excluded: it hides admin notices by
	 * design, so rendering there would only add dead markup.
	 *
	 * @return bool
	 */
	private function is_plugin_screen() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

		if ( ! in_array( $page, $this->allowed_pages, true ) ) {
			return false;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['effects'] ) && isset( $_GET['styleid'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Notice markup.
	 *
	 * @return void
	 */
	public function render() {
		if ( ! $this->is_plugin_screen() ) {
			return;
		}

		$image   = OXI_IMAGE_HOVER_URL . 'image/logo.png';
		$pricing = 'https://oxilab.dev/image-hover-effects/pricing/';

		$features = [
			__( '500+ hover effects', 'image-hover-effects-ultimate' ),
			__( '1500+ ready layouts', 'image-hover-effects-ultimate' ),
			__( 'Carousel, Filter & Lightbox', 'image-hover-effects-ultimate' ),
			__( 'Priority support', 'image-hover-effects-ultimate' ),
		];
		?>
		<div class="notice oxi-iheu-upgrade-notice oxilab-image-hover-upgrade-notice">

			<div class="oxi-iheu-upgrade-notice__logo">
				<img src="<?php echo esc_url( $image ); ?>"
					alt="<?php esc_attr_e( 'Image Hover Effects Ultimate', 'image-hover-effects-ultimate' ); ?>">
			</div>

			<div class="oxi-iheu-upgrade-notice__body">

				<span class="oxi-iheu-upgrade-notice__badge">
					<?php esc_html_e( 'Pro', 'image-hover-effects-ultimate' ); ?>
				</span>

				<h3 class="oxi-iheu-upgrade-notice__title">
					<?php esc_html_e( 'Ready for the full effect library?', 'image-hover-effects-ultimate' ); ?>
				</h3>

				<p class="oxi-iheu-upgrade-notice__text">
					<?php esc_html_e( 'You have been building with the free version for a while. Pro adds the complete effect and layout library, every extension, and direct support from the team that builds the plugin.', 'image-hover-effects-ultimate' ); ?>
				</p>

				<ul class="oxi-iheu-upgrade-notice__features">
					<?php foreach ( $features as $feature ) : ?>
						<li>
							<span class="dashicons dashicons-yes" aria-hidden="true"></span>
							<?php echo esc_html( $feature ); ?>
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="oxi-iheu-upgrade-notice__actions">
					<?php // Plain pricing link, no referral or tracking parameters. ?>
					<a class="oxi-iheu-upgrade-btn oxi-iheu-upgrade-btn--primary"
						href="<?php echo esc_url( $pricing ); ?>"
						target="_blank"
						rel="noopener noreferrer">
						<?php esc_html_e( 'See Pro plans', 'image-hover-effects-ultimate' ); ?>
					</a>

					<button type="button"
						class="oxi-iheu-upgrade-btn oxi-iheu-upgrade-btn--ghost oxi-image-upgrade-dismiss"
						sup-data="maybe">
						<?php esc_html_e( 'Maybe later', 'image-hover-effects-ultimate' ); ?>
					</button>

					<button type="button"
						class="oxi-iheu-upgrade-btn oxi-iheu-upgrade-btn--quiet oxi-image-upgrade-dismiss"
						sup-data="never">
						<?php esc_html_e( 'Do not show this again', 'image-hover-effects-ultimate' ); ?>
					</button>
				</div>
			</div>

			<button type="button"
				class="oxi-iheu-upgrade-notice__close oxi-image-upgrade-dismiss"
				sup-data="maybe"
				aria-label="<?php esc_attr_e( 'Remind me later', 'image-hover-effects-ultimate' ); ?>">
				<span class="dashicons dashicons-no-alt" aria-hidden="true"></span>
			</button>
		</div>
		<?php
	}

	/**
	 * Assets. Shares admin-notice.js and notice.css with the review notice.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		if ( ! $this->is_plugin_screen() ) {
			return;
		}

		wp_enqueue_style(
			'oxi-image-admin-notice-css',
			OXI_IMAGE_HOVER_URL . 'assets/backend/css/notice.css',
			false,
			filemtime( OXI_IMAGE_HOVER_PATH . 'assets/backend/css/notice.css' )
		);
		wp_enqueue_script(
			'oxi-image-admin-notice',
			OXI_IMAGE_HOVER_URL . 'assets/backend/js/admin-notice.js',
			[ 'jquery' ],
			filemtime( OXI_IMAGE_HOVER_PATH . 'assets/backend/js/admin-notice.js' ),
			true
		);
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
	 * Dismissal handler.
	 *
	 * 'maybe' pushes the 10 day clock forward, anything else silences the
	 * notice for good.
	 *
	 * @return void
	 */
	public function ajax_action() {
		$wpnonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ) : '';
		if ( ! wp_verify_nonce( $wpnonce, 'image_hover_ultimate' ) ) {
			wp_send_json_error( __( 'Invalid request', 'image-hover-effects-ultimate' ), 422 );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'Insufficient permissions', 'image-hover-effects-ultimate' ), 403 );
		}

		$notice = isset( $_POST['notice'] ) ? sanitize_text_field( wp_unslash( $_POST['notice'] ) ) : '';

		if ( 'maybe' === $notice ) {
			update_option( 'oxi_image_hover_upgrade_date', strtotime( 'now' ) );
		} else {
			update_option( 'oxi_image_hover_upgrade_nobug', 'never' );
		}

		wp_send_json_success( 'Done' );
	}
}
