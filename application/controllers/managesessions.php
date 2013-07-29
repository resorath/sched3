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

	public function edit($session)
	{
		$data['session'] = $this->Session_expert->get_session($session);

		if($data['session'] == null)
		{
			$this->create();
			return;
		}

		$_SESSION['sessionedit'] = $session;

		$data['title'] = $data['session']->title . " - Manage Sessions";

		$this->loadview('managesessions/edit', $data);

	}

	public function create()
	{


	}

	public function editpost()
	{
		$this->load->library('form_validation');
		$data['session'] = $this->Session_expert->get_session($_SESSION['sessionedit']);
		$data['title'] = $data['session']->title . " - Manage Sessions";

		if($this->form_validation->run() === FALSE)
		{
			$this->loadview('managesessions/edit', $data);
		}
		else
		{
			echo("success");

		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */