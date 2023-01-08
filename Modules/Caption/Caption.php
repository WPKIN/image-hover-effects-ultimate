<?php

	namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Caption;

	if (!defined('ABSPATH')) {
		exit;
	}

	/**
	 * Description of General
	 *
	 * @author biplo
	 */

	use OXI_IMAGE_HOVER_PLUGINS\Page\Create as Create;

	class Caption extends Create
	{

		public function JSON_DATA ()
		{

			$this->TEMPLATE = $this->rec_listFiles(OXI_IMAGE_HOVER_PATH . 'Modules/' . ucfirst($this->effects) . '/Layouts');

			$this->pre_active = [
			  'caption-1',
			  'caption-2',
			  'caption-3',
			  'caption-4',
			  'caption-5',
			  'caption-6',
			  'caption-7',
			  'caption-8',
			  'caption-9',
			  'caption-10',
			];
		}

	}
