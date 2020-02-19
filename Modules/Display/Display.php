<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Display;

/**
 * Description of General
 *
 * @author biplo
 */
use OXI_IMAGE_HOVER_PLUGINS\Page\Create as Create;

class Display extends Create {

    public function Admin_header() {
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1>Display Post › Create New</h1>
                <p> Select Image Hover layouts, Gives your Image Hover name and create new Image Hover.</p>
            </div>
        </div>
        <?php
    }

    public function Import_header() {
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1>Display Post › Import Templates</h1>
                <p> Select Image Hover layouts, Import Templates for future Use.</p>
            </div>
        </div>
        <?php
    }

    public function create_new() {
        echo __('<div class="modal fade" id="oxi-addons-style-create-modal" >
                        <form method="post" id="oxi-addons-style-modal-form">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">                    
                                        <h4 class="modal-title">New Display Post</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class=" form-group row">
                                            <label for="addons-style-name" class="col-sm-6 col-form-label" oxi-addons-tooltip="Give your Shortcode Name Here">Name</label>
                                            <div class="col-sm-6 addons-dtm-laptop-lock">
                                                <input class="form-control" type="text" value="" id="style-name"  name="style-name">
                                            </div>
                                        </div>
                                        <div class="form-group row d-none">
                                            <label for="oxi-tabs-link" class="col-sm-5 col-form-label" title="Select Layouts">Layouts</label>
                                            <div class="col-sm-7">
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-secondary active">
                                                        <input type="radio" name="image-hover-box-layouts"value="1"  checked="">1st
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" id="oxistyledata" name="oxistyledata" value="">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-success" name="addonsdatasubmit" id="addonsdatasubmit" value="Save">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>');
    }

    public function template() {
        ?>
        <div class="oxi-addons-row">
            <?php
            $importbutton = false;
            foreach ($this->TEMPLATE as $key => $value) {
                $id = explode('-', $key)[1];
                if (array_key_exists($key, $this->activated_template)):
                    ?>
                    <div class="oxi-addons-col-1" id="<?php echo $key; ?>">
                        <div class="oxi-addons-style-preview">
                            <div class="oxi-addons-style-preview-top oxi-addons-center">
                                <?php
                                $i = 1;
                                foreach ($value['files'] as $v) {
                                    $style = json_decode($v, true);
                                    $s = explode('-', $style['style']['style_name']);
                                    echo '<div class="oxi-bt-col-lg-12 oxi-bt-col-md-12 oxi-bt-col-sm-12">';
                                    $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Render\Effects' . $s[1];
                                    if (class_exists($CLASS)):
                                        new $CLASS($style['style'], $style['child']);
                                    endif;
                                    echo '<textarea style="display:none" id="oxistyle' . $id . 'data-' . $i . '">' . htmlentities(json_encode($style)) . '</textarea>';
                                    echo '</div>';
                                    $i++;
                                }
                                ?>
                            </div>
                            <div class="oxi-addons-style-preview-bottom">
                                <div class="oxi-addons-style-preview-bottom-left">

                                </div>
                                <div class="oxi-addons-style-preview-bottom-right">
                                    <button class="btn btn-warning oxi-addons-addons-style-btn-warning" title="Delete" data-value="<?php echo $id; ?>" data-effects="<?php echo $this->effects; ?>" type="button" value="Deactive" name="styledelete<?php echo $id; ?>">Deactive</button>  
                                    <button type="button" class="btn btn-success oxi-addons-addons-template-create" effects-data="oxistyle<?php echo $id; ?>data">Create Post Extension</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                else:
                    $importbutton = true;
                endif;
            }

            if ($importbutton):
                ?>
                <div class="oxi-addons-col-1 oxi-import">
                    <div class="oxi-addons-style-preview">
                        <div class="oxilab-admin-style-preview-top">
                            <a href="<?php echo admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$this->effects&import=templates"); ?>">
                                <div class="oxilab-admin-add-new-item">
                                    <span>
                                        <i class="fas fa-plus-circle oxi-icons"></i>  
                                        Add More Templates
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            endif;
            ?>


        </div>
        <?php
    }

