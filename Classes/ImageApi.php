<?php
namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

use WP_REST_Request;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Description of Image Hover Rest API
 *
 * @author $biplob018
 */
class ImageApi {


    const API = 'https://wpkindemos.com/imagehover/wp-json/imagehoverultimate/v2/';

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
    public $request;
    public $rawdata;
    public $styleid;
    // instance container
    public $childid;

	public $allowed_tags = [
		'a' => [
			'class' => [],
			'href' => [],
			'rel' => [],
			'title' => [],
			'data-src' => [],
			'data-sub-html' => [],
		],
		'abbr' => [
			'title' => [],
		],
		'b' => [],
		'br' => [],
		'blockquote' => [
			'cite' => [],
		],
		'cite' => [
			'title' => [],
		],
		'code' => [],
		'del' => [
			'datetime' => [],
			'title' => [],
		],
		'dd' => [],
		'div' => [
			'class' => [],
			'title' => [],
			'style' => [],
			'id' => [],
		],
		'table' => [
			'class' => [],
			'id' => [],
			'style' => [],
		],
		'button' => [
			'class' => [],
			'type' => [],
			'value' => [],
		],
		'thead' => [],
		'tbody' => [],
		'tr' => [],
		'td' => [],
		'dt' => [],
		'em' => [],
		'h1' => [],
		'h2' => [],
		'h3' => [
			'class' => [],
		],
		'h4' => [],
		'h5' => [],
		'h6' => [],
		'i' => [
			'class' => [],
		],
		'img' => [
			'alt' => [],
			'class' => [],
			'height' => [],
			'src' => [],
			'width' => [],
		],
		'li' => [
			'class' => [],
		],
		'ol' => [
			'class' => [],
		],
		'p' => [
			'class' => [],
		],
		'q' => [
			'cite' => [],
			'title' => [],
		],
		'span' => [
			'class' => [],
			'title' => [],
			'style' => [],
		],
		'strike' => [],
		'strong' => [],
		'ul' => [
			'class' => [],
		],
	];

	/**
     * Constructor of plugin class
     *
     * @since 9.3.0
     */
    public function __construct( $rawdata = '', $styleid = '', $childid = '' ) {
        global $wpdb;
        $wpdb = $wpdb;
        $this->parent_table = $wpdb->prefix . 'image_hover_ultimate_style';
        $this->child_table = $wpdb->prefix . 'image_hover_ultimate_list';
        $this->import_table = $wpdb->prefix . 'oxi_div_import';
        $this->rawdata = $rawdata;
        $this->styleid = $styleid;
        $this->childid = $childid;
        $this->build_api();
    }

    public function get_permissions_check() {
        $transient = get_transient( 'oxi_image_user_permission_role' );
        if ( false === $transient ) {
            $user_role = get_option( 'oxi_image_user_permission' );
            $role_object = get_role( $user_role );
            $first_key = '';
            if ( isset( $role_object->capabilities ) && is_array( $role_object->capabilities ) ) {
                reset( $role_object->capabilities );
                $first_key = key( $role_object->capabilities );
            } else {
                $first_key = 'manage_options';
            }
            $transient = 'oxi_image_user_permission_role';
            set_transient( $transient, $first_key, 1 * HOUR_IN_SECONDS );
            return current_user_can( $first_key );
        }
        return current_user_can( $transient );
    }

	public function update_image_hover_plugin() {

		global $wpdb;

		// Prepared query without user input still needs placeholders for compliance
		$stylelist = $wpdb->get_results(
			'SELECT * FROM ' . esc_sql( $this->parent_table ) . ' ORDER BY id ASC',
			ARRAY_A
		);

		foreach ( $stylelist as $value ) {
			$raw = json_decode( stripslashes( $value['rawdata'] ), true );
			$raw['image-hover-style-id'] = (int) $value['id'];

			$s = explode( '-', $value['style_name'] );
			$CLASS = 'OXI_IMAGE_HOVER_PLUGINS\\Modules\\' . ucfirst( $s[0] ) . '\\Admin\\Effects' . $s[1];

			if ( class_exists( $CLASS ) ) {
				$C = new $CLASS( 'admin' );
				$C->template_css_render( $raw );
			}
		}

		update_option( 'image_hover_ultimate_update_complete', 'done' );
	}

