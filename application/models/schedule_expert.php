<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_expert extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_current_weekly_schedule($sessionType, $sessionId)
	{
		if($sessionType == "r") // repeating weekly
			$schedule = $this->get_current_weekly_repeating_schedule($sessionId);
		else // static
			$schedule =  $this->get_current_weekly_static_schedule($sessionId, time());

		// Add days to dates
		if($schedule != null && $sessionType != "r")
		{
			foreach($schedule as $cellKey => $cellValue)
			{
				// convert to mo, tu, we etc format
				$schedule[$cellKey]["day"] = substr(strtolower(date("l", $cellValue["date"])), 0, 2);

			}

		}
		return $schedule;

	}

	function get_current_weekly_repeating_schedule($sessionId)
	{		
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `isScheduled` = ?";
		$result = $this->db->query($sql, array($sessionId, 1));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}

		return null;
	}


	function get_current_weekly_static_schedule($sessionId, $date)
	{
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `date` >= ? AND `date` <= ? AND isScheduled = ?";
		$week = $this->week_range($date);

		$result = $this->db->query($sql, array($sessionId, strtotime($week[0]), strtotime($week[1]), 1));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}

		return null;

	}

	function add_hour($sessionId, $userId, $time, $date, $day, $isScheduled)
	{
		$sql = "INSERT INTO `hour` (`id`, `userId`, `sessionId`, `time`, `date`, `day`, `isScheduled`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
		$this->db->query($sql, array($userId, $sessionId, $time, $date, $day, $isScheduled));
	}

	function truncate_hours()
	{
		$sql = "truncate `hour`";
		$this->db->query($sql);
	}

	
	function week_range($date) 
	{
	    $ts = $date;
	    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
	    return array(date('Y-m-d', $start),
	                 date('Y-m-d', strtotime('next saturday', $start)));
	}

}

?>