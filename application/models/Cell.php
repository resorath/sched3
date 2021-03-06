<?php 
namespace models; // set namespace
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cell{

	public $realname;
	public $userid;
	public $celldate;
	public $celltype;

	public static $CELLTYPEPERSON = 0;
	public static $CELLTYPEVOID = 1;
	public static $CELLTYPESWAP = 2;
	public static $CELLTYPEAVAILABILITY = 3;

	public function __construct($realname="nobody", $userid=0, $celltype=0, $celldate=0)
	{
		$this->realname = $realname;
		$this->userid = $userid;
		$this->celldate = $celldate;
		$this->celltype = $celltype;
	}

}