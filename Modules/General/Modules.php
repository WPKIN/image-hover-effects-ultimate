<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\General;

/**
 * Description of Modules
 *
 * @author biplo
 */
use OXI_IMAGE_HOVER_PLUGINS\Page\Admin_Render as Admin_Render;
use OXI_IMAGE_HOVER_PLUGINS\Classes\Controls as Controls;

class Modules extends Admin_Render {

    public $StyleChanger = [
        'General-1',
        'General-2',
        'General-3',
        'General-4',
        'General-5',
        'General-6',
        'General-7',
        'General-8',
        'General-9',
        'General-10',
        'General-11',
        'General-12',
        'General-13',
        'General-14',
        'General-15',
        'General-16',
        'General-17',
        'General-18',
        'General-19',
        'General-20',
        'General-21',
        'General-22',
        'General-23',
        'General-24',
        'General-25',
        'General-25',
        'General-27',
        'General-28',
        'General-29',
        'General-30',
        'General-31',
        'General-32',
        'General-33',
    ];

    public function register_effects() {


        return '';
    }

    public function register_effects_time() {
        $this->add_control(
                'oxi-image-hover-effects-time', $this->style, [
            'label' => __('Effects Time (S)', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SLIDER,
            'simpleenable' => TRUE,
            'default' => [
                'unit' => 'ms',
                'size' => '',
            ],
            'range' => [
                'ms' => [
                    'min' => 0.0,
                    'max' => 5000,
                    'step' => 1,
                ],
                's' => [
                    'min' => 0.0,
                    'max' => 5,
                    'step' => 0.01,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-style *,{{WRAPPER}} .oxi-image-hover-style *:before,{{WRAPPER}} .oxi-image-hover-style *:after' => '-webkit-transition: all {{SIZE}}{{UNIT}} ease-in-out; -moz-transition: all {{SIZE}}{{UNIT}} ease-in-out; transition: all {{SIZE}}{{UNIT}} ease-in-out;',
            ],
                ]
        );
    }

    public function register_column_effects() {
        $this->start_controls_section(
                'oxi-image-hover', [
            'label' => esc_html__('Column & Effects', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => TRUE,
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-col', $this->style, [
            'type' => Controls::COLUMN,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-style' => '',
            ]
                ]
        );
        $this->register_effects();
        $this->register_effects_time();
        $this->add_group_control(
                'oxi-image-hover-animation', $this->style, [
            'type' => Controls::ANIMATION,
            'separator' => TRUE,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-style' => '',
            ]
                ]
        );
        $this->end_controls_section();
    }

    public function register_general_style() {
        $this->start_controls_section(
                'oxi-image-hover', [
            'label' => esc_html__('Width & Height', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => true,
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-width', $this->style, [
            'label' => __('Width', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SLIDER,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 1900,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 200,
                    'step' => 0.1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-style-general' => 'max-width:{{SIZE}}{{UNIT}};',
            ],
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-height', $this->style, [
            'label' => __('Height', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SLIDER,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 1000,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 200,
                    'step' => 1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-style-general:after ' => 'padding-bottom:{{SIZE}}{{UNIT}};',
            ],
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-margin', $this->style, [
            'label' => __('Margin', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-style' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->end_controls_section();
    }

    public function register_content_settings() {
        $this->start_controls_section(
                'oxi-image-hover', [
            'label' => esc_html__('General Settings', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => TRUE,
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-background', $this->style, [
            'type' => Controls::BACKGROUND,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-caption-tab' => '',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-content-alignment', $this->style, [
            'label' => __('Content Alignment', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SELECT,
            'default' => 'image-hover-align-center-center',
            'options' => [
                'image-hover-align-top-left' => __('Top Left', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'image-hover-align-top-center' => __('Top Center', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'image-hover-align-top-right' => __('Top Right', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'image-hover-align-center-left' => __('Center Left', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'image-hover-align-center-center' => __('Center Center', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'image-hover-align-center-right' => __('Center Right', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'image-hover-align-bottom-left' => __('Bottom Left', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'image-hover-align-bottom-center' => __('Bottom Center', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'image-hover-align-bottom-right' => __('Bottom Right', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-caption-tab' => '',
            ]
                ]
        );
        $this->start_controls_tabs(
                'image-hover-content-start-tabs',
                [
                    'options' => [
                        'normal' => esc_html__('Normal ', OXI_IMAGE_HOVER_TEXTDOMAIN),
                        'hover' => esc_html__('Hover ', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    ]
                ]
        );
        $this->start_controls_tab();
        $this->add_responsive_control(
                'oxi-image-hover-border-radius', $this->style, [
            'label' => __('Border Radius', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure,'
                . '{{WRAPPER}} .oxi-image-hover-figure:before,'
                . '{{WRAPPER}} .oxi-image-hover-image,'
                . '{{WRAPPER}} .oxi-image-hover-image:before,'
                . '{{WRAPPER}} .oxi-image-hover-image img,'
                . '{{WRAPPER}} .oxi-image-hover-figure-caption,'
                . '{{WRAPPER}} .oxi-image-hover-figure-caption:before,'
                . '{{WRAPPER}} .oxi-image-hover-figure-caption:after,'
                . '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-caption-tab' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-boxshadow', $this->style, [
            'type' => Controls::BOXSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-image:before' => '',
            ],
                ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab();
        $this->add_responsive_control(
                'oxi-image-hover-hover-border-radius', $this->style, [
            'label' => __('Border Radius', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure,'
                . '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure:before,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure:before,'
                . '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure .oxi-image-hover-image,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure .oxi-image-hover-image,'
                . '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure .oxi-image-hover-image:before,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure .oxi-image-hover-image:before,'
                . '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure .oxi-image-hover-image img,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure .oxi-image-hover-image img,'
                . '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure .oxi-image-hover-figure-caption,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure .oxi-image-hover-figure-caption,'
                . '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure .oxi-image-hover-figure-caption:before,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure .oxi-image-hover-figure-caption:before,'
                . '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure .oxi-image-hover-figure-caption:after,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure .oxi-image-hover-figure-caption:after,'
                . '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure .oxi-image-hover-figure-caption .oxi-image-hover-caption-tab,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure .oxi-image-hover-figure-caption .oxi-image-hover-caption-tab' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-hover-boxshadow', $this->style, [
            'type' => Controls::BOXSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure .oxi-image-hover-figure-caption:before' => '',
            ]
                ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
                'oxi-image-hover-padding', $this->style, [
            'label' => __('Padding', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'separator' => TRUE,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 500,
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
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure .oxi-image-hover-caption-tab' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ]
                ]
        );
        $this->end_controls_section();
    }

    public function register_description_settings() {
        $this->start_controls_section(
                'oxi-image-hover', [
            'label' => esc_html__('Description Settings', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => TRUE,
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-desc-typho', $this->style, [
            'type' => Controls::TYPOGRAPHY,
            'include' => Controls::ALIGNNORMAL,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-content' => '',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-desc-color', $this->style, [
            'label' => __('Color', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::COLOR,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-content' => 'color: {{VALUE}};',
            ]
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-desc-tx-shadow', $this->style, [
            'type' => Controls::TEXTSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-content' => '',
            ]
                ]
        );

        $this->add_responsive_control(
                'oxi-image-hover-desc-margin', $this->style, [
            'label' => __('Margin', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
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
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-content' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-desc-animation', $this->style, [
            'label' => __('Animation', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SELECT,
            'default' => 'solid',
            'options' => [
                '' => __('None', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-up' => __('Fade Up', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-down' => __('Fade Down', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-left' => __('Fade Left', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-right' => __('Fade Right', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-up-big' => __('Fade up Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-down-big' => __('Fade down Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-left-big' => __('Fade left Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-right-big' => __('Fade Right Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-zoom-in' => __('Zoom In', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-zoom-out' => __('Zoom Out', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-flip-x' => __('Flip X', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-flip-y' => __('Flip Y', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-content' => '',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-desc-animation-delay', $this->style, [
            'label' => __('Animation Delay', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SELECT,
            'default' => '',
            'options' => [
                '' => __('None', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-xs' => __('Delay XS', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-sm' => __('Delay SM', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-md' => __('Delay MD', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-lg' => __('Delay LG', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-xl' => __('Delay XL', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-xxl' => __('Delay XXL', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-content' => '',
            ]
                ]
        );

        $this->end_controls_section();
    }

    public function register_heading_settings() {
        $this->start_controls_section(
                'oxi-image-hover', [
            'label' => esc_html__('Heading Settings', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => TRUE,
                ]
        );
        $this->add_control(
                'oxi-image-hover-heading-underline', $this->style,
                [
                    'label' => __('Haading Underline', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'type' => Controls::CHOOSE,
                    'operator' => Controls::OPERATOR_TEXT,
                    'default' => '',
                    'options' => [
                        'oxi-image-hover-heading-underline' => [
                            'title' => __('Show', OXI_IMAGE_HOVER_TEXTDOMAIN),
                        ],
                        '' => [
                            'title' => __('Hide', OXI_IMAGE_HOVER_TEXTDOMAIN),
                        ],
                    ],
                    'selector' => [
                        '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading' => '',
                    ]
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-heading-typho', $this->style, [
            'type' => Controls::TYPOGRAPHY,
            'include' => Controls::ALIGNNORMAL,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading' => '',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-heading-color', $this->style, [
            'label' => __('Color', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::COLOR,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading' => 'color: {{VALUE}};',
            ]
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-heading-tx-shadow', $this->style, [
            'type' => Controls::TEXTSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading' => '',
            ]
                ]
        );

        $this->add_responsive_control(
                'oxi-image-hover-heading-margin', $this->style, [
            'label' => __('Margin', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'simpledimensions' => 'heading',
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 500,
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
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-heading-animation', $this->style, [
            'label' => __('Animation', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SELECT,
            'default' => '',
            'options' => [
                '' => __('None', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-up' => __('Fade Up', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-down' => __('Fade Down', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-left' => __('Fade Left', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-right' => __('Fade Right', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-up-big' => __('Fade up Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-down-big' => __('Fade down Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-left-big' => __('Fade left Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-right-big' => __('Fade Right Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-zoom-in' => __('Zoom In', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-zoom-out' => __('Zoom Out', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-flip-x' => __('Flip X', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-flip-y' => __('Flip Y', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading' => '',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-heading-animation-delay', $this->style, [
            'label' => __('Animation Delay', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SELECT,
            'default' => '',
            'options' => [
                '' => __('None', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-xs' => __('Delay XS', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-sm' => __('Delay SM', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-md' => __('Delay MD', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-lg' => __('Delay LG', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-xl' => __('Delay XL', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-xxl' => __('Delay XXL', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading' => '',
            ]
                ]
        );

        $this->end_controls_section();
    }

    public function register_heading_Underline() {
        $this->start_controls_section(
                'oxi-image-hover-head-underline', [
            'label' => esc_html__('Heading Underline', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => false,
            'condition' => [
                'oxi-image-hover-heading-underline' => 'oxi-image-hover-heading-underline'
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-underline-position',
                $this->style,
                [
                    'label' => __('Position', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'type' => Controls::CHOOSE,
                    'operator' => Controls::OPERATOR_ICON,
                    'default' => 'left: 50%; transform: translateX(-50%);',
                    'options' => [
                        'left: 0; transform: translateX(0%);' => [
                            'title' => __('Left', OXI_IMAGE_HOVER_TEXTDOMAIN),
                            'icon' => 'fa fa-align-left',
                        ],
                        'left: 50%; transform: translateX(-50%);' => [
                            'title' => __('Center', OXI_IMAGE_HOVER_TEXTDOMAIN),
                            'icon' => 'fa fa-align-center',
                        ],
                        'left: 100%; transform: translateX(-100%);' => [
                            'title' => __('Right', OXI_IMAGE_HOVER_TEXTDOMAIN),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'selector' => [
                        '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading.oxi-image-hover-heading-underline:before' => '{{VALUE}}',
                    ]
                ]
        );

        $this->add_control(
                'oxi-image-hover-underline-color', $this->style, [
            'label' => __('Color', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::COLOR,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading.oxi-image-hover-heading-underline:before' => 'border-bottom-color: {{VALUE}};',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-underline-type', $this->style, [
            'label' => __('Underline Type', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SELECT,
            'default' => 'solid',
            'options' => [
                '' => __('None', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'solid' => __('Solid', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'dotted' => __('Dotted', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'dashed' => __('Dashed', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'double' => __('Double', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'groove' => __('Groove', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'ridge' => __('Ridge', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'inset' => __('Inset', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'outset' => __('Outset', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'hidden' => __('Hidden', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading.oxi-image-hover-heading-underline:before' => 'border-bottom-style: {{VALUE}};',
            ]
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-underline-width', $this->style, [
            'label' => __('Width', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SLIDER,
            'default' => [
                'unit' => '%',
                'size' => 100,
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 1900,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 200,
                    'step' => 0.1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading.oxi-image-hover-heading-underline:before' => 'width:{{SIZE}}{{UNIT}};',
            ]
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-underline-height', $this->style, [
            'label' => __('Size', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SLIDER,
            'default' => [
                'unit' => 'px',
                'size' => 1,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading.oxi-image-hover-heading-underline:before' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
            ]
                ]
        );

        $this->add_responsive_control(
                'oxi-image-hover-underline-distance', $this->style, [
            'label' => __('Distance', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SLIDER,
            'default' => [
                'unit' => 'px',
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 300,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-heading.oxi-image-hover-heading-underline' => 'margin-bottom:{{SIZE}}{{UNIT}};',
            ],
                ]
        );
        $this->end_controls_section();
    }

    public function register_button_settings() {
        $this->start_controls_section(
                'oxi-image-hover', [
            'label' => esc_html__('Button Settings', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => false,
                ]
        );
        $this->add_control(
                'oxi-image-hover-button-position',
                $this->style,
                [
                    'label' => __('Position', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'type' => Controls::CHOOSE,
                    'operator' => Controls::OPERATOR_ICON,
                    'default' => 'center',
                    'options' => [
                        'left' => [
                            'title' => __('Left', OXI_IMAGE_HOVER_TEXTDOMAIN),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __('Center', OXI_IMAGE_HOVER_TEXTDOMAIN),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __('Right', OXI_IMAGE_HOVER_TEXTDOMAIN),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'selector' => [
                        '{{WRAPPER}} .oxi-image-hover-figure-caption .oxi-image-hover-button' => 'text-align:{{VALUE}}',
                    ]
                ]
        );

        $this->add_group_control(
                'oxi-image-hover-button-typho', $this->style, [
            'type' => Controls::TYPOGRAPHY,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => '',
            ]
                ]
        );
        $this->start_controls_tabs(
                'oxi-image-hover-start-tabs',
                [
                    'options' => [
                        'normal' => esc_html__('Normal ', OXI_IMAGE_HOVER_TEXTDOMAIN),
                        'hover' => esc_html__('Hover ', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    ]
                ]
        );
        $this->start_controls_tab();
        $this->add_control(
                'oxi-image-hover-button-color', $this->style, [
            'label' => __('Color', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::COLOR,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => 'color: {{VALUE}};',
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn:hover' => 'color: {{VALUE}};',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-button-background', $this->style, [
            'label' => __('Background', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::GRADIENT,
            'default' => 'rgba(171, 0, 201, 1)',
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => 'background: {{VALUE}};',
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn:hover' => 'background: {{VALUE}};',
            ]
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-button-border',
                $this->style,
                [
                    'type' => Controls::BORDER,
                    'selector' => [
                        '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => ''
                    ],
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-button-tx-shadow', $this->style, [
            'type' => Controls::TEXTSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => '',
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn:hover' => '',
            ]
                ]
        );

        $this->add_responsive_control(
                'oxi-image-hover-button-radius', $this->style, [
            'label' => __('Border Radius', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-button-boxshadow', $this->style, [
            'type' => Controls::BOXSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => '',
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn:hover' => '',
            ]
                ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab();
        $this->add_control(
                'oxi-image-hover-button-hover-color', $this->style, [
            'label' => __('Color', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::COLOR,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-caption-tab .oxi-image-hover-button a.oxi-image-btn:hover' => 'color: {{VALUE}};',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-button-hover-background', $this->style, [
            'label' => __('Background', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::GRADIENT,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-caption-tab .oxi-image-hover-button a.oxi-image-btn:hover' => 'background: {{VALUE}};',
            ]
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-button-hover-border',
                $this->style,
                [
                    'type' => Controls::BORDER,
                    'simpleborder'=> true,
                    'selector' => [
                        '{{WRAPPER}} .oxi-image-hover-caption-tab .oxi-image-hover-button a.oxi-image-btn:hover' => ''
                    ],
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-button-hover-tx-shadow', $this->style, [
            'type' => Controls::TEXTSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-caption-tab .oxi-image-hover-button a.oxi-image-btn:hover' => '',
            ]
                ]
        );

        $this->add_responsive_control(
                'oxi-image-hover-button-hover-radius', $this->style, [
            'label' => __('Border Radius', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-caption-tab .oxi-image-hover-button a.oxi-image-btn:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-hover-button-boxshadow', $this->style, [
            'type' => Controls::BOXSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-caption-tab .oxi-image-hover-button a.oxi-image-btn:hover' => '',
            ]
                ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
                'oxi-image-hover-button-padding', $this->style, [
            'label' => __('Padding', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'separator' => TRUE,
            'simpledimensions' => 'double',
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 500,
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
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ]
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-button-margin', $this->style, [
            'label' => __('Margin', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'simpledimensions' => 'double',
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 500,
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
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-button-animation', $this->style, [
            'label' => __('Animation', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SELECT,
            'default' => 'solid',
            'options' => [
                '' => __('None', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-up' => __('Fade Up', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-down' => __('Fade Down', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-left' => __('Fade Left', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-right' => __('Fade Right', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-up-big' => __('Fade up Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-down-big' => __('Fade down Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-left-big' => __('Fade left Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-fade-right-big' => __('Fade Right Big', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-zoom-in' => __('Zoom In', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-zoom-out' => __('Zoom Out', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-flip-x' => __('Flip X', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'iheu-flip-y' => __('Flip Y', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button' => '',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-button-animation-delay', $this->style, [
            'label' => __('Animation Delay', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SELECT,
            'default' => '',
            'options' => [
                '' => __('None', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-xs' => __('Delay XS', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-sm' => __('Delay SM', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-md' => __('Delay MD', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-lg' => __('Delay LG', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-xl' => __('Delay XL', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'oxi-image-hover-delay-xxl' => __('Delay XXL', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button' => '',
            ]
                ]
        );

        $this->end_controls_section();
    }

    public function register_controls() {
        $this->start_section_header(
                'shortcode-addons-start-tabs', [
            'options' => [
                'general-settings' => esc_html__('General Settings', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'typography' => esc_html__('Typography', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'custom' => esc_html__('Custom CSS', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ]
                ]
        );
        $this->start_section_tabs(
                'oxi-image-hover-start-tabs', [
            'condition' => [
                'oxi-image-hover-start-tabs' => 'general-settings'
            ]
                ]
        );
        $this->start_section_devider();
        $this->register_column_effects();
        $this->register_general_style();
        $this->end_section_devider();
        $this->start_section_devider();
        $this->register_content_settings();
        $this->end_section_devider();
        $this->end_section_tabs();
        $this->start_section_tabs(
                'oxi-image-hover-start-tabs', [
            'condition' => [
                'oxi-image-hover-start-tabs' => 'typography'
            ]
                ]
        );
        $this->start_section_devider();
        $this->register_heading_settings();
        $this->register_heading_Underline();
        $this->end_section_devider();
        $this->start_section_devider();
        $this->register_description_settings();
        $this->register_button_settings();
        $this->end_section_devider();
        $this->end_section_tabs();


        $this->start_section_tabs(
                'oxi-image-hover-start-tabs', [
            'condition' => [
                'oxi-image-hover-start-tabs' => 'custom'
            ],
            'padding' => '10px'
                ]
        );

        $this->start_controls_section(
                'oxi-image-hover', [
            'label' => esc_html__('Custom CSS', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => TRUE,
                ]
        );
        $this->add_control(
                'image-hover-custom-css', $this->style, [
            'label' => __('', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::TEXTAREA,
            'default' => '',
            'description' => 'Add Your Description Unless make it blank.'
                ]
        );
        $this->end_controls_section();
        $this->end_section_tabs();
    }

    public function modal_opener() {
        $this->add_substitute_control('', [], [
            'type' => Controls::MODALOPENER,
            'title' => __('Add New Image Hover', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'sub-title' => __('Open Image Hover Form', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => TRUE,
        ]);
    }

    public function modal_form_data() {
        echo '<div class="modal-header">                    
                    <h4 class="modal-title">Image Hover Form</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">';
        $this->add_control(
                'image_hover_heading', $this->style, [
            'label' => __('Title', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::TEXT,
            'default' => '',
            'placeholder' => 'Heading',
            'description' => 'Add Your Image Hover Title.'
                ]
        );
        $this->add_control(
                'image_hover_description', $this->style, [
            'label' => __('Short Description', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::TEXTAREA,
            'default' => '',
            'description' => 'Add Your Description Unless make it blank.'
                ]
        );

        $this->start_controls_tabs(
                'image_hover-start-tabs', [
            'options' => [
                'frontend' => esc_html__('Image', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'backend' => esc_html__('Feature Image', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ]
                ]
        );
        $this->start_controls_tab();

        $this->add_group_control(
                'image_hover_image', $this->style,
                [
                    'label' => __('Image', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'type' => Controls::MEDIA,
                    'description' => 'Add or Modify Your Image. You can use Media Library or Custom URL'
                ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab();
        $this->add_group_control(
                'image_hover_feature_image', $this->style,
                [
                    'label' => __('Feature Image', OXI_IMAGE_HOVER_TEXTDOMAIN),
                    'type' => Controls::MEDIA,
                    'description' => 'Add or Modify Your Feature Image. Adjust background to get better design.'
                ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(
                'image_hover_button_link', $this->style, [
            'label' => __('URL', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::URL,
            'separator' => TRUE,
            'default' => '',
            'placeholder' => 'https://www.yoururl.com',
            'description' => 'Add Your Desire Link or Url Unless make it blank'
                ]
        );
        $this->add_control(
                'image_hover_button_text', $this->style, [
            'label' => __('Button Text', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::TEXT,
            'default' => '',
            'description' => 'Customize your button text. Button will only view while Url given'
                ]
        );

        echo '</div>';
    }

    /**
     * Template Parent Item Data Rearrange
     *
     * @since 2.0.0
     */
    public function Rearrange() {
        return '<li class="list-group-item" id="{{id}}">{{image_hover_heading}}</li>';
    }

}
