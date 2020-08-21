<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

/**
 * Description of Image Hover Rest API
 *
 * @author $biplob018
 */
class ImageApi {

    /**
     * Define $wpdb
     *
     * @since 9.3.0
     */
    public $wpdb;

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
    public $import_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $child_table;
    public $request;
    public $rawdata;
    public $styleid;
    public $childid;

    /**
     * Constructor of plugin class
     *
     * @since 9.3.0
     */
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
        $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
        $this->import_table = $this->wpdb->prefix . 'oxi_div_import';
        $this->build_api();
    }

    public function build_api() {
        add_action('rest_api_init', function () {
            register_rest_route(untrailingslashit('ImageHoverUltimate/v1/'), '/(?P<action>\w+)/', array(
                'methods' => 'POST',
                'callback' => [$this, 'api_action'],
            ));
        });
    }

    public function api_action($request) {
        $this->request = $request;
        $this->rawdata = addslashes($request['rawdata']);
        $this->styleid = $request['styleid'];
        $this->childid = $request['childid'];
        $class = $request['class'];
        $action_class = strtolower($request->get_method()) . '_' . sanitize_key($request['action']);
        if ($class != ''):
            $args = $request['args'];
            $optional = $request['optional'];
            ob_start();
            $CLASS = new $class;
            $CLASS->__construct($request['action'], $this->rawdata, $args, $optional);
            return ob_get_clean();

        else:
            if (method_exists($this, $action_class)) {
                return $this->{$action_class}();
            }
        endif;
    }

    public function array_replace($arr = [], $search = '', $replace = '') {
        array_walk($arr, function (&$v) use ($search, $replace) {
            $v = str_replace($search, $replace, $v);
        });
        return $arr;
    }

    public function post_create_new() {
        if (!empty($this->styleid)):
            $styleid = (int) $this->styleid;
            $newdata = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $styleid), ARRAY_A);
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($data, $newdata['style_name'], $newdata['rawdata'])));
            $redirect_id = $this->wpdb->insert_id;
            if ($redirect_id > 0):
                $raw = json_decode(stripslashes($newdata['rawdata']), true);
                $raw['image-hover-style-id'] = $redirect_id;
                $s = explode('-', $newdata['style_name']);
                $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
                $C = new $CLASS('admin');
                $f = $C->template_css_render($raw);
                $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
                foreach ($child as $value) {
                    $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s)", array($redirect_id, $value['rawdata'])));
                }
                return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
            endif;
        else:
            $params = json_decode(stripslashes($this->rawdata), true);
            $newname = $params['name'];
            $rawdata = $params['style'];
            $style = $rawdata['style'];
            $child = $rawdata['child'];
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($newname, $style['style_name'], $style['rawdata'])));
            $redirect_id = $this->wpdb->insert_id;
            if ($redirect_id > 0):
                $raw = json_decode(stripslashes($style['rawdata']), true);
                $raw['image-hover-style-id'] = $redirect_id;
                $s = explode('-', $style['style_name']);
                $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
                $C = new $CLASS('admin');
                $f = $C->template_css_render($raw);
                foreach ($child as $value) {
                    $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($redirect_id, $value['rawdata'])));
                }
                return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
            endif;
        endif;
    }

    public function post_shortcode_delete() {
        $styleid = (int) $this->styleid;
        if ($styleid):
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->parent_table} WHERE id = %d", $styleid));
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->child_table} WHERE styleid = %d", $styleid));
            return 'done';
        else:
            return 'Silence is Golden';
        endif;
    }

    public function update_image_hover_plugin() {
        $stylelist = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->parent_table ORDER by id ASC"), ARRAY_A);
        foreach ($stylelist as $value) {
            $raw = json_decode(stripslashes($value['rawdata']), true);
            $raw['image-hover-style-id'] = $value['id'];
            $s = explode('-', $value['style_name']);
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
            $C = new $CLASS('admin');
            $f = $C->template_css_render($raw);
        }
        update_option('image_hover_ultimate_update_complete', 'done');
    }

    public function post_shortcode_export() {
        $styleid = (int) $this->styleid;
        if ($styleid):
            $st = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $this->parent_table WHERE id = %d", $styleid), ARRAY_A);
            $c = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
            $style = [
                'id' => $st['id'],
                'name' => $st['name'],
                'style_name' => $st['style_name'],
                'rawdata' => json_encode($this->array_replace(json_decode(stripslashes($st['rawdata']), true), '"', '&quot;')),
                'stylesheet' => htmlentities($st['stylesheet']),
                'font_family' => $st['font_family'],
            ];
            $child = [];
            foreach ($c as $value) {
                $child[] = [
                    'id' => $value['id'],
                    'styleid' => $value['styleid'],
                    'rawdata' => json_encode($this->array_replace(json_decode(stripslashes($value['rawdata']), true), '"', '&quot;'))
                ];
            }
            $newdata = ['plugin' => 'image-hover', 'style' => $style, 'child' => $child];
            return json_encode($newdata);
        else:
            return 'Silence is Golden';
        endif;
    }

    public function post_shortcode_deactive() {
        $id = $this->rawdata . '-' . (int) $this->styleid;
        $effects = $this->rawdata . '-ultimate';
        if ($this->styleid > 0):
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->import_table} WHERE name = %s and type = %s", $id, $effects));
            return 'done';
        else:
            return 'Silence is Golden';
        endif;
    }

    public function post_shortcode_active() {
        $id = $this->rawdata . '-' . (int) $this->styleid;
        $effects = $this->rawdata . '-ultimate';
        if ($this->styleid > 0):
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->import_table} (type, name) VALUES (%s, %s)", array($effects, $id)));
            return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$this->rawdata#" . $id);
        else:
            return 'Silence is Golden';
        endif;
    }

    /**
     * Template Style Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_style() {
        $settings = json_decode(stripslashes($this->rawdata), true);
        $StyleName = sanitize_text_field($settings['image-hover-template']);
        $stylesheet = '';
        if ((int) $this->styleid):
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET rawdata = %s, stylesheet = %s WHERE id = %d", $this->rawdata, $stylesheet, $this->styleid));
            $name = explode('-', $StyleName);
            $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $name[0] . '\Admin\Effects' . $name[1];
            $CLASS = new $cls('admin');
            return $CLASS->template_css_render($settings);
        endif;
    }

    /**
     * Template Style Data
     *
     * @since 9.3.0
     */
    public function post_template_change() {
        $rawdata = sanitize_text_field($this->rawdata);
        if ((int) $this->styleid):
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET style_name = %s WHERE id = %d", $rawdata, $this->styleid));
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_template_name() {
        $settings = json_decode(stripslashes($this->rawdata), true);
        $name = sanitize_text_field($settings['addonsstylename']);
        $id = $settings['addonsstylenameid'];
        if ((int) $id):
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET name = %s WHERE id = %d", $name, $id));
            return 'success';
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_elements_rearrange_modal_data() {
        if ((int) $this->styleid):
            $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $this->styleid), ARRAY_A);
            $render = [];
            foreach ($child as $k => $value) {
                $data = json_decode(stripcslashes($value['rawdata']));
                $render[$value['id']] = $data;
            }
            return json_encode($render);
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_elements_template_rearrange_save_data() {
        $params = explode(',', $this->rawdata);
        foreach ($params as $value) {
            if ((int) $value):
                $data = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE id = %d ", $value), ARRAY_A);
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s)", array($data['styleid'], $data['rawdata'])));
                $redirect_id = $this->wpdb->insert_id;
                if ($redirect_id == 0) {
                    return;
                }
                if ($redirect_id != 0) {
                    $this->wpdb->query($this->wpdb->prepare("DELETE FROM $this->child_table WHERE id = %d", $value));
                }
            endif;
        }
        return 'success';
    }

    /**
     * Template Modal Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data() {
        if ((int) $this->styleid):
            if ((int) $this->childid):
                $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->child_table} SET rawdata = %s WHERE id = %d", $this->rawdata, $this->childid));
            else:
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s )", array($this->styleid, $this->rawdata)));
            endif;
        endif;
    }

    /**
     * Template Rebuild Render
     *
     * @since 9.3.0
     */
    public function post_elements_template_rebuild_data() {
        $style = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $this->styleid), ARRAY_A);
        $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $this->styleid), ARRAY_A);
        $style['rawdata'] = $style['stylesheet'] = $style['font_family'] = '';
        $name = explode('-', $style['style_name']);
        $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($name[0]) . '\Render\Effects' . $name[1];
        $CLASS = new $cls;
        $CLASS->__construct($style, $child, 'admin');
        return 'success';
    }

    /**
     * Template Template Render
     *
     * @since 9.3.0
     */
    public function post_elements_template_render_data() {
        $settings = json_decode(stripslashes($this->rawdata), true);
        $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $this->styleid), ARRAY_A);
        $StyleName = $settings['image-hover-template'];
        $name = explode('-', $StyleName);
        ob_start();
        $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $name[0] . '\Render\Effects' . $name[1];
        $CLASS = new $cls;
        $styledata = ['rawdata' => $this->rawdata, 'id' => $this->styleid, 'style_name' => $StyleName, 'stylesheet' => ''];
        $CLASS->__construct($styledata, $child, 'admin');
        return ob_get_clean();
    }

    /**
     * Template Modal Data Edit Form 
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_edit() {
        if ((int) $this->childid):
            $listdata = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->child_table} WHERE id = %d ", $this->childid), ARRAY_A);
            $returnfile = json_decode(stripslashes($listdata['rawdata']), true);
            $returnfile['shortcodeitemid'] = $this->childid;
            return json_encode($returnfile);
        else:
            return 'Silence is Golden';
        endif;
    }

    /**
     * Template Child Delete Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_delete() {
        if ((int) $this->childid):
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->child_table} WHERE id = %d ", $this->childid));
            return 'done';
        else:
            return 'Silence is Golden';
        endif;
    }

    /**
     * Admin Notice API  loader
     * @return void
     */
    public function post_oxi_recommended() {
        $data = 'done';
        update_option('oxi_image_hover_recommended', $data);
        return $data;
    }

    /**
     * Admin Notice Recommended  loader
     * @return void
     */
    public function post_notice_dissmiss() {
        $notice = $this->request['notice'];
        if ($notice == 'maybe'):
            $data = strtotime("now");
            update_option('oxi_image_hover_activation_date', $data);
        else:
            update_option('oxi_image_hover_nobug', $notice);
        endif;
        return $notice;
    }

}
