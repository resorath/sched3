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

	function add_person_to_group($userId, $groupId, $isPrimary = TRUE)
	{
		$sql = "INSERT INTO `userGroup` (`id`,  `userId`, `groupId`, `isPrimary`) VALUES (NULL, ?, ?, ?)";
		$this->db->query($sql, array($userId, $groupId, $isPrimary));
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

	function getPrimaryGroup($userid)
	{
		$sql = "SELECT `groupId` FROM `userGroup` WHERE `userId` = ? AND `isPrimary` = ?";
		$result = $this->db->query($sql, array($userid, 1));

		if($result->num_rows() > 0)
		{
			$row = $result->row();
			return $row->groupId;
		}
		return "NOGROUP";
	}

	function getFullName($userid)
	{
		$sql = "SELECT `firstName`, `lastName` FROM `user` WHERE `id` = ?";
		$result = $this->db->query($sql, array($userid));
		if($result->num_rows() > 0)
		{
			$row = $result->row();
			return $row->firstName . " " . $row->lastName;
		}
		return NULL;
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