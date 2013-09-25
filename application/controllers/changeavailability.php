<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Changeavailability extends MY_Controller {

	public function index()
	{
		// set variables
		$data['title'] = "Change Availabilility";

		$data['sessions'] = $this->Session_expert->get_all_sessions();

		$this->loadview('changeavailability', $data);
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */