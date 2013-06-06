<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_expert extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function add_group($name, $supervisorId)
	{
		$sql = "INSERT INTO `group` (`id`, `name`, `supervisorId`) VALUES (NULL, ?, ?)";
		$this->db->query($sql, array($name, $supervisorId));
	}

	function truncate_groups()
	{
		$sql = "truncate `group`";
		$this->db->query($sql);
	}


}

?>