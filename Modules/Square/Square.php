<?php

	namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Square;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	/**
	 * Description of Square
	 *
	 * @author biplo
	 */

	use OXI_IMAGE_HOVER_PLUGINS\Page\Create;

class Square extends Create {


	public function JSON_DATA() {
		$this->TEMPLATE = $this->rec_listFiles( OXI_IMAGE_HOVER_PATH . 'Modules/' . ucfirst( $this->effects ) . '/Layouts' );
		$this->pre_active = [
			'square-1',
			'square-2',
			'square-3',
			'square-4',
			'square-5',
			'square-6',
			'square-7',
			'square-8',
			'square-9',
			'square-10',
		];
	}
}