    public function import_template() {
        ?>
        <div class="oxi-addons-row">
            <?php
            foreach ($this->TEMPLATE as $key => $value) {
                $id = explode('-', $key)[1];
                if (!array_key_exists($key, $this->activated_template)):
                    ?>
                    <div class="oxi-addons-col-1" id="<?php echo $key; ?>">
                        <div class="oxi-addons-style-preview">
                            <div class="oxi-addons-style-preview-top oxi-addons-center">
                                <?php
                                $i = 1;
                                foreach ($value['files'] as $v) {
                                    $style = json_decode($v, true);
                                    $s = explode('-', $style['style']['style_name']);
                                    echo '<div class="oxi-bt-col-lg-12 oxi-bt-col-md-12 oxi-bt-col-sm-12">';
                                    $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Render\Effects' . $s[1];
                                    if (class_exists($CLASS)):
                                        new $CLASS($style['style'], $style['child']);
                                    endif;
                                    echo '</div>';
                                    $i++;
                                }
                                ?>
                            </div>
                            <div class="oxi-addons-style-preview-bottom">
                                <div class="oxi-addons-style-preview-bottom-left">

                                </div>
                                <div class="oxi-addons-style-preview-bottom-right">
                                    <?php
                                    if (apply_filters('oxi-image-hover-plugin-version', false) == true || array_key_exists($key, $this->pre_clecked)):
                                        ?>
                                        <button class="btn btn-success oxi-addons-addons-style-btn-active" title="Active Templates" data-value="<?php echo $id; ?>" data-effects="<?php echo $this->effects; ?>" type="button" value="Active" name="styleactive<?php echo $id; ?>">Active Templates</button>  
                                        <?php
                                    else:
                                        ?>
                                        <button class="btn btn-danger" title="Premium Templates"  type="button" value="Premium Templates" name="styleactive<?php echo $id; ?>">Premium Templates</button>  
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endif;
            }
            ?>
        </div>
        <?php
    }

