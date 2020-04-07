<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Filter;

/**
 * Description of General
 *
 * @author biplo
 */
use OXI_IMAGE_HOVER_PLUGINS\Page\Create as Create;

class Filter extends Create {

    public function Admin_header() {
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1>Filter & Sorting › Create New</h1>
                <p> Select Image Hover layouts, Gives your Image Hover name and create new Image Hover.</p>
            </div>
        </div>
        <?php
    }

    public function Import_header() {
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1>Filter & Sorting › Import Templates</h1>
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
                                        <h4 class="modal-title">New Filter & Sorting</h4>
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
                                    <?php echo $value['name']; ?>
                                </div>
                                <div class="oxi-addons-style-preview-bottom-right">
                                    <button class="btn btn-warning oxi-addons-addons-style-btn-warning" title="Delete" data-value="<?php echo $id; ?>" data-effects="<?php echo $this->effects; ?>" type="button" value="Deactive" name="styledelete<?php echo $id; ?>">Deactive</button>  
                                    <button type="button" class="btn btn-success oxi-addons-addons-template-create" effects-data="oxistyle<?php echo $id; ?>data">Create Style</button>
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
                                    <?php echo $value['name']; ?>
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
            'filter-1' => [
                'name' => 'Filter & Sortings <span>Simple Filter</span>',
                'files' => [
                    '{"plugin":"image-hover","style":{"id":"156","type":"","name":"a","style_name":"filter-1","rawdata":"{\"category_parent_cat\":\"Image\",\"category_menu_settings\":{\"rep4\":{\"category_item_text\":\"Image\"},\"rep2\":{\"category_item_text\":\"Photo\"},\"rep1\":{\"category_item_text\":\"Filter\"},\"rep3\":{\"category_item_text\":\"Lightbox\"},\"rep5\":{\"category_item_text\":\"Magnifier\"},\"rep7\":{\"category_item_text\":\"Effects\"}},\"category_menu_settingsnm\":\"7\",\"category_col-lap\":\"oxi-bt-col-lg-4\",\"category_col-tab\":\"\",\"category_col-mob\":\"\",\"sa_category_data_item-lap-choices\":\"px\",\"sa_category_data_item-lap-top\":\"\",\"sa_category_data_item-lap-right\":\"\",\"sa_category_data_item-lap-bottom\":\"\",\"sa_category_data_item-lap-left\":\"\",\"sa_category_data_item-tab-choices\":\"px\",\"sa_category_data_item-tab-top\":\"\",\"sa_category_data_item-tab-right\":\"\",\"sa_category_data_item-tab-bottom\":\"\",\"sa_category_data_item-tab-left\":\"\",\"sa_category_data_item-mob-choices\":\"px\",\"sa_category_data_item-mob-top\":\"\",\"sa_category_data_item-mob-right\":\"\",\"sa_category_data_item-mob-bottom\":\"\",\"sa_category_data_item-mob-left\":\"\",\"category_data_body_padding-lap-choices\":\"px\",\"category_data_body_padding-lap-top\":\"10\",\"category_data_body_padding-lap-right\":\"10\",\"category_data_body_padding-lap-bottom\":\"10\",\"category_data_body_padding-lap-left\":\"10\",\"category_data_body_padding-tab-choices\":\"px\",\"category_data_body_padding-tab-top\":\"\",\"category_data_body_padding-tab-right\":\"\",\"category_data_body_padding-tab-bottom\":\"\",\"category_data_body_padding-tab-left\":\"\",\"category_data_body_padding-mob-choices\":\"px\",\"category_data_body_padding-mob-top\":\"\",\"category_data_body_padding-mob-right\":\"\",\"category_data_body_padding-mob-bottom\":\"\",\"category_data_body_padding-mob-left\":\"\",\"category_menu_align\":\"center\",\"category_menu_typo-font\":\"\",\"category_menu_typo-size-lap-choices\":\"px\",\"category_menu_typo-size-lap-size\":\"\",\"category_menu_typo-size-tab-choices\":\"px\",\"category_menu_typo-size-tab-size\":\"\",\"category_menu_typo-size-mob-choices\":\"px\",\"category_menu_typo-size-mob-size\":\"\",\"category_menu_typo-weight\":\"\",\"category_menu_typo-transform\":\"\",\"category_menu_typo-style\":\"\",\"category_menu_typo-decoration\":\"\",\"category_menu_typo-align-lap\":\"\",\"category_menu_typo-align-tab\":\"\",\"category_menu_typo-align-mob\":\"\",\"category_menu_typo-l-height-lap-choices\":\"px\",\"category_menu_typo-l-height-lap-size\":\"\",\"category_menu_typo-l-height-tab-choices\":\"px\",\"category_menu_typo-l-height-tab-size\":\"\",\"category_menu_typo-l-height-mob-choices\":\"px\",\"category_menu_typo-l-height-mob-size\":\"\",\"category_menu_typo-l-spacing-lap-choices\":\"px\",\"category_menu_typo-l-spacing-lap-size\":\"\",\"category_menu_typo-l-spacing-tab-choices\":\"px\",\"category_menu_typo-l-spacing-tab-size\":\"\",\"category_menu_typo-l-spacing-mob-choices\":\"px\",\"category_menu_typo-l-spacing-mob-size\":\"\",\"category_menu_width_type\":\"category_fix_width\",\"category_menu_width_size-lap-choices\":\"%\",\"category_menu_width_size-lap-size\":\"16.4\",\"category_menu_width_size-tab-choices\":\"px\",\"category_menu_width_size-tab-size\":\"120\",\"category_menu_width_size-mob-choices\":\"px\",\"category_menu_width_size-mob-size\":\"120\",\"category_menu_color\":\"#ffffff\",\"category_menu_background\":\"rgba(214, 0, 136, 1)\",\"ategory_menu_border-type\":\"solid\",\"ategory_menu_border-width-lap-choices\":\"px\",\"ategory_menu_border-width-lap-top\":\"\",\"ategory_menu_border-width-lap-right\":\"\",\"ategory_menu_border-width-lap-bottom\":\"\",\"ategory_menu_border-width-lap-left\":\"\",\"ategory_menu_border-width-tab-choices\":\"px\",\"ategory_menu_border-width-tab-top\":\"\",\"ategory_menu_border-width-tab-right\":\"\",\"ategory_menu_border-width-tab-bottom\":\"\",\"ategory_menu_border-width-tab-left\":\"\",\"ategory_menu_border-width-mob-choices\":\"px\",\"ategory_menu_border-width-mob-top\":\"\",\"ategory_menu_border-width-mob-right\":\"\",\"ategory_menu_border-width-mob-bottom\":\"\",\"ategory_menu_border-width-mob-left\":\"\",\"ategory_menu_border-color\":\"\",\"category_menu_shadow-shadow\":\"yes\",\"category_menu_shadow-type\":\"\",\"category_menu_shadow-horizontal-size\":\"0\",\"category_menu_shadow-vertical-size\":\"0\",\"category_menu_shadow-blur-size\":\"0\",\"category_menu_shadow-spread-size\":\"0\",\"category_menu_shadow-color\":\"#cccccc\",\"category_menu_border-radius-lap-choices\":\"px\",\"category_menu_border-radius-lap-top\":\"0\",\"category_menu_border-radius-lap-right\":\"0\",\"category_menu_border-radius-lap-bottom\":\"0\",\"category_menu_border-radius-lap-left\":\"0\",\"category_menu_border-radius-tab-choices\":\"px\",\"category_menu_border-radius-tab-top\":\"\",\"category_menu_border-radius-tab-right\":\"\",\"category_menu_border-radius-tab-bottom\":\"\",\"category_menu_border-radius-tab-left\":\"\",\"category_menu_border-radius-mob-choices\":\"px\",\"category_menu_border-radius-mob-top\":\"\",\"category_menu_border-radius-mob-right\":\"\",\"category_menu_border-radius-mob-bottom\":\"\",\"category_menu_border-radius-mob-left\":\"\",\"category_menu_hover_color\":\"#ffffff\",\"category_menu_hover_background\":\"rgba(71, 201, 229, 1)\",\"category_menu_hover_border-type\":\"\",\"category_menu_hover_border-width-lap-choices\":\"px\",\"category_menu_hover_border-width-lap-top\":\"\",\"category_menu_hover_border-width-lap-right\":\"\",\"category_menu_hover_border-width-lap-bottom\":\"\",\"category_menu_hover_border-width-lap-left\":\"\",\"category_menu_hover_border-width-tab-choices\":\"px\",\"category_menu_hover_border-width-tab-top\":\"\",\"category_menu_hover_border-width-tab-right\":\"\",\"category_menu_hover_border-width-tab-bottom\":\"\",\"category_menu_hover_border-width-tab-left\":\"\",\"category_menu_hover_border-width-mob-choices\":\"px\",\"category_menu_hover_border-width-mob-top\":\"\",\"category_menu_hover_border-width-mob-right\":\"\",\"category_menu_hover_border-width-mob-bottom\":\"\",\"category_menu_hover_border-width-mob-left\":\"\",\"category_menu_hover_border-color\":\"\",\"category_menu_hover_shadow-type\":\"\",\"category_menu_hover_shadow-horizontal-size\":\"0\",\"category_menu_hover_shadow-vertical-size\":\"0\",\"category_menu_hover_shadow-blur-size\":\"0\",\"category_menu_hover_shadow-spread-size\":\"0\",\"category_menu_hover_shadow-color\":\"#cccccc\",\"category_menu_hover_border_radius-lap-choices\":\"px\",\"category_menu_hover_border_radius-lap-top\":\"\",\"category_menu_hover_border_radius-lap-right\":\"\",\"category_menu_hover_border_radius-lap-bottom\":\"\",\"category_menu_hover_border_radius-lap-left\":\"\",\"category_menu_hover_border_radius-tab-choices\":\"px\",\"category_menu_hover_border_radius-tab-top\":\"\",\"category_menu_hover_border_radius-tab-right\":\"\",\"category_menu_hover_border_radius-tab-bottom\":\"\",\"category_menu_hover_border_radius-tab-left\":\"\",\"category_menu_hover_border_radius-mob-choices\":\"px\",\"category_menu_hover_border_radius-mob-top\":\"\",\"category_menu_hover_border_radius-mob-right\":\"\",\"category_menu_hover_border_radius-mob-bottom\":\"\",\"category_menu_hover_border_radius-mob-left\":\"\",\"category_menu_active_color\":\"#ffffff\",\"category_menu_active_background\":\"rgba(101, 0, 179, 1)\",\"category_menu_active_border-type\":\"\",\"category_menu_active_border-width-lap-choices\":\"px\",\"category_menu_active_border-width-lap-top\":\"\",\"category_menu_active_border-width-lap-right\":\"\",\"category_menu_active_border-width-lap-bottom\":\"\",\"category_menu_active_border-width-lap-left\":\"\",\"category_menu_active_border-width-tab-choices\":\"px\",\"category_menu_active_border-width-tab-top\":\"\",\"category_menu_active_border-width-tab-right\":\"\",\"category_menu_active_border-width-tab-bottom\":\"\",\"category_menu_active_border-width-tab-left\":\"\",\"category_menu_active_border-width-mob-choices\":\"px\",\"category_menu_active_border-width-mob-top\":\"\",\"category_menu_active_border-width-mob-right\":\"\",\"category_menu_active_border-width-mob-bottom\":\"\",\"category_menu_active_border-width-mob-left\":\"\",\"category_menu_active_border-color\":\"\",\"category_menu_active_shadow-shadow\":\"yes\",\"category_menu_active_shadow-type\":\"\",\"category_menu_active_shadow-horizontal-size\":\"0\",\"category_menu_active_shadow-vertical-size\":\"0\",\"category_menu_active_shadow-blur-size\":\"0\",\"category_menu_active_shadow-spread-size\":\"0\",\"category_menu_active_shadow-color\":\"#cccccc\",\"category_menu_active_border_radius-lap-choices\":\"px\",\"category_menu_active_border_radius-lap-top\":\"\",\"category_menu_active_border_radius-lap-right\":\"\",\"category_menu_active_border_radius-lap-bottom\":\"\",\"category_menu_active_border_radius-lap-left\":\"\",\"category_menu_active_border_radius-tab-choices\":\"px\",\"category_menu_active_border_radius-tab-top\":\"\",\"category_menu_active_border_radius-tab-right\":\"\",\"category_menu_active_border_radius-tab-bottom\":\"\",\"category_menu_active_border_radius-tab-left\":\"\",\"category_menu_active_border_radius-mob-choices\":\"px\",\"category_menu_active_border_radius-mob-top\":\"\",\"category_menu_active_border_radius-mob-right\":\"\",\"category_menu_active_border_radius-mob-bottom\":\"\",\"category_menu_active_border_radius-mob-left\":\"\",\"category_menu_padding-lap-choices\":\"px\",\"category_menu_padding-lap-top\":\"10\",\"category_menu_padding-lap-right\":\"10\",\"category_menu_padding-lap-bottom\":\"10\",\"category_menu_padding-lap-left\":\"10\",\"category_menu_padding-tab-choices\":\"px\",\"category_menu_padding-tab-top\":\"\",\"category_menu_padding-tab-right\":\"\",\"category_menu_padding-tab-bottom\":\"\",\"category_menu_padding-tab-left\":\"\",\"category_menu_padding-mob-choices\":\"px\",\"category_menu_padding-mob-top\":\"\",\"category_menu_padding-mob-right\":\"\",\"category_menu_padding-mob-bottom\":\"\",\"category_menu_padding-mob-left\":\"\",\"category_menu_margin-lap-choices\":\"px\",\"category_menu_margin-lap-top\":\"0\",\"category_menu_margin-lap-right\":\"0\",\"category_menu_margin-lap-bottom\":\"0\",\"category_menu_margin-lap-left\":\"0\",\"category_menu_margin-tab-choices\":\"px\",\"category_menu_margin-tab-top\":\"\",\"category_menu_margin-tab-right\":\"\",\"category_menu_margin-tab-bottom\":\"\",\"category_menu_margin-tab-left\":\"\",\"category_menu_margin-mob-choices\":\"px\",\"category_menu_margin-mob-top\":\"\",\"category_menu_margin-mob-right\":\"\",\"category_menu_margin-mob-bottom\":\"\",\"category_menu_margin-mob-left\":\"\",\"image-hover-custom-css\":\"\",\"image-hover-preview-color\":\"#FFF\",\"image-hover-style-id\":\"156\",\"image-hover-template\":\"Filter-1\",\"category_menu_hover_shadow-shadow\":\"0\"}","stylesheet":".oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-item-show{padding: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category{padding: 10px 10px 10px 10px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu{justify-content: center;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item.category_fix_width{width: 16.4%;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item{color: #ffffff;background: rgba(214, 0, 136, 1);border-style: solid;border-width: px px px px;border-color: ;border-radius: 0px 0px 0px 0px;padding: 10px 10px 10px 10px;margin: 0px 0px 0px 0px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item:hover{color: #ffffff;background: rgba(71, 201, 229, 1);border-radius: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item.oxi_active{color: #ffffff;background: rgba(101, 0, 179, 1);border-radius: px px px px;}@media only screen and (min-width : 669px) and (max-width : 993px){.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-item-show{padding: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category{padding: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item.category_fix_width{width: 120px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item{border-width: px px px px;border-radius: px px px px;padding: px px px px;margin: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item:hover{border-radius: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item.oxi_active{border-radius: px px px px;}}@media only screen and (max-width : 668px){.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-item-show{padding: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category{padding: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item.category_fix_width{width: 120px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item{border-width: px px px px;border-radius: px px px px;padding: px px px px;margin: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item:hover{border-radius: px px px px;}.oxi-image-hover-wrapper-156 .image-hover-filter-style-1 .image-hover-category-menu-item.oxi_active{border-radius: px px px px;}}","font_family":"[]"},"child":[]}',
                ],
            ],
            'filter-2' => [
                'name' => 'Filter & Sortings <span>Multiple Width</span>',
                'files' => [
                    '{"plugin":"image-hover","style":{"id":"157","type":"","name":"","style_name":"filter-2","rawdata":"{\"category_parent_cat\":\"Image\",\"category_menu_settings\":{\"rep4\":{\"category_item_text\":\"Image\"},\"rep2\":{\"category_item_text\":\"Photo\"},\"rep1\":{\"category_item_text\":\"Filter\"},\"rep3\":{\"category_item_text\":\"Lightbox\"},\"rep5\":{\"category_item_text\":\"Magnifier\"},\"rep7\":{\"category_item_text\":\"Effects\"}},\"category_menu_settingsnm\":\"7\",\"category_col-lap\":\"oxi-bt-col-lg-4\",\"category_col-tab\":\"\",\"category_col-mob\":\"\",\"sa_category_data_item-lap-choices\":\"px\",\"sa_category_data_item-lap-top\":\"\",\"sa_category_data_item-lap-right\":\"\",\"sa_category_data_item-lap-bottom\":\"\",\"sa_category_data_item-lap-left\":\"\",\"sa_category_data_item-tab-choices\":\"px\",\"sa_category_data_item-tab-top\":\"\",\"sa_category_data_item-tab-right\":\"\",\"sa_category_data_item-tab-bottom\":\"\",\"sa_category_data_item-tab-left\":\"\",\"sa_category_data_item-mob-choices\":\"px\",\"sa_category_data_item-mob-top\":\"\",\"sa_category_data_item-mob-right\":\"\",\"sa_category_data_item-mob-bottom\":\"\",\"sa_category_data_item-mob-left\":\"\",\"category_data_body_padding-lap-choices\":\"px\",\"category_data_body_padding-lap-top\":\"10\",\"category_data_body_padding-lap-right\":\"10\",\"category_data_body_padding-lap-bottom\":\"10\",\"category_data_body_padding-lap-left\":\"10\",\"category_data_body_padding-tab-choices\":\"px\",\"category_data_body_padding-tab-top\":\"\",\"category_data_body_padding-tab-right\":\"\",\"category_data_body_padding-tab-bottom\":\"\",\"category_data_body_padding-tab-left\":\"\",\"category_data_body_padding-mob-choices\":\"px\",\"category_data_body_padding-mob-top\":\"\",\"category_data_body_padding-mob-right\":\"\",\"category_data_body_padding-mob-bottom\":\"\",\"category_data_body_padding-mob-left\":\"\",\"category_menu_align\":\"center\",\"category_menu_typo-font\":\"\",\"category_menu_typo-size-lap-choices\":\"px\",\"category_menu_typo-size-lap-size\":\"\",\"category_menu_typo-size-tab-choices\":\"px\",\"category_menu_typo-size-tab-size\":\"\",\"category_menu_typo-size-mob-choices\":\"px\",\"category_menu_typo-size-mob-size\":\"\",\"category_menu_typo-weight\":\"\",\"category_menu_typo-transform\":\"\",\"category_menu_typo-style\":\"\",\"category_menu_typo-decoration\":\"\",\"category_menu_typo-align-lap\":\"\",\"category_menu_typo-align-tab\":\"\",\"category_menu_typo-align-mob\":\"\",\"category_menu_typo-l-height-lap-choices\":\"px\",\"category_menu_typo-l-height-lap-size\":\"\",\"category_menu_typo-l-height-tab-choices\":\"px\",\"category_menu_typo-l-height-tab-size\":\"\",\"category_menu_typo-l-height-mob-choices\":\"px\",\"category_menu_typo-l-height-mob-size\":\"\",\"category_menu_typo-l-spacing-lap-choices\":\"px\",\"category_menu_typo-l-spacing-lap-size\":\"\",\"category_menu_typo-l-spacing-tab-choices\":\"px\",\"category_menu_typo-l-spacing-tab-size\":\"\",\"category_menu_typo-l-spacing-mob-choices\":\"px\",\"category_menu_typo-l-spacing-mob-size\":\"\",\"category_menu_width_type\":\"category_fix_width\",\"category_menu_width_size-lap-choices\":\"%\",\"category_menu_width_size-lap-size\":\"16.3\",\"category_menu_width_size-tab-choices\":\"px\",\"category_menu_width_size-tab-size\":\"120\",\"category_menu_width_size-mob-choices\":\"px\",\"category_menu_width_size-mob-size\":\"120\",\"category_menu_color\":\"#ffffff\",\"category_menu_background\":\"rgba(214, 0, 136, 1)\",\"ategory_menu_border-type\":\"solid\",\"ategory_menu_border-width-lap-choices\":\"px\",\"ategory_menu_border-width-lap-top\":\"\",\"ategory_menu_border-width-lap-right\":\"\",\"ategory_menu_border-width-lap-bottom\":\"\",\"ategory_menu_border-width-lap-left\":\"\",\"ategory_menu_border-width-tab-choices\":\"px\",\"ategory_menu_border-width-tab-top\":\"\",\"ategory_menu_border-width-tab-right\":\"\",\"ategory_menu_border-width-tab-bottom\":\"\",\"ategory_menu_border-width-tab-left\":\"\",\"ategory_menu_border-width-mob-choices\":\"px\",\"ategory_menu_border-width-mob-top\":\"\",\"ategory_menu_border-width-mob-right\":\"\",\"ategory_menu_border-width-mob-bottom\":\"\",\"ategory_menu_border-width-mob-left\":\"\",\"ategory_menu_border-color\":\"\",\"category_menu_shadow-shadow\":\"yes\",\"category_menu_shadow-type\":\"\",\"category_menu_shadow-horizontal-size\":\"0\",\"category_menu_shadow-vertical-size\":\"0\",\"category_menu_shadow-blur-size\":\"0\",\"category_menu_shadow-spread-size\":\"0\",\"category_menu_shadow-color\":\"#cccccc\",\"category_menu_border-radius-lap-choices\":\"px\",\"category_menu_border-radius-lap-top\":\"0\",\"category_menu_border-radius-lap-right\":\"0\",\"category_menu_border-radius-lap-bottom\":\"0\",\"category_menu_border-radius-lap-left\":\"0\",\"category_menu_border-radius-tab-choices\":\"px\",\"category_menu_border-radius-tab-top\":\"\",\"category_menu_border-radius-tab-right\":\"\",\"category_menu_border-radius-tab-bottom\":\"\",\"category_menu_border-radius-tab-left\":\"\",\"category_menu_border-radius-mob-choices\":\"px\",\"category_menu_border-radius-mob-top\":\"\",\"category_menu_border-radius-mob-right\":\"\",\"category_menu_border-radius-mob-bottom\":\"\",\"category_menu_border-radius-mob-left\":\"\",\"category_menu_hover_color\":\"#ffffff\",\"category_menu_hover_background\":\"rgba(71, 201, 229, 1)\",\"category_menu_hover_border-type\":\"\",\"category_menu_hover_border-width-lap-choices\":\"px\",\"category_menu_hover_border-width-lap-top\":\"\",\"category_menu_hover_border-width-lap-right\":\"\",\"category_menu_hover_border-width-lap-bottom\":\"\",\"category_menu_hover_border-width-lap-left\":\"\",\"category_menu_hover_border-width-tab-choices\":\"px\",\"category_menu_hover_border-width-tab-top\":\"\",\"category_menu_hover_border-width-tab-right\":\"\",\"category_menu_hover_border-width-tab-bottom\":\"\",\"category_menu_hover_border-width-tab-left\":\"\",\"category_menu_hover_border-width-mob-choices\":\"px\",\"category_menu_hover_border-width-mob-top\":\"\",\"category_menu_hover_border-width-mob-right\":\"\",\"category_menu_hover_border-width-mob-bottom\":\"\",\"category_menu_hover_border-width-mob-left\":\"\",\"category_menu_hover_border-color\":\"\",\"category_menu_hover_shadow-type\":\"\",\"category_menu_hover_shadow-horizontal-size\":\"0\",\"category_menu_hover_shadow-vertical-size\":\"0\",\"category_menu_hover_shadow-blur-size\":\"0\",\"category_menu_hover_shadow-spread-size\":\"0\",\"category_menu_hover_shadow-color\":\"#cccccc\",\"category_menu_hover_border_radius-lap-choices\":\"px\",\"category_menu_hover_border_radius-lap-top\":\"\",\"category_menu_hover_border_radius-lap-right\":\"\",\"category_menu_hover_border_radius-lap-bottom\":\"\",\"category_menu_hover_border_radius-lap-left\":\"\",\"category_menu_hover_border_radius-tab-choices\":\"px\",\"category_menu_hover_border_radius-tab-top\":\"\",\"category_menu_hover_border_radius-tab-right\":\"\",\"category_menu_hover_border_radius-tab-bottom\":\"\",\"category_menu_hover_border_radius-tab-left\":\"\",\"category_menu_hover_border_radius-mob-choices\":\"px\",\"category_menu_hover_border_radius-mob-top\":\"\",\"category_menu_hover_border_radius-mob-right\":\"\",\"category_menu_hover_border_radius-mob-bottom\":\"\",\"category_menu_hover_border_radius-mob-left\":\"\",\"category_menu_active_color\":\"#ffffff\",\"category_menu_active_background\":\"rgba(101, 0, 179, 1)\",\"category_menu_active_border-type\":\"\",\"category_menu_active_border-width-lap-choices\":\"px\",\"category_menu_active_border-width-lap-top\":\"\",\"category_menu_active_border-width-lap-right\":\"\",\"category_menu_active_border-width-lap-bottom\":\"\",\"category_menu_active_border-width-lap-left\":\"\",\"category_menu_active_border-width-tab-choices\":\"px\",\"category_menu_active_border-width-tab-top\":\"\",\"category_menu_active_border-width-tab-right\":\"\",\"category_menu_active_border-width-tab-bottom\":\"\",\"category_menu_active_border-width-tab-left\":\"\",\"category_menu_active_border-width-mob-choices\":\"px\",\"category_menu_active_border-width-mob-top\":\"\",\"category_menu_active_border-width-mob-right\":\"\",\"category_menu_active_border-width-mob-bottom\":\"\",\"category_menu_active_border-width-mob-left\":\"\",\"category_menu_active_border-color\":\"\",\"category_menu_active_shadow-shadow\":\"yes\",\"category_menu_active_shadow-type\":\"\",\"category_menu_active_shadow-horizontal-size\":\"0\",\"category_menu_active_shadow-vertical-size\":\"0\",\"category_menu_active_shadow-blur-size\":\"0\",\"category_menu_active_shadow-spread-size\":\"0\",\"category_menu_active_shadow-color\":\"#cccccc\",\"category_menu_active_border_radius-lap-choices\":\"px\",\"category_menu_active_border_radius-lap-top\":\"\",\"category_menu_active_border_radius-lap-right\":\"\",\"category_menu_active_border_radius-lap-bottom\":\"\",\"category_menu_active_border_radius-lap-left\":\"\",\"category_menu_active_border_radius-tab-choices\":\"px\",\"category_menu_active_border_radius-tab-top\":\"\",\"category_menu_active_border_radius-tab-right\":\"\",\"category_menu_active_border_radius-tab-bottom\":\"\",\"category_menu_active_border_radius-tab-left\":\"\",\"category_menu_active_border_radius-mob-choices\":\"px\",\"category_menu_active_border_radius-mob-top\":\"\",\"category_menu_active_border_radius-mob-right\":\"\",\"category_menu_active_border_radius-mob-bottom\":\"\",\"category_menu_active_border_radius-mob-left\":\"\",\"category_menu_padding-lap-choices\":\"px\",\"category_menu_padding-lap-top\":\"10\",\"category_menu_padding-lap-right\":\"10\",\"category_menu_padding-lap-bottom\":\"10\",\"category_menu_padding-lap-left\":\"10\",\"category_menu_padding-tab-choices\":\"px\",\"category_menu_padding-tab-top\":\"\",\"category_menu_padding-tab-right\":\"\",\"category_menu_padding-tab-bottom\":\"\",\"category_menu_padding-tab-left\":\"\",\"category_menu_padding-mob-choices\":\"px\",\"category_menu_padding-mob-top\":\"\",\"category_menu_padding-mob-right\":\"\",\"category_menu_padding-mob-bottom\":\"\",\"category_menu_padding-mob-left\":\"\",\"category_menu_margin-lap-choices\":\"px\",\"category_menu_margin-lap-top\":\"0\",\"category_menu_margin-lap-right\":\"0\",\"category_menu_margin-lap-bottom\":\"0\",\"category_menu_margin-lap-left\":\"0\",\"category_menu_margin-tab-choices\":\"px\",\"category_menu_margin-tab-top\":\"\",\"category_menu_margin-tab-right\":\"\",\"category_menu_margin-tab-bottom\":\"\",\"category_menu_margin-tab-left\":\"\",\"category_menu_margin-mob-choices\":\"px\",\"category_menu_margin-mob-top\":\"\",\"category_menu_margin-mob-right\":\"\",\"category_menu_margin-mob-bottom\":\"\",\"category_menu_margin-mob-left\":\"\",\"image-hover-custom-css\":\"\",\"image-hover-preview-color\":\"#FFF\",\"image-hover-style-id\":\"157\",\"image-hover-template\":\"Filter-2\",\"category_menu_hover_shadow-shadow\":\"0\"}","stylesheet":".oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-item-show{padding: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category{padding: 10px 10px 10px 10px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu{justify-content: center;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item.category_fix_width{width: 16.3%;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item{color: #ffffff;background: rgba(214, 0, 136, 1);border-style: solid;border-width: px px px px;border-color: ;border-radius: 0px 0px 0px 0px;padding: 10px 10px 10px 10px;margin: 0px 0px 0px 0px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item:hover{color: #ffffff;background: rgba(71, 201, 229, 1);border-radius: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item.oxi_active{color: #ffffff;background: rgba(101, 0, 179, 1);border-radius: px px px px;}@media only screen and (min-width : 669px) and (max-width : 993px){.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-item-show{padding: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category{padding: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item.category_fix_width{width: 120px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item{border-width: px px px px;border-radius: px px px px;padding: px px px px;margin: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item:hover{border-radius: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item.oxi_active{border-radius: px px px px;}}@media only screen and (max-width : 668px){.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-item-show{padding: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category{padding: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item.category_fix_width{width: 120px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item{border-width: px px px px;border-radius: px px px px;padding: px px px px;margin: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item:hover{border-radius: px px px px;}.oxi-image-hover-wrapper-157 .image-hover-filter-style .image-hover-category-menu-item.oxi_active{border-radius: px px px px;}}","font_family":"[]"},"child":[]}',
                ],
            ],
        ];
        $this->pre_active = [
            'filter-1',
        ];
    }

}
