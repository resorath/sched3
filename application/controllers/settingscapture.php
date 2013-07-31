<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settingscapture extends MY_Controller {

	public function index()
	{

	}

	public function updateHighlight($setting)
	{
		if($setting == 1 || $setting == 0)
		$_SESSION['highlighthours'] = $setting;
	}

}