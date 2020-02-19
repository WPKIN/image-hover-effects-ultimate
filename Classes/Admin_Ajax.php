<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

/**
 * Description of Admin_Ajax
 *
 * @author $biplob018
 */
class Admin_Ajax {

    use \OXI_IMAGE_HOVER_PLUGINS\Helper\Uplaod;

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

    /**
     * Constructor of plugin class
     *
     * @since 9.3.0
     */
    public function __construct($type = '', $data = '', $styleid = '', $itemid = '') {
        if (!empty($type) && !empty($data)):
            global $wpdb;
            $this->wpdb = $wpdb;
            $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
            $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
            $this->import_table = $this->wpdb->prefix . 'oxi_div_import';
            $this->$type($data, $styleid, $itemid);
        endif;
    }

    public function array_replace($arr = [], $search = '', $replace = '') {
        array_walk($arr, function (&$v) use ($search, $replace) {
            $v = str_replace($search, $replace, $v);
        });
        return $arr;
    }

    public function image_hover_upgrade($data = '', $styleid = '', $itemid = '') {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $tmpfile = download_url('https://image-hover.oxilab.org/wp-content/uploads/oxi-image-hover/image-hover.zip', $timeout = 500);
        $this->upload_folder();
        if (is_string($tmpfile)):
            WP_Filesystem();
            $unzipfile = unzip_file($tmpfile, OXI_IMAGE_HOVER_UPLOAD_PATH);
            if ($unzipfile) {
                echo 'Done';
            } else {
                echo 'There was an error unzipping the file.';
            }
        endif;
    }

