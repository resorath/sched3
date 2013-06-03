<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate extends MY_Controller {

	public function index()
	{
		// check if we are already authenticated, if so do nothing
		if(isset($_SESSION['userid']))
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

        function logout()
        {
                session_destroy();

                redirect('/schedule'); // TEMP
                // Redirect to cas logout
                //redirect("https://cas.ucalgary.ca/cas/logout?service=thislocation"); 
        }

        function logoutcomplete()
        {

        }

	function backdoor_verify()
	{
                $username = $this->input->post('itusername'); 

                $userid = $this->Person_expert->getUserId($username);

                if($userid != "")
                        $_SESSION['userid'] = $userid;
                else
                {
                        $this->backdoor_login("Username not found");
                        return;
                }

                $this->process_login();
	}

        function process_login()
        {
                $userid = $_SESSION['userid'];

                // Add roles to session
                $_SESSION['roles'] = $this->Role_expert->getRoles($userid);


                // @todo send user to their configured destination
                if(isset($_SESSION['destination']))
                        redirect($_SESSION['destination']);
                else
                        redirect("schedule");
        }

	private function backdoor_login($error=null)
	{
                $data['error'] = $error;
		$this->loadview('backdoorlogin.php', $data);
	}

}