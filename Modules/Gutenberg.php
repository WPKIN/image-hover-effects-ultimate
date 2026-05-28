<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules;

class Gutenberg {

    public function __construct() {
        $this->register_block();
        add_action( 'enqueue_block_editor_assets', [ $this, 'editor_assets' ] );
    }

    public function register_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }
        register_block_type(
            OXI_IMAGE_HOVER_PATH . 'assets/blocks/image-hover',
            [
                'render_callback' => [ $this, 'render_block' ],
            ]
        );
    }

    public function editor_assets() {
        wp_enqueue_script(
            'iheu-gutenberg-block',
            OXI_IMAGE_HOVER_URL . 'assets/backend/js/gutenberg-block.js',
            [ 'wp-blocks', 'wp-element', 'wp-components', 'wp-server-side-render', 'wp-block-editor' ],
            OXI_IMAGE_HOVER_PLUGIN_VERSION,
            true
        );

        wp_localize_script(
            'iheu-gutenberg-block',
            'iheuBlockData',
            $this->get_editor_data()
        );

        wp_enqueue_style(
            'oxi-animation',
            OXI_IMAGE_HOVER_URL . 'assets/frontend/css/animation.css',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION
        );
        wp_enqueue_style(
            'oxi-image-hover',
            OXI_IMAGE_HOVER_URL . 'assets/frontend/css/style.css',
            [],
            OXI_IMAGE_HOVER_PLUGIN_VERSION
        );
    }

    public function render_block( array $attributes ) {
        $style_id = isset( $attributes['styleId'] ) ? absint( $attributes['styleId'] ) : 0;

        if ( ! $style_id ) {
            return '<p style="padding:16px;border:2px dashed #ccc;text-align:center;">'
                . 'Please select an Image Hover style from the block settings panel.'
                . '</p>';
        }

        $is_rest        = defined( 'REST_REQUEST' ) && REST_REQUEST;
        $styles_before  = $is_rest ? wp_styles()->queue : [];

        $shortcode_output = do_shortcode( '[iheu_ultimate_oxi id="' . $style_id . '"]' );

        if ( ! $is_rest ) {
            return '<div class="iheu-gutenberg-block">' . $shortcode_output . '</div>';
        }

        // Inline every plugin CSS file that do_shortcode() just enqueued.
        // This covers: animation.css, style.css, and module-specific files
        // (e.g. Modules/General/Files/general.css, style-1.css) that would
        // otherwise never reach the browser in a REST/block-renderer context.
        $inline_css  = '';
        $plugin_url  = untrailingslashit( OXI_IMAGE_HOVER_URL );
        $plugin_path = untrailingslashit( OXI_IMAGE_HOVER_PATH );

        foreach ( array_diff( wp_styles()->queue, $styles_before ) as $handle ) {
            $obj = wp_styles()->registered[ $handle ] ?? null;
            if ( ! $obj || empty( $obj->src ) ) {
                continue;
            }
            $src = preg_replace( '/[?#].*$/', '', $obj->src );
            if ( 0 !== strpos( $src, $plugin_url ) ) {
                continue;
            }
            $file_path = $plugin_path . substr( $src, strlen( $plugin_url ) );
            if ( ! file_exists( $file_path ) ) {
                continue;
            }
            // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
            $content = file_get_contents( $file_path );
            if ( false === $content ) {
                continue;
            }
            $file_rel    = str_replace( $plugin_path, '', dirname( $file_path ) );
            $base_url    = untrailingslashit( OXI_IMAGE_HOVER_URL ) . '/' . $file_rel . '/';
            $inline_css .= '<style id="iheu-css-' . esc_attr( $handle ) . '">'
                . $this->absolutize_css_urls( $content, $base_url )
                . '</style>';
        }

        // Per-shortcode CSS from the DB stylesheet column (goes to $pending_late_css
        // because wp_footer never fires in REST context).
        $pending = \OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render::$pending_late_css;
        \OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render::$pending_late_css = [];
        $queued_css = '';
        foreach ( $pending as $entry ) {
            if ( ! empty( $entry['css'] ) ) {
                $queued_css .= $entry['css'];
            }
        }
        if ( $queued_css ) {
            $queued_css  = str_ireplace( '</style>', '', $queued_css );
            $inline_css .= '<style id="iheu-block-shortcode-css">' . $queued_css . '</style>';
        }

        return $inline_css . '<div class="iheu-gutenberg-block">' . $shortcode_output . '</div>';
    }

    private function absolutize_css_urls( string $css, string $base_url ) {
        $parsed      = wp_parse_url( $base_url );
        $base_origin = ( $parsed['scheme'] ?? 'https' ) . '://' . ( $parsed['host'] ?? '' );
        $base_path   = rtrim( $parsed['path'] ?? '', '/' ) . '/';

        return preg_replace_callback(
            '/url\(\s*[\'"]?([^\'"\)\s]+)[\'"]?\s*\)/i',
            function ( $matches ) use ( $base_origin, $base_path ) {
                $url = $matches[1];

                if (
                    0 === strpos( $url, 'http' ) ||
                    0 === strpos( $url, '//' ) ||
                    0 === strpos( $url, 'data:' )
                ) {
                    return $matches[0];
                }

                if ( 0 === strpos( $url, '/' ) ) {
                    return 'url("' . $base_origin . $url . '")';
                }

                $suffix = '';
                if ( preg_match( '/^([^?#]+)([?#].*)$/', $url, $m ) ) {
                    $url    = $m[1];
                    $suffix = $m[2];
                }

                $merged = $base_path . $url;
                $parts  = explode( '/', $merged );
                $result = [];
                foreach ( $parts as $part ) {
                    if ( '..' === $part ) {
                        array_pop( $result );
                    } elseif ( '.' !== $part ) {
                        $result[] = $part;
                    }
                }

                return 'url("' . $base_origin . implode( '/', $result ) . $suffix . '")';
            },
            $css
        );
    }

    private function get_editor_data() {
        global $wpdb;

        $table     = $wpdb->prefix . 'image_hover_ultimate_style';
        $rows      = $wpdb->get_results( "SELECT id, name, style_name FROM {$table} ORDER BY id DESC", ARRAY_A ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $shortcodes = [];
        $edit_urls  = [];

        if ( $rows ) {
            foreach ( $rows as $row ) {
                $label        = ( isset( $row['name'] ) && '' !== $row['name'] ? $row['name'] : 'Image Hover' ) . ' (#' . $row['id'] . ')';
                $shortcodes[] = [ 'value' => (string) $row['id'], 'label' => $label ];

                $parts       = explode( '-', $row['style_name'] );
                $effects     = isset( $parts[0] ) ? strtolower( $parts[0] ) : '';
                $edit_urls[ (string) $row['id'] ] = admin_url(
                    'admin.php?page=oxi-image-hover-ultimate&effects=' . $effects . '&styleid=' . $row['id']
                );
            }
        }

        return [
            'shortcodes' => $shortcodes,
            'editUrls'   => $edit_urls,
            'createUrl'  => admin_url( 'admin.php?page=image-hover-ultimate-getting-started' ),
        ];
    }
}
