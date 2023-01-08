<?php

	namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Flipbox;

	if (!defined('ABSPATH')) {
		exit;
	}
	if (!defined('ABSPATH')) {
		exit;
	}

	/**
	 * Description of General
	 *
	 * @author biplo
	 */

	use OXI_IMAGE_HOVER_PLUGINS\Page\Create as Create;

	class Flipbox extends Create
	{

		public function JSON_DATA ()
		{
			$this->TEMPLATE = $this->rec_listFiles(OXI_IMAGE_HOVER_PATH . 'Modules/' . ucfirst($this->effects) . '/Layouts');
			$this->pre_active = [
			  'flipbox-1',
			  'flipbox-2',
			  'flipbox-3',
			  'flipbox-4',
			  'flipbox-5',
			  'flipbox-6',
			  'flipbox-7',
			  'flipbox-8',
			  'flipbox-9',
			  'flipbox-10',
			];
		}

	}