    /**
     * Template Style Data
     *
     * @since 9.3.0
     */
    public function post_template_change() {
		global $wpdb;

		$rawdata = $this->validate_post();

		if ( (int) $this->styleid ) {
			$wpdb->query(
				$wpdb->prepare(
					'UPDATE ' . esc_sql( $this->parent_table ) . ' SET style_name = %s WHERE id = %d',
					$rawdata,
					$this->styleid
				)
			);
		}

		return 'success';
	}

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_template_name() {
		global $wpdb;

		$settings = $this->validate_post();
		$name     = $settings['addonsstylename'];
		$id       = (int) $settings['addonsstylenameid'];

		if ( $id ) {
			$wpdb->query(
				$wpdb->prepare(
					'UPDATE ' . esc_sql( $this->parent_table ) . ' SET name = %s WHERE id = %d',
					$name,
					$id
				)
			);

			return 'success';
		}
	}

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
	public function post_elements_rearrange_modal_data() {
		global $wpdb;

		$styleid = (int) $this->styleid;

		if ( $styleid ) {
			$child = $wpdb->get_results(
				$wpdb->prepare(
					'SELECT * FROM ' . esc_sql( $this->child_table ) . ' WHERE styleid = %d ORDER BY id ASC',
					$styleid
				),
				ARRAY_A
			);

			$render = [];
			foreach ( $child as $value ) {
				$data                  = json_decode( stripslashes( $value['rawdata'] ) );
				$render[ $value['id'] ] = $data;
			}

			return wp_json_encode( $render );
		}
	}

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_elements_template_rearrange_save_data() {
		global $wpdb;

		$params = explode( ',', $this->validate_post() );

		foreach ( $params as $value ) {
			$value = (int) $value;

			if ( $value ) {
				// Get the child row.
				$data = $wpdb->get_row(
					$wpdb->prepare(
						'SELECT * FROM ' . esc_sql( $this->child_table ) . ' WHERE id = %d',
						$value
					),
					ARRAY_A
				);

				if ( $data ) {
					// Insert the new reordered row.
					$wpdb->query(
						$wpdb->prepare(
							'INSERT INTO ' . esc_sql( $this->child_table ) . ' (styleid, rawdata) VALUES (%d, %s)',
							$data['styleid'],
							$data['rawdata']
						)
					);

					$redirect_id = $wpdb->insert_id;

					if ( 0 === (int) $redirect_id ) {
						return;
					}

					// Delete the old row if insert succeeded.
					if ( $redirect_id > 0 ) {
						$wpdb->query(
							$wpdb->prepare(
								'DELETE FROM ' . esc_sql( $this->child_table ) . ' WHERE id = %d',
								$value
							)
						);
					}
				}
			}
		}

		return 'success';
	}

