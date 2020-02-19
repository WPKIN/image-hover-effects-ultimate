<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Carousel\Admin;

/**
 * Description of Effects1
 *
 * @author biplob
 */

use OXI_IMAGE_HOVER_PLUGINS\Modules\Carousel\Modules as Modules;
use OXI_IMAGE_HOVER_PLUGINS\Classes\Controls as Controls;

class Effects2 extends Modules
{

    public function register_carousel_query_settings()
    {
        $this->start_controls_section(
            'display-post',
            [
                'label' => esc_html__('Carousel Query', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'showing' => TRUE,
            ]
        );
        $this->add_control(
            'carousel_note',
            $this->style,
            [
                'label' => __('Note', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::HEADING,
                'description' => 'Works after saving and reloading all the fields '
            ]
        );
        $this->add_control(
            'carousel_register_style',
            $this->style,
            [
                'label' => __('Carousel Style', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'loader' => TRUE,
                'type' => Controls::SELECT,
                'options' => $this->all_style(),
                'description' => 'Confirm Your Shortcode name which one you wanna create carousel.'
            ]
        );
        $this->add_control(
            'carousel_effect',
            $this->style,
            [
                'label' => __('Carousel Effect', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SELECT,
                'separator' => TRUE,
                'loader' => TRUE,
                'default' => 'coverflow',
                'options' => [
                    'coverflow' => __('Coverflow', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'carousel' => __('Carousel', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'wheel' => __('Wheel', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'flat' => __('Flat', OXI_IMAGE_HOVER_TEXTDOMAIN),
                ],
            ]
        );
        $this->add_control(
            'carousel_autoplay',
            $this->style,
            [
                'label' => __('Autoplay', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'yes',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'carousel_autoplay_speed',
            $this->style,
            [
                'label' => __('Autoplay Speed', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::NUMBER,
                'default' => 2000,
                'condition' => [
                    'carousel_autoplay' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'carousel_fadeIn',
            $this->style,
            [
                'label' => __('Fade In (ms)', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::NUMBER,
                'default' => 500,
            ]
        );
        $this->add_control(
            'carousel_center_mode',
            $this->style,
            [
                'label' => __('Item Starts From Center?', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'no',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'carousel_start_number',
            $this->style,
            [
                'label' => __('Enter Starts Number', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::NUMBER,
                'default' => 2,
                'condition' => [
                    '! carousel_center_mode' => '',
                ],
            ]
        );
        $this->add_control(
            'carousel_pause_on_hover',
            $this->style,
            [
                'label' => __('Pause on Hover', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'yes',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'carousel_infinite',
            $this->style,
            [
                'label' => __('Infinite Loop', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'yes',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'carousel_click',
            $this->style,
            [
                'label' => __('On Click Play?', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'yes',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'carousel_touch',
            $this->style,
            [
                'label' => __('On Touch Play?', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'yes',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'carousel_show_arrows',
            $this->style,
            [
                'label' => __('Arrows', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'yes',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',

            ]
        );

        $this->end_controls_section();
    }

    public function register_carousel_dots_settings()
    {
    }
}
