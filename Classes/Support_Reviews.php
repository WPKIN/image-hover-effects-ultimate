<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Support_Reviews
 *
 * @author $biplob018
 */
class Support_Reviews {

    /**
     * Revoke this function when the object is created.
     *
     */
    public function __construct() {
        if (!current_user_can('manage_options')) {
            return;
        }
        add_action('wp_ajax_oxi_image_admin_notice', [$this, 'ajax_action']);
        add_action('admin_notices', [$this, 'first_install']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        add_action('admin_notices', [$this, 'dismiss_button_scripts']);
    }

    public function ajax_action() {

        $wpnonce = sanitize_key(wp_unslash($_POST['_wpnonce']));
        if (!wp_verify_nonce($wpnonce, 'image_hover_ultimate')) :
            return new \WP_REST_Request('Invalid URL', 422);
            die();
        endif;
        $notice = $_POST['notice'];
        if ($notice == 'maybe') :
            $data = strtotime("now");
            update_option('oxi_image_hover_activation_date', $data);
        else :
            update_option('oxi_image_hover_nobug', $notice);
        endif;
        return 'Done';
        die();
    }

    /**
     * Admin Notice JS file loader
     * @return void
     */
    public function dismiss_button_scripts() {
        wp_enqueue_script('oxi-image-admin-notice', OXI_IMAGE_HOVER_URL . 'assets/backend/js/admin-notice.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        wp_localize_script('oxi-image-admin-notice',
                'oxi_image_admin_notice',
                [
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('image_hover_ultimate')
        ]);
    }

    /**
     * Admin Notice CSS file loader
     * @return void
     */
    public function admin_enqueue_scripts() {
        wp_enqueue_script("jquery");
        wp_enqueue_style('oxi-image-admin-notice-css', OXI_IMAGE_HOVER_URL . 'assets/backend/css/notice.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        $this->dismiss_button_scripts();
    }

    /**
     * First Installation Track
     * @return void
     */
    public function first_install() {

        $image = OXI_IMAGE_HOVER_URL . 'image/logo.png';
        ?>
        <div class="notice notice-info put-dismiss-noticenotice-has-thumbnail shortcode-addons-review-notice oxilab-image-hover-review-notice">
            <div class="shortcode-addons-notice-thumbnail">
                <img src="<?php echo esc_url($image); ?>" alt=""></div>
            <div class="shortcode-addons--notice-message">
                <p>Hey, You’ve using <strong>Image Hover Effects Ultimate – Captions Hover with Visual Composer
                        Extension</strong> more than 1 week – that’s awesome! Could you please do me a BIG favor and
                    give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.!
                </p>
                <ul class="shortcode-addons--notice-link">
                    <li>
                        <a href="https://wordpress.org/support/plugin/image-hover-effects-ultimate/reviews/"
                           target="_blank">
                            <span class="dashicons dashicons-external"></span>Ok, you deserve it!
                        </a>
                    </li>
                    <li>
                        <a class="oxi-image-support-reviews" sup-data="success" href="#">
                            <span class="dashicons dashicons-smiley"></span>I already did
                        </a>
                    </li>
                    <li>
                        <a class="oxi-image-support-reviews" sup-data="maybe" href="#">
                            <span class="dashicons dashicons-calendar-alt"></span>Maybe Later
                        </a>
                    </li>
                    <li>
                        <a href="https://wordpress.org/support/plugin/image-hover-effects-ultimate/">
                            <span class="dashicons dashicons-sos"></span>I need help
                        </a>
                    </li>
                    <li>
                        <a class="oxi-image-support-reviews" sup-data="never" href="#">
                            <span class="dashicons dashicons-dismiss"></span>Never show again
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
    }
}