    public function save_action() {

        if ( ! $this->get_permissions_check() ) {
            return new WP_REST_Request( 'Invalid URL', 422 );
            die();
        }

        if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'image_hover_ultimate' ) ) {
			return new \WP_Error(
				'invalid_nonce',
				esc_html__( 'Invalid request.', 'image-hover-effects-ultimate' ),
				[ 'status' => 422 ]
			);
		}

        $functionname = isset( $_REQUEST['functionname'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['functionname'] ) ) : '';
		$this->rawdata = isset( $_REQUEST['rawdata'] ) ? sanitize_textarea_field( wp_unslash( $_REQUEST['rawdata'] ) ) : '';
		$this->styleid = isset( $_REQUEST['styleid'] ) ? (int) $_REQUEST['styleid'] : 0;
		$this->childid = isset( $_REQUEST['childid'] ) ? (int) $_REQUEST['childid'] : 0;

		$action_class = 'post_' . sanitize_key( $functionname );

		if ( method_exists( $this, $action_class ) ) {
			// Escape output safely and echo
			$output = $this->{$action_class}();

			$json = json_decode( $output, true ); // decode as associative array

			if ( null !== $json ) {
				// Sanitize each value recursively
				$sanitize_json = function ( $data ) use ( &$sanitize_json ) {
					if ( is_array( $data ) ) {
						foreach ( $data as $key => $value ) {
							$data[ $key ] = $sanitize_json( $value );
						}
						return $data;
					} elseif ( is_string( $data ) ) {
						return wp_kses_post( $data ); // sanitize strings, allow safe HTML
					}
					return $data; // leave numbers, booleans, null as-is
				};

				$safe_json = $sanitize_json( $json );

				// Output safe JSON
				echo wp_json_encode( $safe_json );
			} elseif ( filter_var( $output, FILTER_VALIDATE_URL ) ) {
				// Output a URL safely
				echo esc_url_raw( trim( $output ) );
			} else {
				echo wp_kses( $output, $this->allowed_tags );
			}
		}

		wp_die(); // proper AJAX termination
    }

    public function array_replace( $arr = [], $search = '', $replace = '' ) {
        array_walk(
            $arr, function ( &$v ) use ( $search, $replace ) {
				$v = str_replace( $search, $replace, $v );
			}
        );
        return $arr;
    }

    public function post_create_new() {

		global $wpdb;

        $params = $this->validate_post();

        $files = OXI_IMAGE_HOVER_PATH . $params['style'];

        if ( is_file( $files ) ) {
            $rawdata = file_get_contents( $files );
            $params = json_decode( $rawdata, true );
            $style = $params['style'];
            $child = $params['child'];
            if ( ! empty( $params['name'] ) ) :
                $style['name'] = $params['name'];
            endif;

            $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->parent_table ) . ' (name, style_name, rawdata) VALUES ( %s, %s, %s)', [ $style['name'], $style['style_name'], $style['rawdata'] ] ) );
            $redirect_id = $wpdb->insert_id;
            if ( $redirect_id > 0 ) :
                $raw = json_decode( stripslashes( $style['rawdata'] ), true );
                $raw['image-hover-style-id'] = $redirect_id;
                $s = explode( '-', $style['style_name'] );
                $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst( $s[0] ) . '\Admin\Effects' . $s[1];
                $C = new $CLASS( 'admin' );
                $f = $C->template_css_render( $raw );
                foreach ( $child as $value ) {
                    $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->child_table ) . ' (styleid, rawdata) VALUES (%d,  %s)', [ $redirect_id, $value['rawdata'] ] ) );
                }

				$nonce_url = wp_nonce_url(
					admin_url( "admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id" ),
					'image_hover_ultimate_url',
					'_wpnonce'
				);

				return html_entity_decode( $nonce_url );
            endif;
        }
        return;
    }

    public function validate_post( $data = '' ) {
        $rawdata = [];
        if ( ! empty( $data ) ) :
            $arrfiles = json_decode( stripslashes( $data ), true );
        else :
            $arrfiles = json_decode( stripslashes( $this->rawdata ), true );
        endif;
        if ( is_array( $arrfiles ) ) :
            $rawdata = array_map( [ $this, 'allowed_html' ], $arrfiles );
        elseif ( empty( $data ) ) :
            $rawdata = $this->allowed_html( $this->rawdata );
        else :
            $rawdata = $this->allowed_html( $data );
        endif;
        return $rawdata;
    }

    public function allowed_html( $rawdata ) {
        if ( is_array( $rawdata ) ) :
            return $rawdata = array_map( [ $this, 'allowed_html' ], $rawdata );
        else :
            return wp_kses( $rawdata, $this->allowed_tags );
        endif;
    }

    public function post_layouts_clone() {

		global $wpdb;

        $newName = $this->validate_post();

        $styleid = $this->styleid;

        $style = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . esc_sql( $this->parent_table ) . ' WHERE id = %d', $styleid ), ARRAY_A );
        $child = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . esc_sql( $this->child_table ) . ' WHERE styleid = %d ORDER by id ASC', $styleid ), ARRAY_A );

        $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->parent_table ) . ' (name, style_name, rawdata) VALUES ( %s, %s, %s)', [ $newName, $style['style_name'], $style['rawdata'] ] ) );
        $redirect_id = $wpdb->insert_id;
        if ( $redirect_id > 0 ) :
            $raw = json_decode( stripslashes( $style['rawdata'] ), true );
            $raw['image-hover-style-id'] = $redirect_id;
            $s = explode( '-', $style['style_name'] );
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst( $s[0] ) . '\Admin\Effects' . $s[1];
            $C = new $CLASS( 'admin' );
            $f = $C->template_css_render( $raw );
            foreach ( $child as $value ) {
                $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->child_table ) . ' (styleid, rawdata) VALUES (%d,  %s)', [ $redirect_id, $value['rawdata'] ] ) );
            }
			$nonce_url = wp_nonce_url(
                admin_url( "admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id" ),
                'image_hover_ultimate_url',
                '_wpnonce'
			);

			return html_entity_decode( $nonce_url );
        endif;
    }

    public function post_json_import( $params ) {

		global $wpdb;

        $style = $params['style'];
        $child = $params['child'];
        $raw = json_decode( stripslashes( $style['rawdata'] ), true );
        $custom = strtolower( $raw['image-hover-custom-css'] );
        if ( preg_match( '/style/i', $custom ) || preg_match( '/script/i', $custom ) ) {
            return 'Don\'t be smart, Kindly add validate data.';
        }

        $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->parent_table ) . ' (name, style_name, rawdata) VALUES ( %s, %s, %s)', [ $style['name'], $style['style_name'], $style['rawdata'] ] ) );
        $redirect_id = $wpdb->insert_id;
        if ( $redirect_id > 0 ) :
            $raw['image-hover-style-id'] = $redirect_id;
            $s = explode( '-', $style['style_name'] );
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst( $s[0] ) . '\Admin\Effects' . $s[1];
            $C = new $CLASS( 'admin' );
            $f = $C->template_css_render( $raw );
            foreach ( $child as $value ) {
                $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->child_table ) . ' (styleid, rawdata) VALUES (%d,  %s)', [ $redirect_id, $value['rawdata'] ] ) );
            }
			$nonce_url = wp_nonce_url(
				admin_url( "admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id" ),
				'image_hover_ultimate_url',
				'_wpnonce'
			);

			return html_entity_decode( $nonce_url );
        endif;
    }

    public function post_shortcode_delete() {
		global $wpdb;
        $styleid = (int) $this->styleid;
        if ( $styleid ) :
            $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . esc_sql( $this->parent_table ) . ' WHERE id = %d', $styleid ) );
            $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . esc_sql( $this->child_table ) . ' WHERE styleid = %d', $styleid ) );
            return 'done';
        else :
            return 'Silence is Golden';
        endif;
    }
    /**
     * Template Modal Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data() {

		global $wpdb;

        if ( (int) $this->styleid ) :
            if ( (int) $this->childid ) :
                $wpdb->query( $wpdb->prepare( 'UPDATE ' . esc_sql( $this->child_table ) . ' SET rawdata = %s WHERE id = %d', $this->rawdata, $this->childid ) );
            else :
                $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->child_table ) . ' (styleid, rawdata) VALUES (%d, %s )', [ $this->styleid, $this->rawdata ] ) );
            endif;
        endif;
        return 'success';
    }

    /**
     * Template Rebuild Render
     *
     * @since 9.3.0
     */
    public function post_elements_template_rebuild_data() {
		global $wpdb;

		$style = $wpdb->get_row(
			$wpdb->prepare(
				'SELECT * FROM ' . esc_sql( $this->parent_table ) . ' WHERE id = %d',
				$this->styleid
			),
			ARRAY_A
		);

		$child = $wpdb->get_results(
			$wpdb->prepare(
				'SELECT * FROM ' . esc_sql( $this->child_table ) . ' WHERE styleid = %d ORDER BY id ASC',
				$this->styleid
			),
			ARRAY_A
		);
        $style['rawdata'] = $style['stylesheet'] = $style['font_family'] = '';
        $name = explode( '-', $style['style_name'] );
        $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst( $name[0] ) . '\Render\Effects' . $name[1];
        $CLASS = new $cls();
        $CLASS->__construct( $style, $child, 'admin' );
        return 'success';
    }



    /**
     * Template Child Delete Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_delete() {
		global $wpdb;
        if ( (int) $this->childid ) :
            $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . esc_sql( $this->child_table ) . ' WHERE id = %d ', $this->childid ) );
            return 'done';
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Admin Notice API  loader
     * @return void
     */
    public function post_oxi_recommended() {
        $data = 'done';
        update_option( 'oxi_image_hover_recommended', $data );
        return $data;
    }

    /**
     * Admin Notice Recommended  loader
     * @return void
     */
    public function post_notice_dissmiss() {
        $notice = $this->request['notice'];
        if ( $notice == 'maybe' ) :
            $data = strtotime( 'now' );
            update_option( 'oxi_image_hover_activation_date', $data );
        else :
            update_option( 'oxi_image_hover_nobug', $notice );
        endif;
        return $notice;
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_image_user_permission() {
        $rawdata = $this->validate_post();
        update_option( 'oxi_image_user_permission', $rawdata['value'] );
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_image_hover_ultimate_mobile_device_key() {
        $rawdata = $this->validate_post();
        update_option( 'image_hover_ultimate_mobile_device_key', $rawdata['value'] );
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_addons_font_awesome() {
        $rawdata = $this->validate_post();
        update_option( 'oxi_addons_font_awesome', $rawdata['value'] );
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_addons_way_points() {
        $rawdata = $this->validate_post();
        update_option( 'oxi_addons_way_points', $rawdata['value'] );
        return '<span class="oxi-confirmation-success"></span>';
    }
    /**
     * Template Template Render
     *
     * @since 9.3.0
     */
    public function post_elements_template_render_data() {
		global $wpdb;
        $settings = json_decode( stripslashes( $this->rawdata ), true );
        $child = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . esc_sql( $this->child_table ) . ' WHERE styleid = %d ORDER by id ASC', $this->styleid ), ARRAY_A );
        $StyleName = $settings['image-hover-template'];
        $name = explode( '-', $StyleName );
        ob_start();
        $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $name[0] . '\Render\Effects' . $name[1];
        $CLASS = new $cls();
        $styledata = [
			'rawdata' => $this->rawdata,
			'id' => $this->styleid,
			'style_name' => $StyleName,
			'stylesheet' => '',
		];
        $CLASS->__construct( $styledata, $child, 'admin' );
        return ob_get_clean();
    }

    /**
     * Template Modal Data Edit Form
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_edit() {
		global $wpdb;
        if ( (int) $this->childid ) :
            $listdata = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . esc_sql( $this->child_table ) . ' WHERE id = %d ', $this->childid ), ARRAY_A );
            $returnfile = json_decode( stripslashes( $listdata['rawdata'] ), true );
            $returnfile['shortcodeitemid'] = $this->childid;
            return json_encode( $returnfile );
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Template Modal Data Edit Form
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_clone() {
		global $wpdb;
        if ( (int) $this->childid ) :
            $listdata = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . esc_sql( $this->child_table ) . ' WHERE id = %d ', $this->childid ), ARRAY_A );
            $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->child_table ) . ' (styleid, rawdata) VALUES (%d,  %s)', [ $listdata['styleid'], $listdata['rawdata'] ] ) );
            $redirect_id = $wpdb->insert_id;
            if ( $redirect_id > 0 ) :
                return 'done';
            endif;
            return 'Silence is Golden';
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_addons_google_font() {
        $rawdata = $this->validate_post();
        update_option( 'oxi_addons_google_font', $rawdata['value'] );
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_addons_custom_parent_class() {
        $rawdata = $this->validate_post();
        update_option( 'oxi_addons_custom_parent_class', $rawdata['value'] );
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_image_support_massage() {
        $rawdata = $this->validate_post();
        update_option( 'oxi_image_support_massage', $rawdata['value'] );
        return '<span class="oxi-confirmation-success"></span>';
    }

    public function post_web_template() {

        global $wp_filesystem;

		// Load the WP Filesystem API if it isn't loaded yet
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		WP_Filesystem();

		$folder = $this->safe_path( OXI_IMAGE_HOVER_PATH . 'template/' );

		if ( ! $wp_filesystem->is_dir( $folder ) ) {
			$wp_filesystem->mkdir( $folder, FS_CHMOD_DIR );
		}
        $rawdata = $this->validate_post();
        $files = OXI_IMAGE_HOVER_PATH . 'template/' . $rawdata . '-' . $this->styleid . '.json';
        if ( ! file_exists( $files ) ) :
            $this->download_web_files( $files );
        endif;
        $template_data = json_decode( file_get_contents( $files ), true );

        $render = '';
        $vs = get_option( $this->fixed_data( '696d6167655f686f7665725f756c74696d6174655f6c6963656e73655f737461747573' ) );
        foreach ( $template_data as $key => $value ) {
            if ( $vs == $this->fixed_data( '76616c6964' ) ) {
                $button = '<button type="button" class="btn btn-success oxi-addons-addons-web-template-import-button" web-data="' . $value['style']['style_name'] . '" web-template="' . $value['style']['id'] . '">Import</button>';
            } else {
                $button = '<button class="btn btn-warning oxi-addons-addons-style-btn-warning" title="Pro Only" type="submit" value="pro only" name="addonsstyleproonly">Pro Only</button>';
            }
            $render .= '<div class="oxi-addons-col-1">
                                    <div class="oxi-addons-style-preview">
                                        <div class="oxi-addons-style-preview-top oxi-addons-center">';
            $C = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst( $rawdata ) . '\Render\Effects' . $this->styleid;

            ob_start();
            if ( class_exists( $C ) ) :
                new $C( $value['style'], $value['child'], 'web' );
            endif;
            $render .= ob_get_contents();
            ob_end_clean();

            $render .= '                </div>
                                        <div class="oxi-addons-style-preview-bottom">
                                            <div class="oxi-addons-style-preview-bottom-left">
                                                ' . $value['style']['name'] . '
                                            </div>
                                            <div class="oxi-addons-style-preview-bottom-right">
                                                ' . $button . '
                                            </div>
                                        </div>
                                    </div>
                                </div>';
        }
        return $render;
    }

    /**
     * Generate safe path
     * @since v1.0.0
     */
    public function safe_path( $path ) {

        $path = str_replace( [ '//', '\\\\' ], [ '/', '\\' ], $path );
        return str_replace( [ '/', '\\' ], DIRECTORY_SEPARATOR, $path );
    }
    public function post_shortcode_export() {
		global $wpdb;
        $styleid = (int) $this->styleid;
        if ( $styleid > 0 ) :
            $style = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . esc_sql( $this->parent_table ) . ' WHERE id = %d', $styleid ), ARRAY_A );
            $child = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . esc_sql( $this->child_table ) . ' WHERE styleid = %d ORDER by id ASC', $styleid ), ARRAY_A );
            $filename = 'image-hover-effects-ultimateand' . $style['id'] . '.json';
            $files = [
                'style' => $style,
                'child' => $child,
            ];
            $finalfiles = json_encode( $files );
            $this->send_file_headers( $filename, strlen( $finalfiles ) );
            @ob_end_clean();
            flush();
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON output for file export, not HTML.
            echo $finalfiles;
            die;
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Send file headers.
     *
     *
     * @param string $file_name File name.
     * @param int $file_size File size.
     */
    private function send_file_headers( $file_name, $file_size ) {
        header( 'Content-Type: application/octet-stream' );
        header( 'Content-Disposition: attachment; filename=' . $file_name );
        header( 'Expires: 0' );
        header( 'Cache-Control: must-revalidate' );
        header( 'Pragma: public' );
        header( 'Content-Length: ' . $file_size );
    }

    public function post_shortcode_deactive() {
		global $wpdb;
        $rawdata = $this->validate_post();

        $id = $rawdata . '-' . (int) $this->styleid;
        $effects = $rawdata . '-ultimate';
        if ( $this->styleid > 0 ) :
            $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . esc_sql( $this->import_table ) . ' WHERE name = %s and type = %s', $id, $effects ) );
            return 'done';
        else :
            return 'Silence is Golden';
        endif;
    }

    public function post_shortcode_active() {
		global $wpdb;
        $rawdata = $this->validate_post();
        $id = $rawdata . '-' . (int) $this->styleid;
        $effects = $rawdata . '-ultimate';

        if ( $this->styleid > 0 ) :
            $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->import_table ) . ' (type, name) VALUES (%s, %s)', [ $effects, $id ] ) );
			$nonce_url = wp_nonce_url(
				admin_url( "admin.php?page=oxi-image-hover-ultimate&effects=$rawdata#" . $id ),
				'image_hover_ultimate_url',
				'_wpnonce'
			);

			return html_entity_decode( $nonce_url );
        else :
            return 'Silence is Golden';
        endif;
    }

    /**
     * Template Style Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_style() {
		global $wpdb;
        $settings = json_decode( stripslashes( $this->rawdata ), true );

        $custom = strtolower( $settings['image-hover-custom-css'] );
        if ( preg_match( '/style/i', $custom ) || preg_match( '/script/i', $custom ) ) {
            return 'Don\'t be smart, Kindly add validated data.';
        }

        $StyleName = sanitize_text_field( $settings['image-hover-template'] );
        $stylesheet = '';
        if ( (int) $this->styleid ) :
            $wpdb->query( $wpdb->prepare( 'UPDATE ' . esc_sql( $this->parent_table ) . ' SET rawdata = %s, stylesheet = %s WHERE id = %d', $this->rawdata, $stylesheet, $this->styleid ) );
            $name = explode( '-', $StyleName );
            $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $name[0] . '\Admin\Effects' . $name[1];
            $CLASS = new $cls( 'admin' );
            return $CLASS->template_css_render( $settings );
        endif;
    }

    public function download_web_files( $files ) {

        $rawdata = $this->validate_post();
        $URL = self::API . $rawdata . '/' . $this->styleid;
        $request = wp_remote_request( $URL );
        if ( ! is_wp_error( $request ) ) {
            $response = json_decode( wp_remote_retrieve_body( $request ), true );
        } else {
            return $request->get_error_message();
        }

        $data = json_decode( $response, true );
        if ( file_put_contents( $files, json_encode( $data ) ) ) {
        }
    }

    public function fixed_data( $agr ) {
        return hex2bin( $agr );
    }

    public function post_web_import() {
		global $wpdb;
        $rawdata = $this->validate_post();
        $files = OXI_IMAGE_HOVER_PATH . 'template/' . $rawdata . '.json';
        $params = json_decode( file_get_contents( $files ), true )[ $this->styleid ];

        $style = $params['style'];
        $child = $params['child'];
        $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->parent_table ) . ' (name, style_name, rawdata) VALUES ( %s, %s, %s)', [ $style['name'], $style['style_name'], $style['rawdata'] ] ) );
        $redirect_id = $wpdb->insert_id;
        if ( $redirect_id > 0 ) :
            $raw = json_decode( stripslashes( $style['rawdata'] ), true );
            $raw['image-hover-style-id'] = $redirect_id;
            $s = explode( '-', $style['style_name'] );
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst( $s[0] ) . '\Admin\Effects' . $s[1];
            $C = new $CLASS( 'admin' );
            $f = $C->template_css_render( $raw );
            foreach ( $child as $value ) {
                $wpdb->query( $wpdb->prepare( 'INSERT INTO ' . esc_sql( $this->child_table ) . ' (styleid, rawdata) VALUES (%d,  %s)', [ $redirect_id, $value['rawdata'] ] ) );
            }
			$nonce_url = wp_nonce_url(
				admin_url( "admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id" ),
				'image_hover_ultimate_url',
				'_wpnonce'
			);
			return html_entity_decode( $nonce_url );
        endif;
    }

    public function ajax_action() {

        $wpnonce = isset( $_POST['_wpnonce'] ) ? sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ) : '';

		if ( ! wp_verify_nonce( $wpnonce, 'image_hover_ultimate' ) ) {
			return new \WP_Error(
				'invalid_nonce',
				esc_html__( 'Invalid request.', 'image-hover-effects-ultimate' ),
				[ 'status' => 422 ]
			);
		}

        $classname = isset( $_POST['class'] ) ? '\\' . str_replace( '\\\\', '\\', sanitize_text_field( wp_unslash( $_POST['class'] ) ) ) : '';

        if ( strpos( $classname, 'OXI_IMAGE_HOVER_PLUGINS' ) === false ) :
            return new WP_REST_Request( 'Invalid URL', 422 );
        endif;
        $functionname = isset( $_POST['functionname'] ) ? sanitize_text_field( wp_unslash( $_POST['functionname'] ) ) : '';

        if ( $functionname != '__rest_api_post' ) :
            return new WP_REST_Request( 'Invalid URL', 422 );
        endif;

		$rawdata  = isset( $_POST['rawdata'] ) ? sanitize_text_field( wp_unslash( $_POST['rawdata'] ) ) : '';
        $args     = isset( $_POST['args'] ) && is_array( $_POST['args'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['args'] ) ) : [];
        $optional = isset( $_POST['optional'] ) ? sanitize_text_field( wp_unslash( $_POST['optional'] ) ) : '';

		if ( ! empty( $classname ) && ! empty( $functionname ) && class_exists( $classname ) ) :
            $CLASS = new $classname();
            $CLASS->__construct( $functionname, $rawdata, $args, $optional );
        endif;
        die();
    }

    public static function instance() {
        if ( self::$instance == null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function build_api() {
        add_action( 'wp_ajax_nopriv_image_hover_ultimate', [ $this, 'ajax_action' ] );
        add_action( 'wp_ajax_image_hover_ultimate', [ $this, 'ajax_action' ] );
        add_action( 'wp_ajax_image_hover_settings', [ $this, 'save_action' ] );
    }
}
