<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_expert extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function add_session($title, $scheduleType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $isActive, $isPrimary, $isLocked, $groupId)
	{
		$sql = "INSERT INTO `session` (`id`,  `title`, `scheduleType`, `startDate`, `endDate`, `startTime`, `endTime`, `timeIncrementAmount`, `isActive`, `isPrimary`, `isLocked`, `groupId`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->db->query($sql, array($title, $scheduleType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $isActive, $isPrimary, $isLocked, $groupId));
	}

	function truncate_sessions()
	{
		$sql = "truncate `session`";
		$this->db->query($sql);
	}

	function get_session($sessionId)
	{
		$sql = "SELECT * FROM `session` WHERE `id` = ?";
		$result = $this->db->query($sql, array($sessionId));
		if($result->num_rows() > 0)
		{
			$row = $result->row();
			return $row;
		}
		return "";
	}

	function get_primary_session($groupId)
	{
		$sql = "SELECT * FROM `session` WHERE `groupId` = ? AND `isPrimary` = ?";
		$result = $this->db->query($sql, array($groupId, 1));
		if($result->num_rows() > 0)
		{
			$row = $result->row();
			return $row;
		}
		return "no results";
	}

	function get_all_active_sessions_for_user($userId)
	{
		$sql = "SELECT *, `group`.`name` AS `groupname`, `session`.`id` as `sessionId` FROM `session` INNER JOIN `group` ON `session`.`groupId` = `group`.`id` WHERE `groupId` IN (SELECT DISTINCT `groupId` FROM `userGroup` WHERE `userId` = ?) AND `isActive` = ? ORDER BY `groupId` ASC";
		$result = $this->db->query($sql, array($userId, 1));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
		return array();
	}

	function get_all_active_sessions($groupId)
	{
		$sql = "SELECT * FROM `session` WHERE `groupId` = ? AND `isActive` = ?";
		$result = $this->db->query($sql, array($groupId, 1));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
		return array();
	}


}

?>