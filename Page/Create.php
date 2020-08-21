<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Page;

/**
 * Description of Create
 *
 * @author $biplob018
 */
class Create {

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
    public $child_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $import_table;

    /**
     * Define $wpdb
     *
     * @since 9.3.0
     */
    public $wpdb;

    /**
     * Define $wpdb
     *
     * @since 9.3.0
     */
    public $effects;

    /**
     * Define $wpdb
     *
     * @since 9.3.0
     */
    public $oxitype;
    public $TEMPLATE = [];
    public $pre_active = [];
    public $pre_clecked = [];
    public $activated_template = [];

    use \OXI_IMAGE_HOVER_PLUGINS\Helper\Public_Helper;
    use \OXI_IMAGE_HOVER_PLUGINS\Helper\CSS_JS_Loader;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
        $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
        $this->import_table = $this->wpdb->prefix . 'oxi_div_import';
        $this->effects = (!empty($_GET['effects']) ? sanitize_text_field($_GET['effects']) : '');
        $this->oxitype = $this->effects . '-ultimate';
        $this->CSSJS_load();
        $this->Render();
    }

    public function CSSJS_load() {
        $this->JSON_DATA();
        $this->pre_clecked = array_flip($this->pre_active);
        $this->admin_css_loader();
        $this->admin_rest_api();
        $this->pre_active_check();
        apply_filters('oxi-image-hover-plugin/admin_menu', TRUE);
    }

    /**
     * Image Hover Ultimate Pre Active Check.
     *
     * @since 9.3.0
     */
    public function pre_active_check() {
        $template = $this->wpdb->get_results("SELECT * FROM  $this->import_table WHERE type = '$this->oxitype' ORDER BY id DESC", ARRAY_A);
        if (count($template) < 1):
            foreach ($this->pre_active as $value) {
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->import_table} (type, name) VALUES (%s, %s)", array($this->oxitype, $value)));
            }

            $this->activated_template = $this->pre_clecked;
        else:
            foreach ($template as $value) {
                $this->activated_template[$value['name']] = $value['name'];
            }
        endif;
    }

    /**
     * Admin Notice JS file loader
     * @return void
     */
    public function admin_rest_api() {
        wp_enqueue_script('oxi-image-hover-create', OXI_IMAGE_HOVER_URL . '/assets/backend/js/create.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

    public function Render() {
        $import = (!empty($_GET['import']) ? $_GET['import'] : '');
        if ($import == 'templates'):
            ?>
            <div class="oxi-addons-row">
            <?php
            $this->Import_header();
            $this->import_template();
            ?>
            </div>
                <?php
            else:
                ?>
            <div class="oxi-addons-row">
            <?php
            $this->Admin_header();
            $this->template();
            $this->create_new();
            ?>
            </div>
            <?php
            endif;
        }

        public function JSON_DATA() {
            
        }

        public function Admin_header() {
            ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1><?php echo ucfirst($this->effects); ?> Effects › Create New</h1>
                <p> Select Image Hover layouts, Gives your Image Hover name and create new Image Hover.</p>
            </div>
        </div>
        <?php
    }

    public function Import_header() {
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1><?php echo ucfirst($this->effects); ?> Effects › Import Templates</h1>
                <p> Select Image Hover layouts, Import Templates for future Use.</p>
            </div>
        </div>
        <?php
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
                    echo '<div class="oxi-bt-col-lg-4 oxi-bt-col-md-6 oxi-bt-col-sm-12">';
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
                    echo '<div class="oxi-bt-col-lg-4 oxi-bt-col-md-6 oxi-bt-col-sm-12">';
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

        public function create_new() {
            echo __('<div class="modal fade" id="oxi-addons-style-create-modal" >
                        <form method="post" id="oxi-addons-style-modal-form">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">                    
                                        <h4 class="modal-title">New Image Hover</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class=" form-group row">
                                            <label for="addons-style-name" class="col-sm-6 col-form-label" oxi-addons-tooltip="Give your Shortcode Name Here">Name</label>
                                            <div class="col-sm-6 addons-dtm-laptop-lock">
                                                <input class="form-control" type="text" value="" id="style-name"  name="style-name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="oxi-tabs-link" class="col-sm-5 col-form-label" title="Select Layouts">Layouts</label>
                                            <div class="col-sm-7">
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-secondary active">
                                                        <input type="radio" name="image-hover-box-layouts"value="1"  checked="">1st
                                                    </label>
                                                    <label class="btn btn-secondary">
                                                        <input type="radio" name="image-hover-box-layouts" value="2">2nd
                                                    </label>
                                                    <label class="btn btn-secondary">
                                                        <input type="radio" name="image-hover-box-layouts" value="3">3rd
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

    }
    