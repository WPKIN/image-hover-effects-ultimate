<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Includes\Admin\Pages;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Description of Settings
 *
 * @author
 */
class Settings {

    use \OXI_IMAGE_HOVER_PLUGINS\Helper\CSS_JS_Loader;

    public $roles;
    public $saved_role;
    public $oxi_fixed_header;
    public $fontawesome;
    public $getfontawesome = [];

    /**
     * Constructor of Oxilab tabs Home Page
     *
     * @since 9.3.0
     */
    public function __construct() {
        $this->admin();
        $this->css_loader();
        $this->Render();
    }

    public function admin() {
        global $wp_roles;
        $this->roles      = $wp_roles->get_names();
        $this->saved_role = get_option( 'oxi_image_user_permission' );
    }

    public function css_loader() {
        $this->admin_js();
        wp_enqueue_script(
            'oxi-image-hover-settings',
            OXI_IMAGE_HOVER_URL . 'assets/backend/js/settings.js',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );
    }

    public function Render() {
        ?>
        <div class="wrap">
            <?php apply_filters( 'oxi-image-hover-plugin/admin_menu', true ); ?>

            <div class="oxi-addons-row oxi-addons-admin-settings">
                <h2><?php esc_html_e( 'General', 'image-hover-effects-ultimate' ); ?></h2>
                <p><?php esc_html_e( 'Settings for Image Hover Effects Ultimate.', 'image-hover-effects-ultimate' ); ?></p>
                <form method="post">

                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="oxi_image_user_permission"><?php esc_html_e( 'Who Can Edit?', 'image-hover-effects-ultimate' ); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <select name="oxi_image_user_permission" id="oxi_image_user_permission">
                                            <?php foreach ( $this->roles as $key => $role ) : ?>
                                                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $this->saved_role, $key ); ?>>
                                                    <?php echo esc_html( $role ); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="oxi-addons-settings-connfirmation oxi_image_user_permission"></span>
                                        <br>
                                        <p class="description">
                                            <?php esc_html_e( 'Select the role who can manage this plugin.', 'image-hover-effects-ultimate' ); ?>
                                            <a target="_blank" href="https://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table">
                                                <?php esc_html_e( 'Help', 'image-hover-effects-ultimate' ); ?>
                                            </a>
                                        </p>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="image_hover_ultimate_mobile_device_key"><?php esc_html_e( 'Mobile or Touch Device Behaviour', 'image-hover-effects-ultimate' ); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label>
                                            <input type="radio" class="radio" name="image_hover_ultimate_mobile_device_key" value="" <?php checked( '', get_option( 'image_hover_ultimate_mobile_device_key' ), true ); ?>>
                                            <?php esc_html_e( 'Yes', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <label>
                                            <input type="radio" class="radio" name="image_hover_ultimate_mobile_device_key" value="normal" <?php checked( 'normal', get_option( 'image_hover_ultimate_mobile_device_key' ), true ); ?>>
                                            <?php esc_html_e( 'No', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <span class="oxi-addons-settings-connfirmation image_hover_ultimate_mobile_device_key"></span>
                                        <br>
                                        <p class="description"><?php esc_html_e( 'Select option as effects first with second tap to open link or works normally as click to open link.', 'image-hover-effects-ultimate' ); ?></p>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="oxi_addons_font_awesome"><?php esc_html_e( 'Font Awesome Support', 'image-hover-effects-ultimate' ); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label>
                                            <input type="radio" class="radio" name="oxi_addons_font_awesome" value="yes" <?php checked( 'yes', get_option( 'oxi_addons_font_awesome' ), true ); ?>>
                                            <?php esc_html_e( 'Yes', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <label>
                                            <input type="radio" class="radio" name="oxi_addons_font_awesome" value="no" <?php checked( 'no', get_option( 'oxi_addons_font_awesome' ), true ); ?>>
                                            <?php esc_html_e( 'No', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <span class="oxi-addons-settings-connfirmation oxi_addons_font_awesome"></span>
                                        <br>
                                        <p class="description"><?php esc_html_e( 'Load Font Awesome CSS at shortcode loading. If your theme already loads it, select No for faster loading.', 'image-hover-effects-ultimate' ); ?></p>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="oxi_addons_way_points"><?php esc_html_e( 'Waypoints Support', 'image-hover-effects-ultimate' ); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label>
                                            <input type="radio" class="radio" name="oxi_addons_way_points" value="" <?php checked( '', get_option( 'oxi_addons_way_points' ), true ); ?>>
                                            <?php esc_html_e( 'Yes', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <label>
                                            <input type="radio" class="radio" name="oxi_addons_way_points" value="no" <?php checked( 'no', get_option( 'oxi_addons_way_points' ), true ); ?>>
                                            <?php esc_html_e( 'No', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <span class="oxi-addons-settings-connfirmation oxi_addons_way_points"></span>
                                        <br>
                                        <p class="description"><?php esc_html_e( 'Load Way Points at shortcode loading while animated. If your theme already loads it, select No for faster loading.', 'image-hover-effects-ultimate' ); ?></p>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="oxi_addons_google_font"><?php esc_html_e( 'Google Font Support', 'image-hover-effects-ultimate' ); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label>
                                            <input type="radio" class="radio" name="oxi_addons_google_font" value="" <?php checked( '', get_option( 'oxi_addons_google_font' ), true ); ?>>
                                            <?php esc_html_e( 'Yes', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <label>
                                            <input type="radio" class="radio" name="oxi_addons_google_font" value="no" <?php checked( 'no', get_option( 'oxi_addons_google_font' ), true ); ?>>
                                            <?php esc_html_e( 'No', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <span class="oxi-addons-settings-connfirmation oxi_addons_google_font"></span>
                                        <br>
                                        <p class="description"><?php esc_html_e( 'Load Google font from Google while loading shortcode. If you already load those locally, select No for faster loading.', 'image-hover-effects-ultimate' ); ?></p>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="oxi_addons_custom_parent_class"><?php esc_html_e( 'Custom Parent Class', 'image-hover-effects-ultimate' ); ?></label>
                                </th>
                                <td class="valid">
                                    <input type="text" class="regular-text" id="oxi_addons_custom_parent_class" name="oxi_addons_custom_parent_class" value="<?php echo esc_attr( get_option( 'oxi_addons_custom_parent_class' ) ); ?>">
                                    <span class="oxi-addons-settings-connfirmation oxi_addons_custom_parent_class"></span>
                                    <p class="description"><?php esc_html_e( 'Add custom parent class to avoid conflict with theme or plugins.', 'image-hover-effects-ultimate' ); ?></p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">
                                    <label for="oxi_image_support_massage"><?php esc_html_e( 'Display Support Message', 'image-hover-effects-ultimate' ); ?></label>
                                </th>
                                <td>
                                    <fieldset>
                                        <label>
                                            <input type="radio" class="radio" name="oxi_image_support_massage" value="" <?php checked( '', get_option( 'oxi_image_support_massage' ), true ); ?>>
                                            <?php esc_html_e( 'Yes', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <label>
                                            <input type="radio" class="radio" name="oxi_image_support_massage" value="no" <?php checked( 'no', get_option( 'oxi_image_support_massage' ), true ); ?>>
                                            <?php esc_html_e( 'No', 'image-hover-effects-ultimate' ); ?>
                                        </label>
                                        <span class="oxi-addons-settings-connfirmation oxi_image_support_massage"></span>
                                        <br>
                                        <p class="description"><?php esc_html_e( 'Display support message at Image Hover admin area. If not needed, select No.', 'image-hover-effects-ultimate' ); ?></p>
                                    </fieldset>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <?php
    }
}
