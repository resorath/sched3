<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_expert extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_current_weekly_schedule($sessionType, $sessionId)
	{
		return $this->get_weekly_schedule($sessionType, $sessionId, time());

	}

	function get_weekly_schedule($sessionType, $sessionId, $date)
	{
		if($sessionType == "r") // repeating weekly
			$schedule = $this->get_current_weekly_repeating_schedule($sessionId);
		else // static
			$schedule =  $this->get_current_weekly_static_schedule($sessionId, $date);

		// Add days to dates
		if($schedule != null && $sessionType != "r")
		{
			foreach($schedule as $cellKey => $cellValue)
			{
				// convert to mo, tu, we etc format
				$schedule[$cellKey]["day"] = substr(strtolower(date("l", $cellValue["date"])), 0, 2);

			}

		}

		// Override exceptions (holidays, etc)
		if($schedule != null && $sessionType == "r")
			$this->inject_exceptions($schedule, $sessionId, $date);

		return $schedule;

	}

	function inject_exceptions(&$schedule, $sessionId, $date)
	{

		// Get exceptions for this period
		$exceptions = $this->get_exception_time($sessionId);

		// get week range
		$weekrange = $this->week_range($date);

		// Check if there are any exceptions this period
		if($exceptions != null)
		{
			// Iterate through all exceptions for this session
			foreach($exceptions as $exception)
			{
				// Check if this exception applies to this week
				if($exception['date'] >= strtotime($weekrange[0]) && $exception ['date'] <= strtotime($weekrange[1]))
				{
					// Iterate through all hours in this weeks schedule
					foreach($schedule as $cellKey => $cellValue)
					{
						// Convert exception date to day for matching
						$exception["day"] = substr(strtolower(date("l", $exception["date"])), 0, 2);

						// Check if the exception matches this hour (user + timeslot)
						if(	$schedule[$cellKey]["day"] == $exception["day"] 
							&& $schedule[$cellKey]["time"] == $exception["time"])
						{
							// wipe out the hour (exception is added below)
							$schedule[$cellKey] = null;
						}
					}

				}
			}


			// Iterate through all exceptions for this session (again) and inject into schedule
			foreach($exceptions as $exception)
			{
				// Check if this exception applies to this week (again)
				if($exception['date'] >= strtotime($weekrange[0]) && $exception ['date'] <= strtotime($weekrange[1]))
				{
					// append the exception to the schedule
					$exception["day"] = substr(strtolower(date("l", $exception["date"])), 0, 2);
					$schedule[] = $exception;
				}
			}
		}
	}

	function get_current_weekly_repeating_schedule($sessionId)
	{		
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `isScheduled` = ? AND `isException` = ?";
		$result = $this->db->query($sql, array($sessionId, 1, 0));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}

		return null;
	}

	function get_exception_time($sessionId)
	{
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `isScheduled` = ? AND `isException` = ?";
		$result = $this->db->query($sql, array($sessionId, 1, 1));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}

		return null;
	}

	function get_current_weekly_static_schedule($sessionId, $date)
	{
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `date` >= ? AND `date` <= ? AND isScheduled = ? AND `isException`= ?";
		$week = $this->week_range($date);

		$result = $this->db->query($sql, array($sessionId, strtotime($week[0]), strtotime($week[1]), 1, 0));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}

		return null;

	}

	function add_hour($sessionId, $userId, $time, $date, $day, $isScheduled, $isException = FALSE)
	{
		$sql = "INSERT INTO `hour` (`id`, `userId`, `sessionId`, `time`, `date`, `day`, `isScheduled`, `isException`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
		$this->db->query($sql, array($userId, $sessionId, $time, $date, $day, $isScheduled, $isException));
	}

	function add_exception_hour($sessionId, $time)
	{
		$sql = "INSERT INTO `hourexception` (`id`, `sessionId`, `time`) VALUES (NULL, ?, ?)";
		$this->db->query($sql, array($sessionId, $time));

	}

	function truncate_hours()
	{
		$sql = "truncate `hour`";
		$this->db->query($sql);
	}

	function truncate_exception_hours()
	{
		$sql = "truncate `hourexception`";
		$this->db->query($sql);

	}

	
	function week_range($date) 
	{
	    $ts = $date;
	    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
	    return array(date('Y-m-d', $start),
	                 date('Y-m-d', strtotime('next saturday', $start)));
	}

	function clear($sessionId)
	{
		$sql = "DELETE FROM `hour` WHERE `sessionId` = ?";
		$this->db->query($sql, array($sessionId));

	}

}

?>