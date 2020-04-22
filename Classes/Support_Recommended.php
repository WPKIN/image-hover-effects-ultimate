<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

/**
 * Description of Support_Recommended
 *
 * @author $biplob018
 */
class Support_Recommended {

    /**
     * Revoke this function when the object is created.
     *
     */
    public function __construct() {
        require_once(ABSPATH . 'wp-admin/includes/screen.php');
        if (!current_user_can('install_plugins')):
            return;
        endif;
        $screen = get_current_screen();
        if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
            return;
        }
        add_action('admin_notices', array($this, 'first_install'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('admin_notices', array($this, 'dismiss_button_scripts'));
    }

    /**
     * First Installation Track
     * @return void
     */
    public function first_install() {
        $installed_plugins = get_plugins();
        $plugin = '';
//        if (isset($installed_plugins['elementor/elementor.php'])):
//            if (!isset($installed_plugins['sb-image-hover-effects/index.php'])):
//                $plugin = 'sb-image-hover-effects';
//            endif;
//        else
        if (!isset($installed_plugins['shortcode-addons/index.php'])):
            $plugin = 'shortcode-addons';
        endif;
        if (!empty($plugin)):
            if ($plugin == 'sb-image-hover-effects'):
                $massage = '<p>Thank you for using <strong>Elementor Page Builder</strong>. We suggest you to use our <a href="https://wordpress.org/plugins/sb-image-hover-effects/">Elementor Addons</a> - Premuim Elementor Addons comes with 100+ Elements and Elementor Template Library. Header Footer Builder and Menu Builder also Included with this Mega Addons</p>';
            else:
                $massage = '<p>Thank you for using my Image Hover Effects Ultimate.  We suggest you to use our <a href="https://wordpress.org/plugins/shortcode-addons/">Shortcode Addons</a>, The most Easiest Shortcode Builder with 120+ Elements. Create your wonderful website with most Flexible, Creative and Mordern Elements .</p>';
            endif;
            $install_url = wp_nonce_url(add_query_arg(array('action' => 'install-plugin', 'plugin' => $plugin), admin_url('update.php')), 'install-plugin' . '_' . $plugin);
            echo '<div class="oxi-addons-admin-notifications" style=" width: auto;">
                        <h3>
                            <span class="dashicons dashicons-flag"></span> 
                            Notifications
                        </h3>
                        <p></p>
                        <div class="oxi-addons-admin-notifications-holder">
                            <div class="oxi-addons-admin-notifications-alert">
                                ' . $massage . '
                                <p>' . sprintf('<a href="%s" class="button button-large button-primary">%s</a>', $install_url, __('Install Now', OXI_IMAGE_HOVER_TEXTDOMAIN)) . ' &nbsp;&nbsp;<a href="#" class="button button-large button-secondary oxi-image-admin-recommended-dismiss">No, Thanks</a></p>
                            </div>                     
                        </div>
                        <p></p>
                    </div>';
        endif;
    }

    /**
     * Admin Notice CSS file loader
     * @return void
     */
    public function admin_enqueue_scripts() {
        wp_enqueue_script("jquery");
        wp_enqueue_style('oxi-image-admin-notice-css', OXI_IMAGE_HOVER_URL . '/assets/backend/css/notice.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        $this->dismiss_button_scripts();
    }

    /**
     * Admin Notice JS file loader
     * @return void
     */
    public function dismiss_button_scripts() {
        wp_enqueue_script('oxi-image-admin-recommended', OXI_IMAGE_HOVER_URL . '/assets/backend/js/admin-recommended.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        wp_localize_script('oxi-image-admin-recommended', 'ImageHoverUltimate', array(
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        ));
    }

}
