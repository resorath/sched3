<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_expert extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function add_session($title, $scheduleType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $groupId, $isActive=0, $isPrimary=0, $isLocked=0)
	{
		$sql = "INSERT INTO `session` (`id`,  `title`, `scheduleType`, `startDate`, `endDate`, `startTime`, `endTime`, `timeIncrementAmount`, `groupId`, `isActive`, `isPrimary`, `isLocked`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->db->query($sql, array($title, $scheduleType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $groupId, $isActive, $isPrimary, $isLocked));
		return $this->db->insert_id();
	}

	function edit_session($title, $scheduleType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $sessionId)
	{
		$sql = "UPDATE `session` SET `title` = ?, `scheduleType` = ?, `startDate` = ?, `endDate` = ?, `startTime` = ?, `endTime` = ?, `timeIncrementAmount` = ? WHERE `id` = ?";
		$this->db->query($sql, array($title, $scheduleType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $sessionId));
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

	function get_session_type($sessionId)
	{
		$session = $this->get_session($sessionId);

		return $session->scheduleType;

	}

	function get_session_group($sessionId)
	{
		$session = $this->get_session($sessionId);
		//echo("SESSION@");
		//print_r($session);
		return $session->groupId;
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

	function get_all_sessions()
	{
		$sql = "SELECT * FROM `session` ORDER BY `id` DESC";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	function set_flag($session, $flag, $value)
	{
		$sql = "UPDATE `session` SET `". $this->db->escape_str($flag) ."` = ? WHERE `id` = ?";
		$this->db->query($sql, array($value, $session));
	}

	function get_flag($session, $flag)
	{
		$sql = "SELECT * FROM `session` WHERE `id` = ?";
		$result = $this->db->query($sql, array($session));
		if($result->num_rows() > 0)
		{
			$row = $result->row();
			return $row->$flag;
		}
		return NULL;
	}

	function make_primary($session)
	{
		$groupId = $this->get_flag($session, "groupId");

		$sql = "UPDATE `session` SET `isPrimary` = '0' WHERE `groupId` = ?";
		$this->db->query($sql, array($groupId));

		$sql = "UPDATE `session` SET `isPrimary` = '1' WHERE `id` = ?";
		$this->db->query($sql, array($session));
	}

	function delete($session)
	{
		$thisSession = $this->get_session($session);

		if($thisSession == "")
			return "Session doesn't exist";
		if($thisSession->isPrimary == TRUE)
			return "Session is primary";

		$this->Schedule_expert->clear($session);

		$sql = "DELETE FROM `session` WHERE `id` = ?";
		$this->db->query($sql, array($session));

		return true;

	}

	function validateHour($session, $hour)
	{
		$hours = $this->Schedule_expert->getHourForUser($session, $hour, 0);
		
		foreach($hours as $hour)
		{
			$this->Schedule_expert->delete_hour($hour['id']);
		}
	}

	function invalidateHour($session, $hour)
	{
		$hours = $this->Schedule_expert->getHourForUser($session, $hour, 0);

		print_r($hours);

		if(count($hours) > 0)
			return;

		$startofday = strtotime(date("Y-m-d", $hour));
		$hourofday = date("Gi", $hour);
		$dayofweek = DChop($startofday);

		$this->Schedule_expert->add_hour($session, 0, $hourofday, $startofday, $dayofweek, 1, 0);

	}

	function buildHour($session, $time, $dayte, $user)
	{
		$hour = $this->Schedule_expert->getHourForUser($session, toTime($dayte, $time), $user);

		if(count($hour) == 0)
			return;

		$this->Schedule_expert->schedule_hour($hour[0]['id']);

	}

	function unbuildHour($session, $time, $dayte, $user)
	{
		$hour = $this->Schedule_expert->getHourForUser($session, toTime($dayte, $time), $user);
		if(count($hour) == 0)
			return;

		$this->Schedule_expert->unschedule_hour($hour[0]['id']);

	}



}

?>