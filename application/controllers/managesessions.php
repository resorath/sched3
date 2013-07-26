<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managesessions extends MY_Controller {

	public function index()
	{
		//$this->load->model('News_expert');
		
		//$data['newsdata'] = $this->News_expert->get_news();
		
		// set variables
		$data['title'] = "Manage Sessions";

		$data['sessions'] = $this->Session_expert->get_all_sessions();

		$this->loadview('managesessions/select', $data);
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */