<?php
/**
 * Plugin Name:       Image Hover Effects Ultimate (Photo Gallery, Effects, Lightbox, Comparison or Magnifier)
 * Plugin URI:        https://www.wpkindemos.com/imagehover
 * Description:       Create Awesome Image Hover Effects as Image Gallery, Lightbox, Comparison or Magnifier with Impressive, Lightweight, Responsive Image Hover Effects Ultimate. Use 500+ modern and elegant CSS hover effects and animations.
 * Version:           9.10.0
 * Author:            WPKIN
 * Author URI:        https://wpkin.com
 * Text Domain:       image-hover-effects-ultimate
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package image hover effects ultimate.
 */

if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'image-hover-effects-ultimate' ) );
}

/* *
 * Including composer autoloader globally.
 *
 * @since 9.3.0
 */
require_once __DIR__ . '/vendor/autoload.php';


if ( ! function_exists( 'wpkin_iheu_v' ) ) {
    // Create a helper function for easy SDK access.
    function wpkin_iheu_v() {
        global $wpkin_iheu_v;

        if ( ! isset( $wpkin_iheu_v ) ) {
            $wpkin_iheu_v = fs_dynamic_init( array(
                'id'                  => '20097',
                'slug'                => 'oxi-image-hover-ultimate',
                'type'                => 'plugin',
                'public_key'          => 'pk_5ae72b1982d4390e3fef586fb2b4e',
                'is_premium'          => false,
                'has_premium_version' => false,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'menu'                => array(
                    'slug'           => 'oxi-image-hover-ultimate',
                    'contact'        => false,
                    'support'        => false,
                ),
            ) );
        }

        return $wpkin_iheu_v;
    }

    // Init Freemius.
    wpkin_iheu_v();
    // Signal that SDK was initiated.
    do_action( 'wpkin_iheu_v_loaded' );
}

define('OXI_IMAGE_HOVER_FILE', __FILE__);
define('OXI_IMAGE_HOVER_BASENAME', plugin_basename(__FILE__));
define('OXI_IMAGE_HOVER_PATH', plugin_dir_path(__FILE__));
define('OXI_IMAGE_HOVER_URL', plugins_url('/', __FILE__));
define('OXI_IMAGE_HOVER_PLUGIN_VERSION', '9.10.0');
define('OXI_IMAGE_HOVER_TEXTDOMAIN', 'image-hover-effects-ultimate');


/**
 * Run plugin after all others plugins
 *
 * @since 9.3.0
 */
add_action('plugins_loaded', function () {
    \OXI_IMAGE_HOVER_PLUGINS\Classes\Bootstrap::instance();
});

/**
 * Activation hook
 *
 * @since 9.3.0
 */
register_activation_hook(__FILE__, function () {
    $Installation = new \OXI_IMAGE_HOVER_PLUGINS\Classes\Installation();
    $Installation->plugin_activation_hook();
});
