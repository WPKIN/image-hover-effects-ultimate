<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Button;

/**
 * Description of Modules
 *
 * @author biplo
 */
use OXI_IMAGE_HOVER_PLUGINS\Page\Admin_Render as Admin_Render;
use OXI_IMAGE_HOVER_PLUGINS\Classes\Controls as Controls;

class Modules extends Admin_Render {

    public $StyleChanger = [
        'Button-1',
        'Button-2',
        'Button-3',
        'Button-4',
        'Button-5',
        'Button-6',
        'Button-7',
        'Button-8',
        'Button-9',
        'Button-10',
        'Button-11',
    ];

    public function register_effects() {
        return '';
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
        $this->add_control(
                'oxi-image-hover-effects-time', $this->style, [
            'label' => __('Effects Time (S)', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SLIDER,
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
                '{{WRAPPER}} .oxi-image-hover-style *,{{WRAPPER}} .oxi-image-hover-style *:before, .oxi-image-hover-style *:after' => '-webkit-transition: all {{SIZE}}{{UNIT}} ease-in-out; -moz-transition: all {{SIZE}}{{UNIT}} ease-in-out; transition: all {{SIZE}}{{UNIT}} ease-in-out;',
            ],
                ]
        );
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
                    'min' => 0,
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
                '{{WRAPPER}} .oxi-image-hover-style-button' => 'max-width:{{SIZE}}{{UNIT}};',
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
                    'min' => 0,
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
                '{{WRAPPER}} .oxi-image-hover-style-button:after ' => 'padding-bottom:{{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}}   .oxi-image-hover:hover .oxi-image-hover-figure,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure,'
                . '{{WRAPPER}} .oxi-image-hover:hover  .oxi-image-hover-figure:before,'
                . '{{WRAPPER}} .oxi-image-hover.oxi-touch .oxi-image-hover-figure:before,'
                . '{{WRAPPER}} .oxi-image-hover:hover .oxi-image-hover-figure .oxi-image-hover-image,'
                . '{{WRAPPER}}.oxi-image-hover.oxi-touch .oxi-image-hover-figure .oxi-image-hover-image,'
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
                '{{WRAPPER}} .oxi-image-hover-figure .oxi-image-hover-caption-tab' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ]
                ]
        );
        $this->end_controls_section();
    }

    public function register_icon_settings() {
        $this->start_controls_section(
                'oxi-image-hover', [
            'label' => esc_html__('Icon Settings', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'showing' => TRUE,
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-icon-width-height', $this->style, [
            'label' => __('Width Height', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SLIDER,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons' => 'width:{{SIZE}}{{UNIT}};height:{{SIZE}}{{UNIT}};',
            ],
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-icon-size', $this->style, [
            'label' => __('Size', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::SLIDER,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons' => 'font-size:{{SIZE}}{{UNIT}};',
            ],
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
                'oxi-image-hover-icon-color', $this->style, [
            'label' => __('Color', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::COLOR,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons' => 'color: {{VALUE}};',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-icon-background', $this->style, [
            'label' => __('Background', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::GRADIENT,
            'default' => 'rgba(171, 0, 201, 1)',
            'selector' => [
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons' => 'background: {{VALUE}};',
            ]
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-icon-border',
                $this->style,
                [
                    'type' => Controls::BORDER,
                    'selector' => [
                        '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons' => ''
                    ],
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-icon-radius', $this->style, [
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
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-icon-boxshadow', $this->style, [
            'type' => Controls::BOXSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons' => '',
            ]
                ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab();
        $this->add_control(
                'oxi-image-hover-icon-hover-color', $this->style, [
            'label' => __('Color', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::COLOR,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons:hover' => 'color: {{VALUE}};',
            ]
                ]
        );
        $this->add_control(
                'oxi-image-hover-icon-hover-background', $this->style, [
            'label' => __('Background', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::GRADIENT,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons:hover' => 'background: {{VALUE}};',
            ]
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-icon-hover-border',
                $this->style,
                [
                    'type' => Controls::BORDER,
                    'selector' => [
                        '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons:hover' => ''
                    ],
                ]
        );
        $this->add_responsive_control(
                'oxi-image-hover-icon-hover-radius', $this->style, [
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
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons:hover' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->add_group_control(
                'oxi-image-hover-icon-hover-boxshadow', $this->style, [
            'type' => Controls::BOXSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-icons:hover' => '',
            ]
                ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
                'oxi-image-hover-icon-margin', $this->style, [
            'label' => __('Margin', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::DIMENSIONS,
            'separator' => TRUE,
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
                '{{WRAPPER}} .oxi-image-button-hover .oxi-image-hover-caption-tab .oxi-image-hover-icon' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ]
                ]
        );
        $this->end_controls_section();
    }

    public function register_controls() {
        $this->start_section_header(
                'shortcode-addons-start-tabs', [
            'options' => [
                'button-settings' => esc_html__('General Settings', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'custom' => esc_html__('Custom CSS', OXI_IMAGE_HOVER_TEXTDOMAIN),
            ]
                ]
        );
        $this->start_section_tabs(
                'oxi-image-hover-start-tabs', [
            'condition' => [
                'oxi-image-hover-start-tabs' => 'button-settings'
            ]
                ]
        );
        $this->start_section_devider();
        $this->register_column_effects();
        $this->register_icon_settings();
        $this->end_section_devider();
        $this->start_section_devider();
        $this->register_general_style();
        $this->register_content_settings();
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
                'image_hover_title', $this->style, [
            'label' => __('Rearrange Title', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::TEXT,
            'default' => 'Image Serial',
            'placeholder' => 'Image Serial Name',
            'description' => 'Add Your Image Serial Name for rearrange Image.'
                ]
        );
        $this->add_control(
                'image_hover_first_icon', $this->style, [
            'label' => __('First Icon', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::ICON,
            'separator' => TRUE,
            'default' => '',
            'placeholder' => 'Heading',
            'description' => 'Add Your Image Hover First Icon.'
                ]
        );
        $this->add_group_control(
                'image_hover_first_icon_link', $this->style, [
            'label' => __('First URL', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::URL,
            'default' => '',
            'placeholder' => 'https://www.yoururl.com',
            'description' => 'Add Your Desire Link or Url for First Icon'
                ]
        );
        $this->add_control(
                'image_hover_second_icon', $this->style, [
            'label' => __('Second Icon', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::ICON,
            'separator' => TRUE,
            'default' => '',
            'placeholder' => 'Heading',
            'description' => 'Add Your Image Hover Second Icon.'
                ]
        );
        $this->add_group_control(
                'image_hover_second_icon_link', $this->style, [
            'label' => __('Second URL', OXI_IMAGE_HOVER_TEXTDOMAIN),
            'type' => Controls::URL,
            'default' => '',
            'placeholder' => 'https://www.yoururl.com',
            'description' => 'Add Your Desire Link or Url for Second Icon'
                ]
        );

        $this->start_controls_tabs(
                'image_hover-start-tabs', [
            'separator' => TRUE,
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
        echo '</div>';
    }

    /**
     * Template Parent Item Data Rearrange
     *
     * @since 2.0.0
     */
    public function Rearrange() {
        return '<li class="list-group-item" id="{{id}}">{{image_hover_title}}</li>';
    }

}
