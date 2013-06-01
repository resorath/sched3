<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends MY_Controller {

	public function index()
	{
		//$this->load->model('News_expert');
		
		//$data['newsdata'] = $this->News_expert->get_news();
		
		// set variables
		$data['title'] = "Schedule";

		$this->loadview('schedule', $data);
		
	}
}
