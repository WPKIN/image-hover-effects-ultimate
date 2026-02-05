<?php

/**
 * Plugin Name:       Image Hover Effects Ultimate
 * Plugin URI:        https://wpkin.com
 * Description:       Create Awesome Image Hover Effects as Image Gallery, Lightbox, Comparison and Magnifier with Impressive, Lightweight, Responsive Image Hover Effects Ultimate. Use 500+ modern and elegant CSS hover effects and animations.
 * Version:           9.11.0
 * Author:            WPKIN
 * Author URI:        https://wpkin.com
 * Text Domain:       image-hover-effects-ultimate
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package image hover effects ultimate.
 */

if (! defined('ABSPATH')) {
	wp_die(esc_html__('You can\'t access this page', 'image-hover-effects-ultimate'));
}

/* *
 * Including composer autoloader globally.
 *
 * @since 9.3.0
 */
require_once __DIR__ . '/vendor/autoload.php';


if (! function_exists('wpkin_iheu_v')) {
	// Create a helper function for easy SDK access.
	function wpkin_iheu_v()
	{
		global $wpkin_iheu_v;

		if (! isset($wpkin_iheu_v)) {
			$wpkin_iheu_v = fs_dynamic_init(
				[
					'id'                  => '20097',
					'slug'                => 'oxi-image-hover-ultimate',
					'type'                => 'plugin',
					'public_key'          => 'pk_5ae72b1982d4390e3fef586fb2b4e',
					'is_premium'          => false,
					'has_premium_version' => false,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					'menu'                => [
						'slug'           => 'oxi-image-hover-ultimate',
						'first-path'     => 'admin.php?page=image-hover-ultimate-getting-started',
						'contact'        => false,
						'support'        => false,
						'pricing'        => false,
					],
				]
			);
		}

		return $wpkin_iheu_v;
	}

	// Init Freemius.
	wpkin_iheu_v();
	// Signal that SDK was initiated.
	do_action('wpkin_iheu_v_loaded');
}

/** If class `WPKin_Imagehover` doesn't exists yet. */
if (! class_exists('WPKin_Imagehover')) {

	/**
	 * Sets up and initializes the plugin.
	 * Main initiation class
	 *
	 * @since 1.0.0
	 */
	final class WPKin_Imagehover
	{

		use \OXI_IMAGE_HOVER_PLUGINS\Helper\Public_Helper;
		use \OXI_IMAGE_HOVER_PLUGINS\Helper\Admin_helper;

		/**
		 * WordPress Database Object
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

		/**
		 * Class Constractor
		 */
		private function __construct()
		{

			$this->define_constance();
			register_activation_hook(__FILE__, [$this, 'activate']);
			register_deactivation_hook(__FILE__, [$this, 'deactivate']);
			do_action('image-hover-effects-ultimate/before_init');
			add_action('init', [$this, 'init_plugin'], 20);
		}

		/**
		 * Initilize a singleton instance
		 *
		 * @return /Product_Layouts
		 */
		public static function init()
		{

			static $instance = false;

			if (! $instance) {
				$instance = new self();
			}

			return $instance;
		}

		/**
		 * Plugin Constance
		 *
		 * @return void
		 */
		public function define_constance()
		{
			define('OXI_IMAGE_HOVER_FILE', __FILE__);
			define('OXI_IMAGE_HOVER_BASENAME', plugin_basename(__FILE__));
			define('OXI_IMAGE_HOVER_PATH', plugin_dir_path(__FILE__));
			define('OXI_IMAGE_HOVER_URL', plugins_url('/', __FILE__));
			define('OXI_IMAGE_HOVER_PLUGIN_VERSION', '9.11.0');
			define('OXI_IMAGE_HOVER_TEXTDOMAIN', 'image-hover-effects-ultimate');
		}

		/**
		 * Plugins Loaded
		 *
		 * @return void
		 */
		public function init_plugin()
		{

			new OXI_IMAGE_HOVER_PLUGINS\Includes\Assets();
			new OXI_IMAGE_HOVER_PLUGINS\Classes\ImageApi();

			if (is_admin()) {
				new OXI_IMAGE_HOVER_PLUGINS\Includes\Admin();
				$this->User_Admin();
				$this->User_Reviews();
			}
			$this->Admin_Filters();
			$this->Shortcode_loader();
			$this->Public_loader();
			$this->register_image_hover_ultimate_update();
		}

		/**
		 * After Activate Plugin
		 *
		 * Fired by `register_activation_hook` hook.
		 *
		 * @return void
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function activate()
		{
			$Installation = new \OXI_IMAGE_HOVER_PLUGINS\Classes\Installation();
			$Installation->plugin_activation_hook();
		}

		/**
		 * After Deactivate Plugin
		 *
		 * Fired by `register_deactivation_hook` hook.
		 *
		 * @return void
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function deactivate() {}

		public function User_Admin()
		{
			add_action('admin_head', [$this, 'Admin_Icon']);
		}

		/**
		 * Execute Shortcode
		 *
		 * @since 9.3.0
		 * @access public
		 */
		public function WP_Shortcode($atts)
		{
			extract(shortcode_atts(['id' => ' '], $atts));
			$styleid = (int) $atts['id'];
			ob_start();
			$this->shortcode_render($styleid, 'user');
			return ob_get_clean();
		}

		/**
		 * Shortcode loader
		 *
		 * @since 9.3.0
		 * @access public
		 */
		protected function Shortcode_loader()
		{
			add_shortcode('iheu_ultimate_oxi', [$this, 'WP_Shortcode']);
			new \OXI_IMAGE_HOVER_PLUGINS\Modules\Visual_Composer();
			$ImageWidget = new \OXI_IMAGE_HOVER_PLUGINS\Modules\Widget();
			add_filter('widget_text', 'do_shortcode');
			add_action('widgets_init', [$ImageWidget, 'iheu_widget_widget']);
		}

		public function register_image_hover_ultimate_update()
		{
			$check = get_option('image_hover_ultimate_update_complete');
			if ($check != 'done') :
				add_action('image_hover_ultimate_update', [$this, 'plugin_update']);
				wp_schedule_single_event(time() + 10, 'image_hover_ultimate_update');
			endif;
		}

		public function plugin_update()
		{
			$upgrade = new \OXI_IMAGE_HOVER_PLUGINS\Classes\ImageApi();
			$upgrade->update_image_hover_plugin();
		}
	}
}

/**
 * Initilize the main plugin
 *
 * @return /WPKin_Imagehover
 */
function wpkin_imagehover()
{

	if (class_exists('WPKin_Imagehover')) {
		return WPKin_Imagehover::init();
	}

	return false;
}

/**
 * Kick-off the plugin
 */
wpkin_imagehover();
