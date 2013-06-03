<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate extends MY_Controller {

	public function index()
	{
		// check if we are already authenticated, if so do nothing
		if($this->session->userdata('userid') !== FALSE)
		{
			redirect('schedule');
		}

		// for testing purposes, use backdoor_login
		$this->backdoor_login();

	}

	function cas_verify()
	{
        global $entry, $url_path;
        $ticket = $_GET['ticket'];

        if($_GET['entry'] == "")
                $_GET['entry'] = "NULL";

        if ($ticket) 
        {
                $file = @file("https://cas.ucalgary.ca/cas/validate?service=". $url_path ."/authenticate.php?entry=" . $_GET['entry'] . "&ticket=$ticket");

                $result = $file[0];

                if(strcmp($result, "no ") < 0)
                {
                        $a="https://cas.ucalgary.ca/cas/login?service=". $url_path ."/authenticate.php?entry=" . $_GET['entry'];
                        header("Location: $a");
                        die("too far");
                }
                if (!$file) 
                { 
                        die("The authentication process failed to validate through CAS.");
                }

                global $cas_response;
                $cas_response = $file[1];
                $filesplit = split(":", $file[1]);
                $cas_user = $filesplit[1];
                $cas_authtype = $filesplit[0];
                $entry = $_GET['entry'];

                authenticate($cas_user,$cas_authtype);

        } 
        else {
                $a="https://cas.ucalgary.ca/cas/login?service=". $url_path ."/authenticate.php?entry=" . $_GET['entry'];
                header("Location: $a");
        }
	}

	function backdoor_verify()
	{
		print_r($this->input->post('itusername'));
	}

	private function backdoor_login()
	{
		$this->loadview('backdoorlogin.php');
	}

}