<?php 
namespace models; // set namespace
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cell{

	public $realname;
	public $userid;

	public function __construct($realname="nobody", $userid=0)
	{
		$this->realname = $realname;
		$this->userid = $userid;
	}

}