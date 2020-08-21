<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if (!defined('ABSPATH'))
    exit;

/**
 * Description of Bootstrap
 *
 * @author $biplob018
 */
use OXI_IMAGE_HOVER_PLUGINS\Classes\ImageApi as IMAGEAPI;

class Bootstrap {

    use \OXI_IMAGE_HOVER_PLUGINS\Helper\Public_Helper;
    use \OXI_IMAGE_HOVER_PLUGINS\Helper\Admin_helper;

    // instance container
    private static $instance = null;

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
     * Admin Menu
     *
     * @since 9.3.0
     */
    const ADMINMENU = 'get_oxilab_addons_menu';

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct() {
        do_action('image-hover-effects-ultimate/before_init');
        // Load translation
        add_action('init', array($this, 'i18n'));
        $this->Shortcode_loader();
        $this->Public_loader();
        new IMAGEAPI();
        if (is_admin()) {
            $this->Admin_Filters();
            $this->User_Admin();
            $this->User_Reviews();
        }
        add_action('init', [$this, 'register_image_hover_ultimate_update']);
    }

    public function register_image_hover_ultimate_update() {
        $check = get_option('image_hover_ultimate_update_complete');
        if ($check != 'done'):
            add_action('image_hover_ultimate_update', [$this, 'plugin_update']);
            wp_schedule_single_event(time() + 10, 'image_hover_ultimate_update');
        endif;
    }

    public function plugin_update() {
        $upgrade = new \OXI_IMAGE_HOVER_PLUGINS\Classes\ImageApi();
        $upgrade->update_image_hover_plugin();
    }

    /**
     * Load Textdomain
     *
     * @since 9.3.0
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain('image-hover-effects-ultimate');
    }

    /**
     * Shortcode loader
     *
     * @since 9.3.0
     * @access public
     */
    protected function Shortcode_loader() {
        add_shortcode('iheu_ultimate_oxi', [$this, 'WP_Shortcode']);
        new \OXI_IMAGE_HOVER_PLUGINS\Modules\Visual_Composer();
        $ImageWidget = new \OXI_IMAGE_HOVER_PLUGINS\Modules\Widget();
        add_filter('widget_text', 'do_shortcode');
        add_action('widgets_init', array($ImageWidget, 'iheu_widget_widget'));
    }

    /**
     * Execute Shortcode
     *
     * @since 9.3.0
     * @access public
     */
    public function WP_Shortcode($atts) {
        extract(shortcode_atts(array('id' => ' ',), $atts));
        $styleid = $atts['id'];
        ob_start();
        $this->shortcode_render($styleid, 'user');
        return ob_get_clean();
    }

