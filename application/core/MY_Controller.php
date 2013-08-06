<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    private $_controller;

    public $slogger;

    function __construct()
    {
        parent::__construct();

        $this->_controller = $this->router->fetch_class();

        $this->bootstrap();

        $this->checkLogin();

        $this->checkRoles();
        
    }
    
    // Startup procedure goes here for every pageload
    private function bootstrap()
    {
        // Don't run in CLI mode
        if($this->input->is_cli_request())
        {
            die("Sorry, Scheduler can't be run in CLI mode");
        }

        @session_start();

        // start the logger
        $this->slogger = Slogger::getInstance();
        $this->slogger->setController($this->_controller);

    }

    // Make sure user is logged in
    private function checkLogin()
    {
        // save the user's destination in case we direct them to authenticate

        // whitelist authentication mechanisms
        if($this->_controller == "authenticate")
            return;

        // whitelist database reload
        if($this->_controller == "populatetestdata")
            return;

        if(!isset($_SESSION['userid']))
        {
            // Don't redirect the user to an error page just in principle
            // @todo possible @bug why would it do this?
            if($this->_controller != "error")
            {
                $this->slogger->slog("saving destination to " . $this->_controller, SLOG_DEBUG);
                $_SESSION['destination'] = $this->_controller;
            }
            redirect('authenticate');

        }

    }

    // Check if the user has permission to view a page
    private function checkRoles()
    {
        // populate roles
        if(array_key_exists('userid', $_SESSION))
            $_SESSION['roles'] = $this->Role_expert->getRoles($_SESSION['userid'], $_SESSION['groupid']);
        //@todo
    }
        
    // overrides $this->load->view()
    public function loadview($content_view, $data = Array())
    {
        // Set default variables neccesary for headers/footers if not set
        
        // Title
        if(key_exists('title', $data))
            $data['title'] .= " - ";
        @$data['title'] .= "IT Scheduler";

        @$data['userfullname'] = $this->Person_expert->getFullName($_SESSION['userid']);

        @$data['userroles'] = $this->Role_expert->getRoles($_SESSION['userid']);
        
        // Navigation
        //if(!key_exists('nav', $data))
        //    $data['nav'] = "none";
        
        $data['content'] = $this->load->view($content_view, $data, true);
        $this->load->view('templates/master', $data);

    }

    
}