    public function JSON_DATA() {
        $this->TEMPLATE = [
            'display-1' => [
                'name' => 'Display Post <span>General, Square & Caption effects Extension</span>',
                'files' => [
                    '{"plugin":"image-hover","style":{"id":"159","type":"","name":"as","style_name":"display-1","rawdata":"{\"display_post_post_type\":\"post\",\"display_post_style\":\"\",\"display_post_per_page\":\"8\",\"display_post_excerpt\":\"10\",\"display_post_offset\":\"1\",\"display_post_orderby\":\"ID\",\"display_post_ordertype\":\"asc\",\"display_post_thumb_sizes\":\"medium_large\",\"display_post_load_more_type\":\"infinite\",\"display_post_load_button_text\":\"Load More\",\"display_post_load_button_position\":\"center\",\"display_post_load_button_typho-font\":\"\",\"display_post_load_button_typho-size-lap-choices\":\"px\",\"display_post_load_button_typho-size-lap-size\":\"\",\"display_post_load_button_typho-size-tab-choices\":\"px\",\"display_post_load_button_typho-size-tab-size\":\"\",\"display_post_load_button_typho-size-mob-choices\":\"px\",\"display_post_load_button_typho-size-mob-size\":\"\",\"display_post_load_button_typho-weight\":\"\",\"display_post_load_button_typho-transform\":\"\",\"display_post_load_button_typho-style\":\"\",\"display_post_load_button_typho-decoration\":\"\",\"display_post_load_button_typho-l-height-lap-choices\":\"px\",\"display_post_load_button_typho-l-height-lap-size\":\"\",\"display_post_load_button_typho-l-height-tab-choices\":\"px\",\"display_post_load_button_typho-l-height-tab-size\":\"\",\"display_post_load_button_typho-l-height-mob-choices\":\"px\",\"display_post_load_button_typho-l-height-mob-size\":\"\",\"display_post_load_button_typho-l-spacing-lap-choices\":\"px\",\"display_post_load_button_typho-l-spacing-lap-size\":\"\",\"display_post_load_button_typho-l-spacing-tab-choices\":\"px\",\"display_post_load_button_typho-l-spacing-tab-size\":\"\",\"display_post_load_button_typho-l-spacing-mob-choices\":\"px\",\"display_post_load_button_typho-l-spacing-mob-size\":\"\",\"display_post_load_button_color\":\"#ffffff\",\"display_post_load_button_background\":\"rgba(171, 0, 201, 1)\",\"display_post_load_button_border-type\":\"\",\"display_post_load_button_border-width-lap-choices\":\"px\",\"display_post_load_button_border-width-lap-top\":\"\",\"display_post_load_button_border-width-lap-right\":\"\",\"display_post_load_button_border-width-lap-bottom\":\"\",\"display_post_load_button_border-width-lap-left\":\"\",\"display_post_load_button_border-width-tab-choices\":\"px\",\"display_post_load_button_border-width-tab-top\":\"\",\"display_post_load_button_border-width-tab-right\":\"\",\"display_post_load_button_border-width-tab-bottom\":\"\",\"display_post_load_button_border-width-tab-left\":\"\",\"display_post_load_button_border-width-mob-choices\":\"px\",\"display_post_load_button_border-width-mob-top\":\"\",\"display_post_load_button_border-width-mob-right\":\"\",\"display_post_load_button_border-width-mob-bottom\":\"\",\"display_post_load_button_border-width-mob-left\":\"\",\"display_post_load_button_border-color\":\"\",\"display_post_load_button_tx_shadow-color\":\"#ffffff\",\"display_post_load_button_tx_shadow-blur-size\":\"0\",\"display_post_load_button_tx_shadow-horizontal-size\":\"0\",\"display_post_load_button_tx_shadow-vertical-size\":\"0\",\"display_post_load_button_radius-lap-choices\":\"px\",\"display_post_load_button_radius-lap-top\":\"\",\"display_post_load_button_radius-lap-right\":\"\",\"display_post_load_button_radius-lap-bottom\":\"\",\"display_post_load_button_radius-lap-left\":\"\",\"display_post_load_button_radius-tab-choices\":\"px\",\"display_post_load_button_radius-tab-top\":\"\",\"display_post_load_button_radius-tab-right\":\"\",\"display_post_load_button_radius-tab-bottom\":\"\",\"display_post_load_button_radius-tab-left\":\"\",\"display_post_load_button_radius-mob-choices\":\"px\",\"display_post_load_button_radius-mob-top\":\"\",\"display_post_load_button_radius-mob-right\":\"\",\"display_post_load_button_radius-mob-bottom\":\"\",\"display_post_load_button_radius-mob-left\":\"\",\"display_post_load_button_boxshadow-shadow\":\"yes\",\"display_post_load_button_boxshadow-type\":\"\",\"display_post_load_button_boxshadow-horizontal-size\":\"0\",\"display_post_load_button_boxshadow-vertical-size\":\"0\",\"display_post_load_button_boxshadow-blur-size\":\"0\",\"display_post_load_button_boxshadow-spread-size\":\"0\",\"display_post_load_button_boxshadow-color\":\"#cccccc\",\"display_post_load_button_hover_color\":\"#ffffff\",\"display_post_load_button_hover_background\":\"rgba(139,0,189,1.00)\",\"display_post_load_button_hover_border-type\":\"\",\"display_post_load_button_hover_border-width-lap-choices\":\"px\",\"display_post_load_button_hover_border-width-lap-top\":\"\",\"display_post_load_button_hover_border-width-lap-right\":\"\",\"display_post_load_button_hover_border-width-lap-bottom\":\"\",\"display_post_load_button_hover_border-width-lap-left\":\"\",\"display_post_load_button_hover_border-width-tab-choices\":\"px\",\"display_post_load_button_hover_border-width-tab-top\":\"\",\"display_post_load_button_hover_border-width-tab-right\":\"\",\"display_post_load_button_hover_border-width-tab-bottom\":\"\",\"display_post_load_button_hover_border-width-tab-left\":\"\",\"display_post_load_button_hover_border-width-mob-choices\":\"px\",\"display_post_load_button_hover_border-width-mob-top\":\"\",\"display_post_load_button_hover_border-width-mob-right\":\"\",\"display_post_load_button_hover_border-width-mob-bottom\":\"\",\"display_post_load_button_hover_border-width-mob-left\":\"\",\"display_post_load_button_hover_border-color\":\"\",\"display_post_load_button_hover_tx_shadow-color\":\"#ffffff\",\"display_post_load_button_hover_tx_shadow-blur-size\":\"0\",\"display_post_load_button_hover_tx_shadow-horizontal-size\":\"0\",\"display_post_load_button_hover_tx_shadow-vertical-size\":\"0\",\"display_post_load_button_hover_radius-lap-choices\":\"px\",\"display_post_load_button_hover_radius-lap-top\":\"\",\"display_post_load_button_hover_radius-lap-right\":\"\",\"display_post_load_button_hover_radius-lap-bottom\":\"\",\"display_post_load_button_hover_radius-lap-left\":\"\",\"display_post_load_button_hover_radius-tab-choices\":\"px\",\"display_post_load_button_hover_radius-tab-top\":\"\",\"display_post_load_button_hover_radius-tab-right\":\"\",\"display_post_load_button_hover_radius-tab-bottom\":\"\",\"display_post_load_button_hover_radius-tab-left\":\"\",\"display_post_load_button_hover_radius-mob-choices\":\"px\",\"display_post_load_button_hover_radius-mob-top\":\"\",\"display_post_load_button_hover_radius-mob-right\":\"\",\"display_post_load_button_hover_radius-mob-bottom\":\"\",\"display_post_load_button_hover_radius-mob-left\":\"\",\"display_post_load_button_button_boxshadow-shadow\":\"yes\",\"display_post_load_button_button_boxshadow-type\":\"\",\"display_post_load_button_button_boxshadow-horizontal-size\":\"0\",\"display_post_load_button_button_boxshadow-vertical-size\":\"0\",\"display_post_load_button_button_boxshadow-blur-size\":\"0\",\"display_post_load_button_button_boxshadow-spread-size\":\"0\",\"display_post_load_button_button_boxshadow-color\":\"#cccccc\",\"display_post_load_button_button_padding-lap-choices\":\"px\",\"display_post_load_button_button_padding-lap-top\":\"\",\"display_post_load_button_button_padding-lap-right\":\"\",\"display_post_load_button_button_padding-lap-bottom\":\"\",\"display_post_load_button_button_padding-lap-left\":\"\",\"display_post_load_button_button_padding-tab-choices\":\"px\",\"display_post_load_button_button_padding-tab-top\":\"\",\"display_post_load_button_button_padding-tab-right\":\"\",\"display_post_load_button_button_padding-tab-bottom\":\"\",\"display_post_load_button_button_padding-tab-left\":\"\",\"display_post_load_button_button_padding-mob-choices\":\"px\",\"display_post_load_button_button_padding-mob-top\":\"\",\"display_post_load_button_button_padding-mob-right\":\"\",\"display_post_load_button_button_padding-mob-bottom\":\"\",\"display_post_load_button_button_padding-mob-left\":\"\",\"display_post_load_button_button_margin-lap-choices\":\"px\",\"display_post_load_button_button_margin-lap-top\":\"\",\"display_post_load_button_button_margin-lap-right\":\"\",\"display_post_load_button_button_margin-lap-bottom\":\"\",\"display_post_load_button_button_margin-lap-left\":\"\",\"display_post_load_button_button_margin-tab-choices\":\"px\",\"display_post_load_button_button_margin-tab-top\":\"\",\"display_post_load_button_button_margin-tab-right\":\"\",\"display_post_load_button_button_margin-tab-bottom\":\"\",\"display_post_load_button_button_margin-tab-left\":\"\",\"display_post_load_button_button_margin-mob-choices\":\"px\",\"display_post_load_button_button_margin-mob-top\":\"\",\"display_post_load_button_button_margin-mob-right\":\"\",\"display_post_load_button_button_margin-mob-bottom\":\"\",\"display_post_load_button_button_margin-mob-left\":\"\",\"image-hover-custom-css\":\"\",\"image-hover-preview-color\":\"#FFF\",\"image-hover-style-id\":\"159\",\"image-hover-template\":\"Display-1\",\"display_post_load_more\":\"0\"}","stylesheet":".oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap{text-align:center;padding:px px px px;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button{color: #ffffff;background: rgba(171, 0, 201, 1);border-radius:px px px px;padding:px px px px;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button .oxi-image-hover-loader button__loader{color: #ffffff;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button span{color: #ffffff;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover{color: #ffffff;background: rgba(171, 0, 201, 1);border-radius:px px px px;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover .oxi-image-hover-loader button__loader{color: #ffffff;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover span{color: #ffffff;}.oxi-image-hover-wrapper-159 .oxi-addons-row .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover{color: #ffffff;background: rgba(139,0,189,1.00);border-radius:px px px px;}.oxi-image-hover-wrapper-159 .oxi-addons-row .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover .oxi-image-hover-loader button__loader{color: #ffffff;}.oxi-image-hover-wrapper-159 .oxi-addons-row .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover span{color: #ffffff;}@media only screen and (min-width : 669px) and (max-width : 993px){.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button{border-radius:px px px px;padding:px px px px;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover{border-radius:px px px px;}.oxi-image-hover-wrapper-159 .oxi-addons-row .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover{border-radius:px px px px;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap{padding:px px px px;}}@media only screen and (max-width : 668px){.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button{border-radius:px px px px;padding:px px px px;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover{border-radius:px px px px;}.oxi-image-hover-wrapper-159 .oxi-addons-row .oxi-image-hover-load-more-button-wrap .oxi-image-load-more-button:hover{border-radius:px px px px;}.oxi-image-hover-wrapper-159 .oxi-image-hover-load-more-button-wrap{padding:px px px px;}}","font_family":"[]"},"child":[{"id":"324","styleid":"159","rawdata":"{\"oxi_image_comparison_image_one-select\":\"media-library\",\"oxi_image_comparison_image_one-image\":\"https:\\\/\\\/www.image-hover.oxilab.org\\\/wp-content\\\/uploads\\\/2020\\\/02\\\/pexels-photo-210019.png\",\"oxi_image_comparison_image_one-image-alt\":\"\",\"oxi_image_comparison_image_one-url\":\"https:\\\/\\\/www.shortcode-addons.com\\\/wp-content\\\/uploads\\\/2020\\\/01\\\/placeholder.png\",\"oxi_image_comparison_image_two-select\":\"media-library\",\"oxi_image_comparison_image_two-image\":\"https:\\\/\\\/www.image-hover.oxilab.org\\\/wp-content\\\/uploads\\\/2020\\\/02\\\/pexels-photo-210019-1.png\",\"oxi_image_comparison_image_two-image-alt\":\"\",\"oxi_image_comparison_image_two-url\":\"https:\\\/\\\/www.shortcode-addons.com\\\/wp-content\\\/uploads\\\/2020\\\/01\\\/placeholder.png\",\"oxi_image_comparison_body_offset-size\":\"0.5\",\"oxi_image_comparison_click\":\"false\",\"oxi_image_comparison_position\":\"true\",\"oxi_image_comparison_hover\":\"false\",\"shortcodeitemid\":\"19\"}"}]}',
                ],
            ],
        ];
        $this->pre_active = [
            'display-1',
        ];
    }

}
