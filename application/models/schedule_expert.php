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

		// Override exceptions
		if($schedule != null && $sessionType == "r")
		{
			// Get exceptions for this period
			$exceptions = $this->get_exception_time($sessionId);
			if($exceptions != null)
			{
				// Iterate through all cells in this weeks schedule
				foreach($schedule as $cellKey => $cellValue)
				{
					// Iterate through all exceptions for this session
					foreach($exceptions as $exception)
					{
						// Check if this exception applies to this week
						$weekrange = $this->week_range($date);
						if($exception['date'] >= strtotime($weekrange[0]) && $exception ['date'] <= strtotime($weekrange[1]))
						{
							// Convert exception date to day for matching
							$exception["day"] = substr(strtolower(date("l", $exception["date"])), 0, 2);

							// Check if the exception matches this timeslot
							if(	$schedule[$cellKey]["day"] == $exception["day"] 
								&& $schedule[$cellKey]["time"] == $exception["time"])
									$schedule[$cellKey] = $exception;
						}

					}
				}
			}
		}

		return $schedule;

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

	function clear($sessionId)
	{
		$sql = "DELETE FROM `hour` WHERE `sessionId` = ?";
		$this->db->query($sql, array($sessionId));

	}

}

?>