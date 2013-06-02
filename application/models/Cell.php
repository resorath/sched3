<?php 
namespace models; // set namespace
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cell{

	public $realname;

	public function __construct($realname="nobody")
	{
		$this->realname = $realname;
	}

}