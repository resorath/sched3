<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends MY_Controller {

	public function index()
	{
            print_r($_SESSION);
	}
        
    public function h404($page)
    {
        $data['errorpage'] = $page;
        
        $this->loadview("404", $data);
    }
}