<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Page;

if (!defined('ABSPATH')) {
    exit;
}

class Shortcode {

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

    use \OXI_IMAGE_HOVER_PLUGINS\Helper\Public_Helper;
    use \OXI_IMAGE_HOVER_PLUGINS\Helper\CSS_JS_Loader;

    /**
     * Constructor of Oxilab tabs Home Page
     *
     * @since 9.3.0
     */
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
        $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
        $this->import_table = $this->wpdb->prefix . 'oxi_div_import';
        $this->CSSJS_load();
        $this->Render();
    }

    public function CSSJS_load() {


    
        $this->admin_css_loader();
        $this->admin_home();
        $this->admin_rest_api();
        apply_filters('oxi-image-hover-plugin/admin_menu', TRUE);
    }

    /**
     * Admin Notice JS file loader
     * @return void
     */
    public function admin_rest_api() {
        wp_enqueue_script('oxi-image-hover-shortcode', OXI_IMAGE_HOVER_URL . '/assets/backend/js/shortcode.js', false, OXI_IMAGE_HOVER_TEXTDOMAIN);
    }

    /**
     * Generate safe path
     * @since v1.0.0
     */
    public function safe_path($path) {

        $path = str_replace(['//', '\\\\'], ['/', '\\'], $path);
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }

     public function Render() {
        ?>
        <div class="oxi-addons-row">
            <?php
            $this->Admin_header();
            $this->created_shortcode();
            $this->create_new();
            ?>
        </div>
        <?php
    }

    public function Admin_header() {
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1>Image Hover › Shortcode</h1>
                <p>Collect Image Hover Shortcode, Edit, Delect, Clone or Export it.</p>
            </div>
        </div>
        <?php
    }
      /**
     * Plugin Name Convert to View
     *
     * @since 9.3.0
     */
    public function name_($data) {
        $data = str_replace('_', ' ', $data);
        $data = str_replace('-', ' ', $data);
        $data = str_replace('+', ' ', $data);
        echo esc_html(ucwords($data));
    }

    public function database_data() {
        return $this->wpdb->get_results("SELECT * FROM  $this->parent_table ORDER BY id DESC", ARRAY_A);
    }

    public function created_shortcode() {
        ?>
        <div class="oxi-addons-row"> <div class="oxi-addons-row table-responsive abop" style="margin-bottom: 20px; opacity: 0; height: 0px">
                <table class="table table-hover widefat oxi_addons_table_data" style="background-color: #fff; border: 1px solid #ccc">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 15%">Name</th>
                            <th style="width: 10%">Templates</th>
                            <th style="width: 30%">Shortcode</th>
                            <th style="width: 40%">Edit Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($this->database_data() as $value) {

                            $effects = $this->effects_converter($value['style_name']);

                            $id = $value['id'];
                            ?>
                            <tr>
                                <td><?php echo (int) $id; ?></td>
                                <td><?php $this->name_($value['name']) ?></td>
                                <td><?php $this->name_($value['style_name']) ?></td>
                                <td><span>Shortcode &nbsp;&nbsp;<input type="text" onclick="this.setSelectionRange(0, this.value.length)" value="[iheu_ultimate_oxi id=&quot;<?php echo (int) $id ?>&quot;]"></span> <br>
                                    <span>Php Code &nbsp;&nbsp; <input type="text" onclick="this.setSelectionRange(0, this.value.length)" value="&lt;?php echo do_shortcode(&#039;[iheu_ultimate_oxi  id=&quot;<?php echo (int) $id ?>&quot;]&#039;); ?&gt;"></span></td>
                                <td>
                                    <a href="<?php echo esc_url(admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$effects&styleid=$id")) ?>"  title="Edit"  class="btn btn-primary" style="float:left; margin-right: 5px;">Edit</a>
                                    <a href="#"  title="Clone"  class="btn btn-secondary oxi-addons-style-clone"  datavalue="<?php echo (int) $id; ?>" style="float:left; margin-right: 5px;">Clone</a>
                                     <button class="btn btn-danger oxi-addons-style-delete" style="float:left"  title="Delete" value="<?php echo (int) $id; ?>" type="button" value="delete">Delete</button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <br>
            <br></div>
        <?php
    }

    public function create_new() {
        ?>
      


        <div class="modal fade" id="oxi-addons-style-clone-modal" >
            <form method="post" id="oxi-addons-style-clone-modal-form">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Layouts Clone</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class=" form-group row">
                                <label for="addons-style-name" class="col-sm-6 col-form-label" oxi-addons-tooltip="Give your Shortcode Name Here">Name</label>
                                <div class="col-sm-6 addons-dtm-laptop-lock">
                                    <input class="form-control" type="text" value="" id="addons-style-name"  name="addons-style-name" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="oxistyleid" name="oxistyleid" value="">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" name="addonsdatasubmit" id="addonsdatasubmit" value="Save">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }

}
