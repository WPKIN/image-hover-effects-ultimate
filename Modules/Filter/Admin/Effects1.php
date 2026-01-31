<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Filter\Admin;

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Description of Effects1
 *
 * @author biplob
 */

use OXI_IMAGE_HOVER_PLUGINS\Modules\Filter\Modules;
use OXI_IMAGE_HOVER_PLUGINS\Classes\Controls;

class Effects1 extends Modules
{
	public function Rearrange()
	{
		return '<li class="list-group-item" id="{{id}}">{{image_hover_heading}}</li>';
	}
}
