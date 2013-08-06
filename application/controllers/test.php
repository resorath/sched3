<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller {

	public function index()
	{

	}

	public function __construct()
	{
		parent::__construct();

		$action = $this->uri->segment(2); // override action grab

	}

	public function tooltips()
	{
		$this->loadview("test/tooltips");
	}
}