<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if (!defined('ABSPATH'))
    exit;

/**
 * Description of Installation
 *
 * @author $biplob018
 */
class Installation {

    protected static $lfe_instance = NULL;

    const ADMINMENU = 'get_oxilab_addons_menu';

    /**
     * Constructor of Shortcode Addons
     *
     * @since 9.3.0
     */
    public function __construct() {
        
    }

    /**
     * Access plugin instance. You can create further instances by calling
     */
    public static function get_instance() {
        if (NULL === self::$lfe_instance)
            self::$lfe_instance = new self;

        return self::$lfe_instance;
    }

    /**
     * Get  Image Hover Menu.
     * @return mixed
     */
    public function Image_Hover_Menu() {
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
    }

    /**
     * Image Hover Menu Deactive.
     * @return mixed
     */
    public function Image_Hover_Menu_Deactive() {
        delete_transient(self::ADMINMENU);
    }

    public function Image_Hover_Database() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'image_hover_ultimate_style';
        $table_list = $wpdb->prefix . 'image_hover_ultimate_list';
        $table_import = $wpdb->prefix . 'oxi_div_import';
        $charset_collate = $wpdb->get_charset_collate();
        $sql1 = "CREATE TABLE $table_name (
		id mediumint(5) NOT NULL AUTO_INCREMENT,
                name varchar(50) NOT NULL,
                style_name varchar(40) NOT NULL,
                rawdata longtext,
                stylesheet longtext,
                font_family text,
		PRIMARY KEY  (id)
	) $charset_collate;";

        $sql2 = "CREATE TABLE $table_list (
		id mediumint(5) NOT NULL AUTO_INCREMENT,
                styleid mediumint(6) NOT NULL,
                rawdata text,
		PRIMARY KEY  (id)
	) $charset_collate;";
        $sql3 = "CREATE TABLE $table_import (
		id mediumint(5) NOT NULL AUTO_INCREMENT,
                type varchar(50) NULL,
                name varchar(100) NULL,
                font varchar(200) NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql1);
        dbDelta($sql2);
        dbDelta($sql3);
        add_option('oxi_image_hover_version', OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

    /**
     * Plugin upgrade hook
     *
     * @since 9.3.0
     */
    public function plugin_upgrade_hook() {
        $this->Image_Hover_Menu();
        $this->Image_Hover_Database();
    }

    /**
     * Plugin activation hook
     *
     * @since 9.3.0
     */
    public function plugin_activation_hook() {
        $this->Image_Hover_Menu();
        $this->Image_Hover_Database();
        // Redirect to options page
        set_transient('oxi_image_hover_activation_redirect', true, 30);
    }

    /**
     * Plugin deactivation hook
     *
     * @since 9.3.0
     */
    public function plugin_deactivation_hook() {
        $this->Image_Hover_Menu_Deactive();
    }

}
