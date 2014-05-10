<?php

class FrontController extends BaseController {

	public function index()
	{
		return View::make('front.index');
	}

}
