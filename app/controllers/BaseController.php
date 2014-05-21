<?php

class BaseController extends Controller {

	public function __construct() {
		$this->beforeFilter( function () {
			if ( ! Config::get( 'wethepeople.api_key' ) ) {
				$vars = array(
					'page' => 'api_key_required',
					'body_vars' => array(
						'environment' => App::environment()
					)
				);
				return View::make( 'front.default' )->with( $vars );
			}
		});
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
