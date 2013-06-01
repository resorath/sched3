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

	function get_session($scheduleId)
	{
		$sql = "SELECT `id` FROM `session` WHERE `id` = ?";
		$result = $this->db->query($sql, array($scheduleId));
		if($result->num_rows() > 0)
		{
			$row = $result->row();
			return $row->id;
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


}

?>