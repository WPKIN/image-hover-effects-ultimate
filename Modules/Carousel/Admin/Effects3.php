<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Carousel\Admin;

/**
 * Description of Effects1
 *
 * @author biplob
 */
use OXI_IMAGE_HOVER_PLUGINS\Modules\Carousel\Modules as Modules;
use OXI_IMAGE_HOVER_PLUGINS\Classes\Controls as Controls;

class Effects3 extends Modules {
    

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
        $this->add_responsive_control(
            'carousel_width',
            $this->style,
            [
                'label' => __('Max Width', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'separator' => TRUE,
                'default' => [
                    'unit' => '%',
                    'size' => '80',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1400,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selector' => [
                    '{{WRAPPER}}.oxi-addons-container .oxi-addons-row.oxi-addons-swiper-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'carousel_item',
            $this->style,
            [
                'label' => __('Item Show', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '3',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'carousel_grap',
            $this->style,
            [
                'label' => __('Item Padding', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '10',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
            ]
        );
        $this->add_control(
            'carousel_effect',
            $this->style,
            [
                'label' => __('Carousel Effect', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'fade' => __('Fade', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'cube' => __('Cube', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'coverflow' => __('Coverflow', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'flip' => __('Flip', OXI_IMAGE_HOVER_TEXTDOMAIN),
                ],
                'description' => 'Adjusting the width requires effective modification'
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
            'carousel_speed',
            $this->style,
            [
                'label' => __('Animation Speed', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::NUMBER,
                'default' => 500,
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
            'carousel_adaptive_height',
            $this->style,
            [
                'label' => __('Adaptive Height', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'yes',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'carousel_grab_cursor',
            $this->style,
            [
                'label' => __('Grab Cursor', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'no',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'carousel_direction',
            $this->style,
            [
                'label' => __('Direction', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SELECT,
                'default' => 'ltr',
                'options' => [
                    'ltr' => __('Left', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'rtl' => __('Right', OXI_IMAGE_HOVER_TEXTDOMAIN),
                ],
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
        $this->add_control(
            'carousel_show_dots',
            $this->style,
            [
                'label' => __('Dots', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'loader' => TRUE,
                'default' => 'no',
                'yes' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'no' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    public function register_carousel_dots_settings()
    {
        $this->start_controls_section(
            'shortcode-addons',
            [
                'label' => esc_html__('Carousel Dots', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'showing' => FALSE,
                'condition' => [
                    'carousel_show_dots' => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'carousel_dots_width_height',
            $this->style,
            [
                'label' => __('Width & Height', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '12',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'carousel_dots_position_Y',
            $this->style,
            [
                'label' => __('Position Y', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'default' => [
                    'unit' => '%',
                    'size' => '25',
                ],
                'range' => [
                    'px' => [
                        'min' => -900,
                        'max' => 900,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots' => 'bottom: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'carousel_dots_spacing',
            $this->style,
            [
                'label' => __('Spacing', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '3',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 1,
                    ],
                ],
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots .swiper-pagination-bullet' => 'margin: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'shortcode-addons-start-tabs',
            [
                'options' => [
                    'normal' => esc_html__('Normal', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'hover' => esc_html__('Hover', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'active' => esc_html__('Active', OXI_IMAGE_HOVER_TEXTDOMAIN),
                ]
            ]
        );
        $this->start_controls_tab();
        ;
        $this->add_control(
            'carousel_dots_bg_color',
            $this->style,
            [
                'label' => __('Color', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::COLOR,
                'default' => 'rgb(0, 0, 0)',
                'oparetor' => 'RGB',
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            'carousel_dots_border',
            $this->style,
            [
                'type' => Controls::BORDER,
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots .swiper-pagination-bullet' => '',
                ]
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab();
        $this->add_control(
            'carousel_dots_bg_color_hover',
            $this->style,
            [
                'label' => __('Background', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::COLOR,
                'default' => 'rgb(119, 119, 119)',
                'oparetor' => 'RGB',
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            'carousel_dots_border_hover',
            $this->style,
            [
                'type' => Controls::BORDER,
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots .swiper-pagination-bullet:hover' => '',
                ]
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab();
        $this->add_control(
            'carousel_dots_bg_color_active',
            $this->style,
            [
                'label' => __('Color', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::COLOR,
                'default' => '#AB00C9',
                'oparetor' => 'RGB',
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            'carousel_dots_border_active',
            $this->style,
            [
                'type' => Controls::BORDER,
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots .swiper-pagination-bullet-active' => '',
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            'carousel_dots_border_radius_normal',
            $this->style,
            [
                'label' => __('Border Radius', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::DIMENSIONS,
                'separator' => TRUE,
                'default' => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => .1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => .1,
                    ],
                ],
                'selector' => [
                    '{{WRAPPER}} .oxi_carousel_dots .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }
}
