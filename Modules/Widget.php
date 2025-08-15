<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Widget extends \WP_Widget {


    public function iheu_widget_widget() {
        register_widget( $this );
    }
    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
        return $instance;
    }

    function __construct() {
        parent::__construct(
            'iheu_widget',
            esc_html__( 'Image Hover Effects Ultimate', 'image-hover-effects-ultimate' ),
            [ 'description' => esc_html__( 'Image Hover Effects Ultimate Widget', 'image-hover-effects-ultimate' ) ]
        );
    }

    public function form( $instance ) {
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = esc_html__( '1', 'image-hover-effects-ultimate' );
        }
		?>
        <p>
            <label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Style ID:', 'image-hover-effects-ultimate' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
		<?php
    }


    public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		// Escape before_widget
		echo wp_kses_post( $args['before_widget'] );

		// Render your shortcode
		\OXI_IMAGE_HOVER_PLUGINS\Classes\Bootstrap::instance()->shortcode_render( $title, 'user' );

		// Escape after_widget
		echo wp_kses_post( $args['after_widget'] );
	}
}
