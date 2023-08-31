<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Support_Recommended
 *
 * @author $biplob018
 */
class Support_Recommended
{
    /**
     * Revoke this function when the object is created.
     *
     */
    const GET_LOCAL_PLUGINS = 'get_all_oxilab_plugins';
    const PLUGINS = 'https://www.oxilab.org/wp-json/oxilabplugins/v2/all_plugins';

    public $get_plugins = [];
    public $current_plugins = 'image-hover-effects-ultimate/index.php';

    public function __construct()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        require_once(ABSPATH . 'wp-admin/includes/screen.php');
        $screen = get_current_screen();
        if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
            return;
        }
        $this->extension();
        add_action('wp_ajax_oxi_image_admin_recommended', [$this, 'ajax_action']);
        add_action('admin_notices', [$this, 'first_install']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        add_action('admin_notices', [$this, 'dismiss_button_scripts']);
    }

    public function ajax_action()
    {

        $wpnonce = sanitize_key(wp_unslash($_POST['_wpnonce']));
        if (!wp_verify_nonce($wpnonce, 'image_hover_ultimate')) :
            return new \WP_REST_Request('Invalid URL', 422);
            die();
        endif;

        $notice = $_POST['notice'];
        update_option('oxi_image_hover_recommended', $notice);
        echo $notice;
        die();
    }

    /**
     * Admin Notice JS file loader
     * @return void
     */
    public function dismiss_button_scripts()
    {
        wp_enqueue_script('oxi-image-admin-recommended', OXI_IMAGE_HOVER_URL . 'assets/backend/js/admin-recommended.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        wp_localize_script(
            'oxi-image-admin-recommended',
            'oxi_image_admin_recommended',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('image_hover_ultimate')
            ]
        );
    }
    /**
     * Admin Notice CSS file loader
     * @return void
     */
    public function admin_enqueue_scripts()
    {
        wp_enqueue_script("jquery");
        wp_enqueue_style('oxi-image-admin-notice-css', OXI_IMAGE_HOVER_URL . 'assets/backend/css/notice.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        $this->dismiss_button_scripts();
    }

    /**
     * First Installation Track
     * @return void
     */
    public function first_install()
    {
        $installed_plugins = get_plugins();

        $plugin = [];
        $i = 1;

        foreach ($this->get_plugins as $key => $value) {
            if (!isset($installed_plugins[$value['modules-path']])) :
                $plugin[$i] = $value;
                $i++;
            endif;
        }


        $recommend = [];

        for ($p = 1; $p < 100; $p++) :
            if (isset($plugin[$p]) && count($recommend) < 3) :
                if (isset($plugin[$p]['dependency']) && $plugin[$p]['dependency'] != '') :
                    if (isset($installed_plugins[$plugin[$p]['dependency']])) :
                        $recommend = $plugin[$p];
                        $p = 100;
                    endif;
                elseif ($plugin[$p]['modules-path'] != $this->current_plugins) :

                    $recommend = $plugin[$p];
                    $p = 100;
                endif;

            else :
                $p = 100;
            endif;
        endfor;

        if (count($recommend) > 2 && $recommend['modules-path'] != '') :
            $plugin = explode('/', $recommend['modules-path'])[0];
            $install_url = wp_nonce_url(add_query_arg(['action' => 'install-plugin', 'plugin' => $plugin], admin_url('update.php')), 'install-plugin' . '_' . $plugin);
?>


            <div class="oxi-addons-admin-notifications" style=" width: auto;">
                <h3>
                    <span class="dashicons dashicons-flag"></span>
                    Notifications
                </h3>
                <p></p>
                <div class="oxi-addons-admin-notifications-holder">
                    <div class="oxi-addons-admin-notifications-alert">
                        <p>Thank you for using our Image Hover Effects
                            Ultimate. <?php echo $recommend['modules-massage']; ?></p>
                        <p><a href="<?php echo esc_url($install_url); ?>" class="button button-large button-primary"><?php echo esc_html__('Install Now', 'image-hover-effects-ultimate'); ?></a>
                            &nbsp;&nbsp;<a href="#" class="button button-large button-secondary oxi-image-admin-recommended-dismiss">No,
                                Thanks</a></p>
                    </div>
                </div>
                <p></p>
            </div>

<?php
        endif;
    }

    public function extension()
    {
        $response = get_transient(self::GET_LOCAL_PLUGINS);
        if (!$response || !is_array($response)) {
            $URL = self::PLUGINS;
            $request = wp_remote_request($URL);
            if (!is_wp_error($request)) {
                $response = json_decode(wp_remote_retrieve_body($request), true);
                set_transient(self::GET_LOCAL_PLUGINS, $response, 10 * DAY_IN_SECONDS);
            } else {
                $response = $request->get_error_message();
            }
        }
        $this->get_plugins = $response;
    }
}
