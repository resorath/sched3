<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Person_expert extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function add_person($ucid, $firstname, $lastname, $itusername)
	{
		$sql = "INSERT INTO `user` (`id`,  `ucid`, `firstName`, `lastName`, `itUsername`) VALUES (NULL, ?, ?, ?, ?)";
		$this->db->query($sql, array($ucid, $firstname, $lastname, $itusername));
	}

	function add_person_to_group($userId, $groupId)
	{
		$sql = "INSERT INTO `userGroup` (`id`,  `userId`, `groupId`) VALUES (NULL, ?, ?)";
		$this->db->query($sql, array($userId, $groupId));
	}

	function truncate_people()
	{
		$sql = "truncate `user`";
		$this->db->query($sql);
	}

	function truncate_userGroups()
	{
		$sql = "truncate `userGroup`";
		$this->db->query($sql);
	}

	function getPeopleAsCellFormat()
	{
		$sql = "SELECT `id`, `firstName`, `lastName` FROM `user`";
		$result = $this->db->query($sql);
		if($result->num_rows() > 0)
		{
			$rdata = $result->result_array();

			foreach($rdata as $pdata)
			{
				$returnVal[$pdata['id']] = $pdata['firstName'] . " " . substr($pdata['lastName'], 0, 1);
			}

			return $returnVal;
		}
		return "";
	}

	function getFullName($itusername)
	{
		$sql = "SELECT `firstName`, `lastName` FROM `user` WHERE `itusername` = ?";
		$result = $this->db->query($sql, array($itusername));
		if($result->num_rows() > 0)
		{
			$row = $result->row();
			return $row->firstName . " " . $row->lastName;
		}
		return "";
	}

	function getUserId($itusername)
	{
		$sql = "SELECT `id` FROM `user` WHERE `itUsername` = ?";
		$result = $this->db->query($sql, array($itusername));
		if($result->num_rows() > 0)
		{
			$row = $result->row();
			return $row->id;
		}
		return "";
	}

}

?>