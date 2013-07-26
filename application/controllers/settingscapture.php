<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settingscapture extends CI_Controller {

	public function index()
	{

	}

	public function updateHighlight($setting)
	{
		session_start();
		if($setting == 1 || $setting == 0)
		$_SESSION['highlighthours'] = $setting;
		session_write_close();
	}

}