    public function Public_loader() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
        $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
        $this->import_table = $this->wpdb->prefix . 'oxi_div_import';
    }

    public function Admin_Filters() {
        add_filter($this->fixed_data('6f78692d696d6167652d686f7665722d737570706f72742d616e642d636f6d6d656e7473'), array($this, $this->fixed_data('537570706f7274416e64436f6d6d656e7473')));
        add_filter($this->fixed_data('6f78692d696d6167652d686f7665722d706c7567696e2d76657273696f6e'), array($this, $this->fixed_data('636865636b5f63757272656e745f76657273696f6e')));
        add_filter($this->fixed_data('6f78692d696d6167652d686f7665722d706c7567696e2f61646d696e5f6d656e75'), array($this, $this->fixed_data('6f78696c61625f61646d696e5f6d656e75')));
    }

    public function User_Admin() {
        $this->Admin_Settings();
        add_action('admin_menu', [$this, 'Admin_Menu']);
        add_action('admin_head', [$this, 'Admin_Icon']);
        add_action('admin_init', array($this, 'redirect_on_activation'));
    }

    public function Admin_Settings() {
        add_action('admin_init', [$this, 'image_hover_settings']);
        add_action('admin_init', [$this, 'register_license']);
        add_action('admin_init', [$this, 'activate_license']);
        add_action('admin_init', [$this, 'deactivate_license']);
    }

    public function image_hover_settings() {
        //register our settings
        register_setting('oxi-image-hover-settings-group', 'oxi_addons_user_permission');
        register_setting('oxi-image-hover-settings-group', 'image_hover_ultimate_mobile_device_key');
        register_setting('oxi-image-hover-settings-group', 'oxi_addons_font_awesome');
        register_setting('oxi-image-hover-settings-group', 'oxi_addons_way_points');
        register_setting('oxi-image-hover-settings-group', 'oxi_addons_google_font');
        register_setting('oxi-image-hover-settings-group', 'oxi_addons_custom_parent_class');
    }

    public function register_license() {
        register_setting('oxi_image_hover_license', 'image_hover_ultimate_license_key', [$this, 'sanitize_license']);
    }

    public function sanitize_license($new) {
        $old = get_option('image_hover_ultimate_license_key');
        if ($old && $old != $new) {
            delete_option('image_hover_ultimate_license_status');
        }
        return $new;
    }
    

    public function deactivate_license() {
        if (isset($_POST['oxi_image_hover_license_deactivate'])) {
            if (!check_admin_referer('oxi_image_hover_nonce', 'oxi_image_hover_nonce'))
                return;
            $license = trim(get_option('image_hover_ultimate_license_key'));
            $api_params = array(
                'edd_action' => 'deactivate_license',
                'license' => $license,
                'item_name' => urlencode('Image Hover Effects Ultimate'),
                'url' => home_url()
            );

            $response = wp_remote_post('https://www.oxilab.org', array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

                if (is_wp_error($response)) {
                    $message = $response->get_error_message();
                } else {
                    $message = __('An error occurred, please try again.');
                }

                $base_url = admin_url('admin.php?page=oxi-image-hover-ultimate-settings');
                $redirect = add_query_arg(array('sl_activation' => 'false', 'message' => urlencode($message)), $base_url);

                wp_redirect($redirect);
                exit();
            }
            $license_data = json_decode(wp_remote_retrieve_body($response));
            if ($license_data->license == 'deactivated') {
                delete_option('image_hover_ultimate_license_status');
            }

            wp_redirect(admin_url('admin.php?page=oxi-image-hover-ultimate-settings'));
            exit();
        }
    }

    public function activate_license() {
        if (isset($_POST['oxi_image_hover_license_activate'])) {


            if (!check_admin_referer('oxi_image_hover_nonce', 'oxi_image_hover_nonce'))
                return;
            $license = trim(get_option('image_hover_ultimate_license_key'));

            $api_params = array(
                'edd_action' => 'activate_license',
                'license' => $license,
                'item_name' => urlencode('Image Hover Effects Ultimate'),
                'url' => home_url()
            );

            $response = wp_remote_post('https://www.oxilab.org', array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
                if (is_wp_error($response)) {
                    $message = $response->get_error_message();
                } else {
                    $message = __('An error occurred, please try again.');
                }
            } else {

                $license_data = json_decode(wp_remote_retrieve_body($response));

                if (false === $license_data->success) {

                    switch ($license_data->error) {

                        case 'expired' :

                            $message = sprintf(
                                    __('Your license key expired on %s.'), date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
                            );
                            break;

                        case 'revoked' :

                            $message = __('Your license key has been disabled.');
                            break;

                        case 'missing' :

                            $message = __('Invalid license.');
                            break;

                        case 'invalid' :
                        case 'site_inactive' :

                            $message = __('Your license is not active for this URL.');
                            break;

                        case 'item_name_mismatch' :

                            $message = sprintf(__('This appears to be an invalid license key for %s.'), Responsive_Tabs_with_Accordions);
                            break;

                        case 'no_activations_left':

                            $message = __('Your license key has reached its activation limit.');
                            break;

                        default :

                            $message = __('An error occurred, please try again.');
                            break;
                    }
                }
            }

            if (!empty($message)) {
                $base_url = admin_url('admin.php?page=oxi-image-hover-ultimate-settings');
                $redirect = add_query_arg(array('sl_activation' => 'false', 'message' => urlencode($message)), $base_url);
                wp_redirect($redirect);
                exit();
            }
            update_option('image_hover_ultimate_license_status', $license_data->license);
            wp_redirect(admin_url('admin.php?page=oxi-image-hover-ultimate-settings'));
            exit();
        }
    }

}
