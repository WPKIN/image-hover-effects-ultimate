<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Helper;

trait Admin_helper {

    /**
     * Plugin fixed
     *
     * @since 9.3.0
     */
    public function fixed_data($agr) {
        return hex2bin($agr);
    }

    /**
     * Plugin fixed debugging data
     *
     * @since 9.3.0
     */
    public function fixed_debug_data($str) {
        return bin2hex($str);
    }

    public function Admin_Icon() {
        ?>
        <style type='text/css' media='screen'>
            #adminmenu #toplevel_page_oxi-image-hover-ultimate  div.wp-menu-image:before {
                content: "\f169";
            }
        </style>
        <?php

    }

    public function Image_Parent() {
        $effects = (!empty($_GET['effects']) ? ucfirst($_GET['effects']) : '');
        $styleid = (!empty($_GET['styleid']) ? (int) $_GET['styleid'] : '');
        if (!empty($effects) && !empty($styleid)):
            $style = $this->wpdb->get_row($this->wpdb->prepare('SELECT style_name FROM ' . $this->parent_table . ' WHERE id = %d ', $styleid), ARRAY_A);
            $name = explode('-', $style['style_name']);
            if ($effects != ucfirst($name[0])):
                $url = admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$name[0]&styleid=$styleid");
                echo $url;
                echo '<script type="text/javascript"> document.location.href="' . $url . '"; </script>';
                exit;
            endif;
            $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $effects . '\Admin\\Effects' . $name[1];
            if (class_exists($cls)):
                new $cls();
            endif;
        elseif (!empty($effects)):
            $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $effects . '\\' . $effects . '';
            if (class_exists($cls)):
                new $cls();
            endif;
        else:
            new \OXI_IMAGE_HOVER_PLUGINS\Page\Admin();
        endif;
    }

    /**
     * Plugin check Current Tabs
     *
     * @since 9.3.0
     */
    public function check_current_version($agr) {
        $vs = get_option($this->fixed_data('696d6167655f686f7665725f756c74696d6174655f6c6963656e73655f737461747573'));
        if ($vs == $this->fixed_data('76616c6964')) {
            return true;
        } else {
            return false;
        }
    }

    public function admin_url_convert($agr) {
        return admin_url(strpos($agr, 'edit') !== false ? $agr : 'admin.php?page=' . $agr);
    }

    public function SupportAndComments($agr) {
        echo '  <div class="oxi-addons-admin-notifications">
                    <h3>
                        <span class="dashicons dashicons-flag"></span> 
                        Notifications
                    </h3>
                    <p></p>
                    <div class="oxi-addons-admin-notifications-holder">
                        <div class="oxi-addons-admin-notifications-alert">
                            <p>Thank you for using my Image Hover Effects Ultimate – Captions Hover with Visual Composer Extension. I Just wanted to see if you have any questions or concerns about my plugins. If you do, Please do not hesitate to <a href="https://wordpress.org/support/plugin/image-hover-effects-ultimate#new-post">file a bug report</a>. </p>
                            ' . (apply_filters('oxi-image-hover-plugin-version', false) ? '' : '<p>By the way, did you know we also have a <a href="https://www.oxilab.org/downloads/image-hover-ultimate-pro/">Premium Version</a>? It offers lots of options with automatic update. It also comes with 16/5 personal support.</p>') . '
                            <p>Thanks Again!</p>
                            <p></p>
                        </div>                     
                    </div>
                    <p></p>
                </div>';
    }

    /**
     * Image Hover Admin menu
     *
     * @since 9.3.0
     */
    public function oxilab_admin_menu($agr) {
        $response = !empty(get_transient(self::ADMINMENU)) ? get_transient(self::ADMINMENU) : [];
        if (!array_key_exists('Image Hover', $response)):
            $response['Image Hover']['Image Hover'] = [
                'name' => 'Image Hover',
                'homepage' => 'oxi-image-hover-ultimate'
            ];
            $response['Image Hover']['Shortcode'] = [
                'name' => 'Shortcode',
                'homepage' => 'oxi-image-hover-shortcode'
            ];
            $response['Image Hover']['Addons'] = [
                'name' => 'Addons',
                'homepage' => 'oxi-image-hover-ultimate-addons'
            ];
            set_transient(self::ADMINMENU, $response, 10 * DAY_IN_SECONDS);
        endif;

        $bgimage = OXI_IMAGE_HOVER_URL . 'image/sm-logo.png';
        $sub = '';

        $menu = '<div class="oxi-addons-wrapper">
                    <div class="oxilab-new-admin-menu">
                        <div class="oxi-site-logo">
                            <a href="' . $this->admin_url_convert('oxi-image-hover-ultimate') . '" class="header-logo" style=" background-image: url(' . $bgimage . ');">
                            </a>
                        </div>
                        <nav class="oxilab-sa-admin-nav">
                            <ul class="oxilab-sa-admin-menu">';
        $GETPage = sanitize_text_field($_GET['page']);
        $effects = (!empty($_GET['effects']) ? $_GET['effects'] : '');
        if (count($response) == 1):
            if ($effects != ''):
                $menu .= '<li class="active" >
                            <a href="' . $this->admin_url_convert('oxi-image-hover-ultimate') . '&effects=' . $effects . '">';
                if ($effects == 'display'):
                    $menu .= 'Display Post';
                else:
                    $menu .= $this->name_converter($effects) . ' Effects';
                endif;
                $menu . '   </a>
                        </li>';

            endif;
            foreach ($response['Image Hover'] as $key => $value) {
                $active = (($GETPage == $value['homepage'] && $effects == '') ? ' class="active" ' : '');
                $menu .= '<li ' . $active . '><a href="' . $this->admin_url_convert($value['homepage']) . '">' . $this->name_converter($value['name']) . '</a></li>';
            }
        else:
            foreach ($response as $key => $value) {
                $active = ($key == 'Image Hover' ? 'active' : '');
                $menu .= '<li class="' . $active . '"><a class="oxi-nev-drop-menu" href="#">' . $this->name_converter($key) . '</a>';
                $menu .= '   <div class="oxi-nev-d-menu">
                                    <div class="oxi-nev-drop-menu-li">';
                foreach ($value as $key2 => $submenu) {
                    $menu .= '<a href="' . $this->admin_url_convert($submenu['homepage']) . '">' . $this->name_converter($submenu['name']) . '</a>';
                }
                $menu .= '</div>';
                $menu .= '</li>';
            }
            if ($GETPage == 'oxi-image-hover-ultimate' || $GETPage == 'oxi-image-hover-shortcode' || $GETPage == 'oxi-image-hover-ultimate-addons'):
                $sub .= '<div class="shortcode-addons-main-tab-header">';
                if ($effects != ''):
                    $sub .= '<a href="' . $this->admin_url_convert('oxi-image-hover-ultimate') . '&effects=' . $effects . '">
                                <div class="shortcode-addons-header oxi-active">';
                    if ($effects == 'display'):
                        $sub .= 'Display Post';
                    else:
                        $sub .= $this->name_converter($effects) . ' Effects';
                    endif;
                    $sub .= '       </div>
                              </a>';
                endif;
                foreach ($response['Image Hover'] as $key => $value) {
                    $active = (($GETPage == $value['homepage'] && $effects == '') ? 'oxi-active' : '');
                    $sub .= '<a href="' . $this->admin_url_convert($value['homepage']) . '">
                                <div class="shortcode-addons-header ' . $active . '">' . $this->name_converter($value['name']) . '</div>
                              </a>';
                }
                $sub .= '</div>';
            endif;
        endif;
        $menu .= '              </ul>
                            <ul class="oxilab-sa-admin-menu2">
                               ' . (apply_filters('oxi-image-hover-plugin-version', false) == FALSE ? ' <li class="fazil-class" ><a target="_blank" href="https://www.oxilab.org/downloads/image-hover-ultimate-pro/">Upgrade</a></li>' : '') . '
                               <li class="saadmin-doc"><a target="_black" href="https://www.image-hover.oxilab.org/docs/">Docs</a></li>
                               <li class="saadmin-doc"><a target="_black" href="https://wordpress.org/support/plugin/image-hover-effects-ultimate/">Support</a></li>
                               <li class="saadmin-set"><a href="' . admin_url('admin.php?page=oxi-image-hover-ultimate-settings') . '"><span class="dashicons dashicons-admin-generic"></span></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                ' . $sub;
        echo __($menu, OXI_IMAGE_HOVER_TEXTDOMAIN);
    }

    public function Admin_Menu() {
        $user_role = get_option('oxi_addons_user_permission');
        $role_object = get_role($user_role);
        $first_key = '';
        if (isset($role_object->capabilities) && is_array($role_object->capabilities)) {
            reset($role_object->capabilities);
            $first_key = key($role_object->capabilities);
        } else {
            $first_key = 'manage_options';
        }
        add_menu_page('Image Hover', 'Image Hover', $first_key, 'oxi-image-hover-ultimate', [$this, 'Image_Parent']);
        add_submenu_page('oxi-image-hover-ultimate', 'Image Hover', 'Image Hover', $first_key, 'oxi-image-hover-ultimate', [$this, 'Image_Parent']);
        add_submenu_page('oxi-image-hover-ultimate', 'Shortcode', 'Shortcode', $first_key, 'oxi-image-hover-shortcode', [$this, 'Image_Shortcode']);
        add_submenu_page('oxi-image-hover-ultimate', 'Oxilab Addons', 'Oxilab Addons', $first_key, 'oxi-image-hover-ultimate-addons', [$this, 'Image_Addons']);
        add_submenu_page('oxi-image-hover-ultimate', 'Settings', 'Settings', $first_key, 'oxi-image-hover-ultimate-settings', [$this, 'Image_Settings']);
        add_submenu_page('oxi-image-hover-ultimate', 'Support', 'Support', $first_key, 'image-hover-ultimate-support', [$this, 'oxi_image_hover_support']);
    }

    public function custom_redirect() {
        
    }

    public function Image_Shortcode() {
        new \OXI_IMAGE_HOVER_PLUGINS\Page\Shortcode();
    }

    public function Image_Addons() {
        new \OXI_IMAGE_HOVER_PLUGINS\Page\Addons();
    }

    public function Image_Settings() {
        new \OXI_IMAGE_HOVER_PLUGINS\Page\Settings();
    }

    public function oxi_image_hover_support() {
        new \OXI_IMAGE_HOVER_PLUGINS\Page\Welcome();
    }

    /**
     * Admin Notice Check
     *
     * @since 9.3.0
     */
    public function admin_notice_status() {
        $data = get_option('oxi_image_hover_nobug');
        return $data;
    }

    /**
     * Admin Install date Check
     *
     * @since 9.3.0
     */
    public function installation_date() {
        $data = get_option('oxi_image_hover_activation_date');
        if (empty($data)):
            $data = strtotime("now");
            update_option('oxi_image_hover_activation_date', $data);
        endif;
        return $data;
    }

    public function User_Reviews() {
        $this->admin_recommended();
        $this->admin_notice();
    }

    /**
     * Admin Notice Check
     *
     * @since 9.3.0
     */
    public function admin_recommended_status() {
        $data = get_option('oxi_image_hover_recommended');
        return $data;
    }

    public function admin_recommended() {
        if (!empty($this->admin_recommended_status())):
            return;
        endif;
        if (strtotime('-1 days') < $this->installation_date()):
            return;
        endif;
        new \OXI_IMAGE_HOVER_PLUGINS\Classes\Support_Recommended();
    }

    public function admin_notice() {
        if (!empty($this->admin_notice_status())):
            return;
        endif;
        if (strtotime('-7 days') < $this->installation_date()):
            return;
        endif;
        new \OXI_IMAGE_HOVER_PLUGINS\Classes\Support_Reviews();
    }

    public function redirect_on_activation() {
        if (get_transient('oxi_image_hover_activation_redirect')):
            delete_transient('oxi_image_hover_activation_redirect');
            if (is_network_admin() || isset($_GET['activate-multi'])):
                return;
            endif;
            wp_safe_redirect(admin_url("admin.php?page=image-hover-ultimate-support"));
        endif;
    }

}
