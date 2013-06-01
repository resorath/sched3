<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_expert extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function add_session($title, $scheduleType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $isActive, $isLocked, $groupId)
	{
		$sql = "INSERT INTO `session` (`id`,  `title`, `scheduleType`, `startDate`, `endDate`, `startTime`, `endTime`, `timeIncrementAmount`, `isActive`, `isLocked`, `groupId`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->db->query($sql, array($title, $scheduleType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $isActive, $isLocked, $groupId));
	}

	function truncate_sessions()
	{
		$sql = "truncate `session`";
		$this->db->query($sql);
	}

}

?>