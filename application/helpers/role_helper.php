<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('user_has_role'))
{
    function user_has_role($role)
    {
        if(!array_key_exists("userid", $_SESSION))
        	return FALSE;

        if(!array_key_exists("roles", $_SESSION))
        	return FALSE;

        foreach($_SESSION['roles'] as $userrole)
        {
        	if($userrole['roleName'] == $role)
        		return TRUE;
        }
        return FALSE;
    }   
}