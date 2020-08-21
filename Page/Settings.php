<?php


namespace OXI_IMAGE_HOVER_PLUGINS\Page;

/**
 * Description of Settings
 *
 * @author $biplob018
 */
class Settings {

    use \OXI_IMAGE_HOVER_PLUGINS\Helper\CSS_JS_Loader;

    public $roles;
    public $saved_role;
    public $license;
    public $status;
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
        $this->Render();
    }

    public function admin() {
        global $wp_roles;
        $this->roles = $wp_roles->get_names();
        $this->saved_role = get_option('oxi_addons_user_permission');
        $this->license = get_option('image_hover_ultimate_license_key');
        $this->status = get_option('image_hover_ultimate_license_status');
    }

    public function Render() {
        $this->admin_css_loader();
        ?>
        <div class="wrap">   
            <?php
            echo apply_filters('oxi-image-hover-plugin/admin_menu', TRUE);
            ?>
            <div class="oxi-addons-row">
                <br>
                <br>
                <h2><?php _e('User Settings'); ?></h2>
                <p>Settings for Image Hover Effects Ultimate.</p>
                <form method="post" action="options.php">
                    <table class="form-table">
                        <?php settings_fields('oxi-image-hover-settings-group'); ?>
                        <?php do_settings_sections('oxi-image-hover-settings-group'); ?>
                        <tbody>
                            <tr valign="top">
                                <td scope="row" width="200">Who Can Edit?</td>
                                <td  width="200">
                                    <select name="oxi_addons_user_permission">
                                        <?php foreach ($this->roles as $key => $role) { ?>
                                            <option value="<?php echo $key; ?>" <?php selected($this->saved_role, $key); ?>><?php echo $role; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td >
                                    <label class="description" for="oxi_addons_user_permission"><?php _e('Select the Role who can manage This Plugins.'); ?> <a target="_blank" href="https://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table">Help</a></label>
                                </td>
                            </tr>     
                            <tr valign="top">
                                <td scope="row">Mobile or Touch Device Behaviour</td>
                                <td>
                                    <input type="radio" name="image_hover_ultimate_mobile_device_key" value="" <?php checked('', get_option('image_hover_ultimate_mobile_device_key'), true); ?>>YES
                                    <input type="radio" name="image_hover_ultimate_mobile_device_key" value="normal" <?php checked('normal', get_option('image_hover_ultimate_mobile_device_key'), true); ?>>No
                                </td>
                                <td>
                                    <label class="description" for="image_hover_ultimate_mobile_device_key"><?php _e('Select option as Effects first with second tap to open link or works normally as click to open link.'); ?></label>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td scope="row">Font Awesome Support</td>
                                <td>
                                    <input type="radio" name="oxi_addons_font_awesome" value="yes" <?php checked('yes', get_option('oxi_addons_font_awesome'), true); ?>>YES
                                    <input type="radio" name="oxi_addons_font_awesome" value="" <?php checked('', get_option('oxi_addons_font_awesome'), true); ?>>No
                                </td>
                                <td>
                                    <label class="description" for="oxi_addons_font_awesome"><?php _e('Load Font Awesome CSS at shortcode loading, If your theme already loaded select No for faster loading'); ?></label>
                                </td>
                            </tr> 
                            
                            <tr valign="top">
                                <td scope="row">Waypoints Support</td>
                                <td>
                                    <input type="radio" name="oxi_addons_way_points" value="" <?php checked('', get_option('oxi_addons_way_points'), true); ?>>YES
                                    <input type="radio" name="oxi_addons_way_points" value="no" <?php checked('no', get_option('oxi_addons_way_points'), true); ?>>No
                                </td>
                                <td>
                                    <label class="description" for="oxi_addons_way_points"><?php _e('Load Way Points at shortcode loading while animated, If your theme already loaded select No for faster loading'); ?></label>
                                </td>
                            </tr> 
                            <tr valign="top">
                                <td scope="row">Google Font Support</td>
                                <td>
                                    <input type="radio" name="oxi_addons_google_font" value="" <?php checked('', get_option('oxi_addons_google_font'), true); ?>>YES
                                    <input type="radio" name="oxi_addons_google_font" value="no" <?php checked('no', get_option('oxi_addons_google_font'), true); ?>>No
                                </td>
                                <td>
                                    <label class="description" for="oxi_addons_google_font"><?php _e('Load Google font from Google  while loading shortcode, If you already load those locally select No for faster loading'); ?></label>
                                </td>
                            </tr> 
                            <tr valign="top">
                                <td scope="row">Custom Parent Class</td>
                                <td>
                                    <input type="text" id="oxi_addons_custom_parent_class" name="oxi_addons_custom_parent_class" value="<?php echo get_option('oxi_addons_custom_parent_class'); ?>" />
                                </td>
                                <td>
                                    <label class="description" for="oxi_addons_custom_parent_class"><?php _e('Add custom panrent Class as Avoid Conflict with Theme or Plugins '); ?></label>
                                </td>
                            </tr> 
                        </tbody>
                    </table>
                    <?php submit_button(); ?>
                </form>
                <br>
                <br>
                <br>
                <br>
                <h2><?php _e('Product License Activation'); ?></h2>
                <p>Activate your copy to get direct plugin updates and official support.</p>
                <form method="post" action="options.php">
                    <?php settings_fields('oxi_image_hover_license'); ?>
                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th scope="row" valign="top">
                                    <?php _e('License Key'); ?>
                                </th>
                                <td>
                                    <input id="image_hover_ultimate_license_key" name="image_hover_ultimate_license_key" type="text" class="regular-text" value="<?php esc_attr_e($this->license); ?>" />
                                    <label class="description" for="image_hover_ultimate_license_key"><?php _e('Enter your license key'); ?></label>
                                </td>
                            </tr>
                            <?php if (!empty($this->license)) { ?>
                                <tr valign="top">
                                    <th scope="row" valign="top">
                                        <?php _e('Activate License'); ?>
                                    </th>
                                    <td>
                                        <?php if ($this->status !== false && $this->status == 'valid') { ?>
                                            <span style="color:green;"><?php _e('active'); ?></span>
                                            <?php wp_nonce_field('oxi_image_hover_nonce', 'oxi_image_hover_nonce'); ?>
                                            <input type="submit" class="button-secondary" name="oxi_image_hover_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
                                            <?php
                                        } else {
                                            wp_nonce_field('oxi_image_hover_nonce', 'oxi_image_hover_nonce');
                                            ?>
                                            <input type="submit" class="button-secondary" name="oxi_image_hover_license_activate" value="<?php _e('Activate License'); ?>"/>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php submit_button(); ?>
                </form>
            </div>
        </div>  
        <?php
    }

}
