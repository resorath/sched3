<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('user_has_role'))
{

    function user_has_role($role, $group = NULL)
    {
        if($group == NULL)
            if(array_key_exists("groupid", $_SESSION))
                $group = $_SESSION['groupid'];
            else
                return FALSE;

        if(!array_key_exists("userid", $_SESSION))
        	return FALSE;

        if(!array_key_exists("roles", $_SESSION))
        	return FALSE;


        foreach($_SESSION['roles'][$group] as $userrole)
        {
        	if($userrole == $role)
        		return TRUE;
        }
        return FALSE;
    }   
}