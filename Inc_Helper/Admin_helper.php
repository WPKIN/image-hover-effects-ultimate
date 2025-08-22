<?php

namespace OXI_FLIP_BOX_PLUGINS\Inc_Helper;

trait Admin_helper {


    public function Flip_Import() {
        new \OXI_FLIP_BOX_PLUGINS\Page\Import();
    }

    public function Flip_Addons() {
        new \OXI_FLIP_BOX_PLUGINS\Page\Addons();
    }

	public function Flip_Home() {
        new \OXI_FLIP_BOX_PLUGINS\Page\Home();
    }

    public function Flip_Settings() {
        new \OXI_FLIP_BOX_PLUGINS\Page\Settings();
    }

    public function oxi_flip_box_activation() {
        new \OXI_FLIP_BOX_PLUGINS\Page\Welcome();
    }

    private function handle_direct_action_error( $message ) {
        _default_wp_die_handler( $message, 'Flipbox Error' );
    }

	public function Flip_Create() {
		global $wpdb;

		if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'image_hover_ultimate_url' ) ) {
			wp_die( esc_html__( 'Security check failed.', 'image-hover-effects-ultimate' ) );
		}

		$styleid = ! empty( $_GET['styleid'] ) ? intval( $_GET['styleid'] ) : 0;

		if ( $styleid > 0 ) {

			// Use $wpdb->prepare() safely
			$style = $wpdb->get_row(
				$wpdb->prepare( 'SELECT style_name FROM ' . esc_sql( $this->parent_table ) . ' WHERE id = %d', $styleid ),
				ARRAY_A
			);

			if ( ! empty( $style['style_name'] ) ) {
				$style_name = ucfirst( $style['style_name'] );
				$cls = '\\OXI_FLIP_BOX_PLUGINS\\Inc\\' . $style_name;
				if ( class_exists( $cls ) ) {
					new $cls();
				}
			}
		} else {
			new \OXI_FLIP_BOX_PLUGINS\Page\Create();
		}
	}

    public function verify_request_nonce() {
		// Safely get the request method.
		$request_method = isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '';

		// Get nonce based on the method.
		$nonce = '';
		if ( 'POST' === $request_method ) {
			$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) : '';
		} elseif ( 'GET' === $request_method ) {
			$nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';
		}

		return ! empty( $nonce ) && wp_verify_nonce( $nonce, 'oxi-flip-box-editor' );
	}

    public function Admin_Menu() {
        $user_role = get_option( 'oxi_addons_user_permission' );
        $role_object = get_role( $user_role );
        $first_key = '';
        if ( isset( $role_object->capabilities ) && is_array( $role_object->capabilities ) ) {
            reset( $role_object->capabilities );
            $first_key = key( $role_object->capabilities );
        } else {
            $first_key = 'manage_options';
        }
        add_menu_page( 'Flip Box', 'Flip Box', $first_key, 'oxi-flip-box-ultimate', [ $this, 'Flip_Home' ] );
        add_submenu_page( 'oxi-flip-box-ultimate', 'Flip Box', 'Flip Box', $first_key, 'oxi-flip-box-ultimate', [ $this, 'Flip_Home' ] );
        add_submenu_page( 'oxi-flip-box-ultimate', 'Create New', 'Create New', $first_key, 'oxi-flip-box-ultimate-new', [ $this, 'Flip_Create' ] );
        add_submenu_page( 'oxi-flip-box-ultimate', 'Import Templates', 'Import Templates', $first_key, 'oxi-flip-box-ultimate-import', [ $this, 'Flip_Import' ] );
        add_submenu_page( 'oxi-flip-box-ultimate', 'Oxilab Addons', 'Oxilab Addons', $first_key, 'oxi-flip-box-ultimate-addons', [ $this, 'Flip_Addons' ] );
        add_submenu_page( 'oxi-flip-box-ultimate', 'Settings', 'Settings', $first_key, 'oxi-flip-box-ultimate-settings', [ $this, 'Flip_Settings' ] );
        add_dashboard_page( 'Welcome To Flipbox - Awesomes Flip Boxes Image Overlay', 'Welcome To Flipbox - Awesomes Flip Boxes Image Overlay', 'read', 'oxi-flip-box-activation', [ $this, 'oxi_flip_box_activation' ] );
    }

	public function data_process() {

		// Safely get the request method.
		$request_method = isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '';

		// Check nonce before doing anything else.
		if ( ! $this->verify_request_nonce() ) {
			$this->handle_direct_action_error( 'Access Denied' );
		}

		// Collect data safely.
		// phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.NonceVerification.Recommended
		$method_data = ( 'POST' === $request_method ) ? $_POST : $_GET;

		// Sanitize inputs.
		$functionname = isset( $method_data['functionname'] ) ? sanitize_text_field( wp_unslash( $method_data['functionname'] ) ) : '';
		$rawdata      = isset( $method_data['rawdata'] ) ? sanitize_text_field( wp_unslash( $method_data['rawdata'] ) ) : '';
		$styleid      = isset( $method_data['styleid'] ) ? intval( $method_data['styleid'] ) : 0;
		$childid      = isset( $method_data['childid'] ) ? intval( $method_data['childid'] ) : 0;

		// Process only if required data is present.
		if ( ! empty( $functionname ) && ! empty( $rawdata ) ) {
			new \OXI_FLIP_BOX_PLUGINS\Classes\Admin_Ajax( $functionname, $rawdata, $styleid, $childid );
		}

		wp_die();
	}


    public function redirect_on_activation() {
		if ( get_transient( 'oxi_flip_box_activation_redirect' ) ) :
			delete_transient( 'oxi_flip_box_activation_redirect' );
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) :
				return;
			endif;
			wp_safe_redirect( admin_url( 'admin.php?page=oxi-flip-box-activation' ) );
			exit;
		endif;
	}

    public function welcome_remove_menus() {
        remove_submenu_page( 'index.php', 'oxi-flip-box-activation' );
    }

    public function User_Reviews() {
        $this->admin_recommended();
        $this->admin_notice();
    }

	public function admin_notice() {
        if ( ! empty( $this->admin_notice_status() ) ) :
            return;
        endif;
        if ( strtotime( '-7 day' ) < $this->installation_date() ) :
            return;
        endif;
        new \OXI_FLIP_BOX_PLUGINS\Classes\Support_Reviews();
    }

    /**
     * Admin Install date Check
     *
     * @since 2.0.0
     */
    public function installation_date() {
        $data = get_option( 'oxilab_flip_box_activation_date' );
        if ( empty( $data ) ) :
            $data = strtotime( 'now' );
            update_option( 'oxilab_flip_box_activation_date', $data );
        endif;
        return $data;
    }

	/**
     * Admin Notice Check
     *
     * @since 2.0.0
     */
    public function admin_notice_status() {
        $data = get_option( 'oxilab_flip_box_nobug' );
        return $data;
    }

    public function SupportAndComments( $agr ) {

        if ( get_option( 'oxi_flipbox_support_massage' ) == 'no' ) :
            return;
        endif;
		?>
        <div class="oxi-addons-admin-notifications">
            <h3>
                <span class="dashicons dashicons-flag"></span>
                Trouble or Need Support?
            </h3>
            <p></p>
            <div class="oxi-addons-admin-notifications-holder">
                <div class="oxi-addons-admin-notifications-alert">
                    <p>Unable to create your desire design or need any help? <a href="https://wordpress.org/support/plugin/image-hover-effects-ultimate-visual-composer#new-post">Ask any question</a> and get reply from our expert members. We will be glad to answer any question you may have about our plugin.</p>
                    <?php
                    if ( apply_filters( 'oxi-flip-box-plugin/pro_version', false ) == false ) :
						?>
                        <p>By the way, did you know we also have a <a href="https://wpkindemos.com/flipbox/pricing/">Premium Version</a>? It offers lots of options with automatic update. It also comes with 16/5 personal support.</p>
                        <p>Thanks Again!</p>
						<?php
                    endif;
                    ?>

                    <p></p>
                </div>
            </div>
            <p></p>
        </div>
		<?php
    }

	/**
     * Admin Notice Check
     *
     * @since 2.0.0
     */
    public function admin_recommended_status() {
        $data = get_option( 'oxilab_flip_box_recommended' );
        return $data;
    }

	public function admin_recommended() {
        if ( ! empty( $this->admin_recommended_status() ) ) :
            return;
        endif;
        if ( strtotime( '-1 day' ) < $this->installation_date() ) :
            return;
        endif;
        new \OXI_FLIP_BOX_PLUGINS\Classes\Support_Recommended();
    }


    /**
     * Plugin Admin Top Menu
     *
     * @since 2.0.0
     */
    public function oxilab_admin_menu( $agr ) {
        $response = [
            'Flip Box' => [
                'name' => 'Flip Box',
                'homepage' => 'oxi-flip-box-ultimate',
            ],
            'Create New' => [
                'name' => 'Create New',
                'homepage' => 'oxi-flip-box-ultimate-new',
            ],
            'Import Templates' => [
                'name' => 'Import Templates',
                'homepage' => 'oxi-flip-box-ultimate-import',
            ],
            'Addons' => [
                'name' => 'Addons',
                'homepage' => 'oxi-flip-box-ultimate-addons',
            ],
        ];

        $bgimage = OXI_FLIP_BOX_URL . 'image/sa-logo.png';
        $sub = '';
		?>
        <div class="oxi-addons-wrapper">
            <div class="oxilab-new-admin-menu">
                <div class="oxi-site-logo">
                    <a href="<?php echo esc_url( $this->admin_url_convert( 'oxi-flip-box-ultimate' ) ); ?>" class="header-logo" style=" background-image: url(<?php echo esc_url( $bgimage ); ?>);">
                    </a>
                </div>
                <nav class="oxilab-sa-admin-nav">
                    <ul class="oxilab-sa-admin-menu">
                        <?php

						// phpcs:ignore WordPress.Security.NonceVerification.Recommended
                        $GETPage = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

                        foreach ( $response as $key => $value ) {
							?>
                            <li 
                            <?php
							if ( $GETPage == $value['homepage'] ) :
								echo ' class="active" ';
                                endif;
							?>
                                ><a href="<?php echo esc_url( $this->admin_url_convert( $value['homepage'] ) ); ?>"><?php echo esc_html( $this->name_converter( $value['name'] ) ); ?></a></li>
							<?php
                        }
                        ?>

                    </ul>
                    <ul class="oxilab-sa-admin-menu2">
                        <?php
                        if ( apply_filters( 'oxi-flip-box-plugin/pro_version', false ) == false ) :
							?>
                            <li class="fazil-class"><a target="_blank" href="https://wpkindemos.com/flipbox/pricing/">Upgrade</a></li>
							<?php
                        endif;
                        ?>

                        <li class="saadmin-doc"><a target="_black" href="https://wpkindemos.com/flipbox/docs/installations/how-to-install-the-plugin/">Docs</a></li>
                        <li class="saadmin-doc"><a target="_black" href="https://wordpress.org/support/plugin/image-hover-effects-ultimate-visual-composer/">Support</a></li>
                        <li class="saadmin-set"><a href="<?php echo esc_url( admin_url( 'admin.php?page=oxi-flip-box-ultimate-settings' ) ); ?>"><span class="dashicons dashicons-admin-generic"></span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
		<?php
    }
    /**
     * Plugin fixed
     *
     * @since 3.1.0
     */
    public function fixed_data( $agr ) {
        return hex2bin( $agr );
    }

    /**
     * Plugin fixed debugging data
     *
     * @since 3.1.0
     */
    public function fixed_debug_data( $str ) {
        return bin2hex( $str );
    }

    /**
     * Plugin check Current Tabs
     *
     * @since 2.0.0
     */
    public function check_current_tabs( $agr ) {
        $vs = get_option( $this->fixed_data( '6f78696c61625f666c69705f626f785f6c6963656e73655f737461747573' ) );
        if ( $vs == $this->fixed_data( '76616c6964' ) ) {
            return true;
        } else {
            return false;
        }
    }

    public function admin_url_convert( $agr ) {
        return admin_url( strpos( $agr, 'edit' ) !== false ? $agr : 'admin.php?page=' . $agr );
    }

    public function Admin_Icon() {
		?>
        <style type='text/css' media='screen'>
            #adminmenu #toplevel_page_oxi-flip-box-ultimate div.wp-menu-image:before {
                content: "\f169";
            }
        </style>
		<?php
    }
}
