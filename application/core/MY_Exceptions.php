<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

    function __construct()
    {
        parent::__construct();
    }
        
    function absolute_path($path = '')
    {
        $abs_path = str_replace('system/',$path, BASEPATH);
        //Add a trailing slash if it doesn't exist.
        $abs_path = preg_replace("#([^/])/*$#", "\\1/", $abs_path);
        return $abs_path;
    }
    
    function show_404($page = '', $log_error = TRUE)
    {
        $this->config =& get_config();
        $base_url = $this->config['base_url'];
        
        header("location: ".$base_url.'error/h404/'.$page);
        //include()
        //include($this->absolute_path() . "index.php?error/404/" . $page);
        die();
        
        // Header didn't redirect, go to a backup
        parent::show_404($page, $log_error);
    }
}