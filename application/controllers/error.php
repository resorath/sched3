<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends MY_Controller {

	public function index()
	{
            echo "index";
	}
        
        public function h404()
        {
            $data[] = Array();
            
            $this->loadview("404");
        }
}