<?php

	namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Button;

	if (!defined('ABSPATH')) {
		exit;
	}

	/**
	 * Description of General
	 *
	 * @author biplo
	 */

	use OXI_IMAGE_HOVER_PLUGINS\Page\Create as Create;

	class Button extends Create
	{

		public function JSON_DATA ()
		{


			$this->TEMPLATE = $this->rec_listFiles(OXI_IMAGE_HOVER_PATH . 'Modules/' . ucfirst($this->effects) . '/Layouts');

			$this->pre_active = [
			  'button-1',
			  'button-2',
			  'button-3',
			  'button-4',
			  'button-5',
			];
		}

	}
