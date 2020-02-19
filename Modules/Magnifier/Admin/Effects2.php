<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Magnifier\Admin;

/**
 * Description of Effects1
 *
 * @author biplob
 */
use OXI_IMAGE_HOVER_PLUGINS\Modules\Magnifier\Modules as Modules;
use OXI_IMAGE_HOVER_PLUGINS\Classes\Controls as Controls;

class Effects2 extends Modules {

    public function register_general_tabs()
    {
        $this->start_section_tabs(
            'oxi-image-hover-start-tabs', [
                'condition' => [
                    'oxi-image-hover-start-tabs' => 'general-settings',
                ],
            ]
        );
        $this->start_section_devider();
        $this->register_general_style(); 
        $this->end_section_devider();
        $this->start_section_devider(); 
        $this->register_image_settings(); 
        $this->register_magnifi_settings(); 

        $this->end_section_devider();
        $this->end_section_tabs();
    }
        /*
     * @return void
     * Start Module Method for Magnifi Setting #Light-box
     */
    public function register_magnifi_settings()
    {
        $this->start_controls_section(
            'shortcode-addons', [
                'label' => esc_html__('Magnifier Settings', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'showing' => false,
            ]
        );

        $this->add_control(
            'oxi_image_magnifier_magnifi_router_switcher',
            $this->style,
            [
                'label' => __('Rounded Corner', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'default' => 'no',
                'loader' => true,
                'label_on' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'label_off' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'oxi_image_magnifier_magnifi_offset_switcher',
            $this->style,
            [
                'label' => __('Offset', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'default' => 'no',
                'loader' => true,
                'label_on' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'label_off' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'oxi_image_magnifier_offset_x',
            $this->style,
            [
                'label' => __('Offset X', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'condition' => [
                    'oxi_image_magnifier_magnifi_offset_switcher' => 'yes',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 10,
                    ],
                ],
            ]
        );
        $this->add_control(
            'oxi_image_magnifier_offset_y',
            $this->style,
            [
                'label' => __('Offset Y', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'oxi_image_magnifier_magnifi_offset_switcher' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'oxi_image_magnifier_magnifi_switcher',
            $this->style,
            [
                'label' => __('Magnifi Width Height', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SWITCHER,
                'default' => 'no',
                'loader' => true,
                'label_on' => __('Yes', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'label_off' => __('No', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'oxi_image_magnifier_magnifi_width',
            $this->style,
            [
                'label' => __('Width', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'condition' => [
                    'oxi_image_magnifier_magnifi_switcher' => 'yes',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1500,
                        'step' => 10,
                    ],
                ],
            ]
        );
        $this->add_control(
            'oxi_image_magnifier_magnifi_height',
            $this->style,
            [
                'label' => __('Height', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'oxi_image_magnifier_magnifi_switcher' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            'oxi_image_magnifier_magnifi_box_shadow',
            $this->style,
            [
                'label' => __('Box Shadow', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::BOXSHADOW,
                'selector' => [
                    '.oxi_____disabled,  .oxi_addons_magnifier_' . $this->oxiid . ' .image_wrap' => '',
                ],

            ]
        );
        $this->end_controls_section(); 
    }
    public function modal_form_data()
    {
        echo '<div class="modal-header">
                    <h4 class="modal-title">Image Hover Form</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">';

       
        $this->add_group_control(
            'oxi_image_magnifier_img', $this->style, [
                'label' => esc_html__('Media Type', OXI_IMAGE_HOVER_TEXTDOMAIN),
                'type' => Controls::MEDIA,
                'default' => [
                    'type' => 'media-library',
                    'link' => 'https://www.shortcode-addons.com/wp-content/uploads/2020/01/placeholder.png',
                ], 
            ]
        );  
        echo '</div>';
    } 
     

}