    public function create_new($data = '', $styleid = '', $itemid = '') {
        if (!empty($styleid)):
            $styleid = (int) $styleid;
            $newdata = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $styleid), ARRAY_A);
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($data, $newdata['style_name'], $newdata['rawdata'])));
            $redirect_id = $this->wpdb->insert_id;
            if ($redirect_id > 0):
                $raw = json_decode(stripslashes($newdata['rawdata']), true);
                $raw['image-hover-style-id'] = $redirect_id;
                $s = explode('-', $newdata['style_name']);
                $CLASS = 'OXI_IMAGE_HOVER_UPLOADS\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
                $C = new $CLASS('admin');
                $f = $C->template_css_render($raw);
                $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
                foreach ($child as $value) {
                    $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s)", array($redirect_id, $value['rawdata'])));
                }
                echo admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
            endif;
        else:
            $params = json_decode(stripslashes($data), true);
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
                $CLASS = 'OXI_IMAGE_HOVER_UPLOADS\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
                $C = new $CLASS('admin');
                $f = $C->template_css_render($raw);
                foreach ($child as $value) {
                    $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($redirect_id, $value['rawdata'])));
                }
                echo admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
            endif;
        endif;
    }

    public function shortcode_delete($data = '', $styleid = '', $itemid = '') {
        $styleid = (int) $styleid;
        if ($styleid):
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->parent_table} WHERE id = %d", $styleid));
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->child_table} WHERE styleid = %d", $styleid));
            echo 'done';
        else:
            echo 'Silence is Golden';
        endif;
    }

    public function shortcode_export($data = '', $styleid = '', $itemid = '') {
        $styleid = (int) $styleid;
        if ($styleid):
            $st = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $this->parent_table WHERE id = %d", $styleid), ARRAY_A);
            $c = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
            $style = [
                'id' => $st['id'],
                'type' => ucfirst($st['type']),
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
            echo json_encode($newdata);
        else:
            echo 'Silence is Golden';
        endif;
    }

    public function shortcode_deactive($data = '', $styleid = '', $itemid = '') {
        $id = $data . '-' . (int) $styleid;
        $effects = $data . '-ultimate';
        if ($styleid > 0):
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->import_table} WHERE name = %s and type = %s", $id, $effects));
            echo 'done';
        else:
            echo 'Silence is Golden';
        endif;
    }

    public function shortcode_active($data = '', $styleid = '', $itemid = '') {
        $id = $data . '-' . (int) $styleid;
        $effects = $data . '-ultimate';
        if ($styleid > 0):
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->import_table} (type, name) VALUES (%s, %s)", array($effects, $id)));
            echo admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$data#" . $id);
        else:
            echo 'Silence is Golden';
        endif;
    }

    /**
     * Template Style Data
     *
     * @since 9.3.0
     */
    public function elements_template_style_data($rawdata = '', $styleid = '') {
        $settings = json_decode(stripslashes($rawdata), true);
        $StyleName = sanitize_text_field($settings['image-hover-template']);
        $stylesheet = '';
        if ((int) $styleid):
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET rawdata = %s, stylesheet = %s WHERE id = %d", $rawdata, $stylesheet, $styleid));
            $name = explode('-', $StyleName);
            $cls = '\OXI_IMAGE_HOVER_UPLOADS\\' . $name[0] . '\Admin\Effects' . $name[1];
            $CLASS = new $cls('admin');
            echo $CLASS->template_css_render($settings);
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function elements_template_change_name($rawdata = '') {
        $settings = json_decode(stripslashes($rawdata), true);
        $name = sanitize_text_field($settings['addonsstylename']);
        $id = $settings['addonsstylenameid'];
        if ((int) $id):
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET name = %s WHERE id = %d", $name, $id));
            echo 'success';
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function elements_rearrange_modal_data($rawdata = '', $styleid = '', $childid) {
        if ((int) $styleid):
            $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
            $render = [];
            foreach ($child as $key => $value) {
                $data = json_decode(stripcslashes($value['rawdata']));
                $render[$value['id']] = $data;
            }
            echo json_encode($render);
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function elements_template_rearrange_save_data($rawdata = '', $styleid = '', $childid) {
        $params = explode(',', $rawdata);
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
        echo 'success';
    }

    /**
     * Template Modal Data
     *
     * @since 9.3.0
     */
    public function elements_template_modal_data($rawdata = '', $styleid = '', $childid) {
        if ((int) $styleid):
            if ((int) $childid):
                $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->child_table} SET rawdata = %s WHERE id = %d", $rawdata, $childid));
            else:
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s )", array($styleid, $rawdata)));
            endif;
        endif;
    }

    /**
     * Template Template Render
     *
     * @since 9.3.0
     */
    public function elements_template_render_data($rawdata = '', $styleid = '') {
        $settings = json_decode(stripslashes($rawdata), true);
        $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
        $StyleName = $settings['image-hover-template'];
        $name = explode('-', $StyleName);
        $cls = '\OXI_IMAGE_HOVER_UPLOADS\\' . $name[0] . '\Render\Effects' . $name[1];
        $CLASS = new $cls;
        $styledata = ['rawdata' => $rawdata, 'id' => $styleid, 'style_name' => $StyleName, 'stylesheet' => ''];
        $CLASS->__construct($styledata, $child, 'admin');
    }

    /**
     * Template Rebuild Render
     *
     * @since 9.3.0
     */
    public function elements_template_rebuild_data($rawdata = '', $styleid = '') {
        $style = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $styleid), ARRAY_A);
        $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
        $style['rawdata'] = $style['stylesheet'] = $style['font_family'] = '';
        $name = explode('-', $style['style_name']);
        $cls = '\OXI_IMAGE_HOVER_UPLOADS\\' . ucfirst($name[0]) . '\Render\Effects' . $name[1];
        $CLASS = new $cls;
        $CLASS->__construct($style, $child, 'admin');
        echo 'success';
    }

    /**
     * Template Modal Data Edit Form 
     *
     * @since 9.3.0
     */
    public function elements_template_modal_data_edit($rawdata = '', $styleid = '', $childid) {
        if ((int) $childid):
            $listdata = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->child_table} WHERE id = %d ", $childid), ARRAY_A);
            $returnfile = json_decode(stripslashes($listdata['rawdata']), true);
            $returnfile['shortcodeitemid'] = $childid;
            echo json_encode($returnfile);
        else:
            echo 'Silence is Golden';
        endif;
    }

    /**
     * Template Child Delete Data
     *
     * @since 9.3.0
     */
    public function elements_template_modal_data_delete($rawdata = '', $styleid = '', $childid) {
        if ((int) $childid):
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->child_table} WHERE id = %d ", $childid));
            echo 'done';
        else:
            echo 'Silence is Golden';
        endif;
    }

}
