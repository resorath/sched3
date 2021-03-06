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

	function get_exception_time_including_availability($sessionId)
	{
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `isException` = ? AND `userId` > 0";
		$result = $this->db->query($sql, array($sessionId, 1));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}

		return null;
	}

	function get_exception_time_including_availability_for_user($sessionId, $userid)
	{
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `isException` = ? AND `userId` = ?";
		$result = $this->db->query($sql, array($sessionId, 1, $userid));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}

		return null;
	}

	function get_exception_time_invalid_hours($sessionId)
	{
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `isScheduled` = ? AND `isException` = ? and `userId` = ?";
		$result = $this->db->query($sql, array($sessionId, 1, 1, 0));
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


	function get_regular_invalid_hours($sessionId)
	{
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `userId` = '0' AND `isException` = '0'";
		$result = $this->db->query($sql, array($sessionId));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
		return null;
	}	

	function get_exception_hours($sessionId)
	{
		$sql = "SELECT * FROM `hourexception` WHERE `sessionId` = ?";
		$result = $this->db->query($sql, array($sessionId));
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

	function delete_hour($hourId)
	{
		$sql = "DELETE FROM `hour` WHERE `id` = ?";
		$this->db->query($sql, array($hourId));
	}

	function schedule_hour($hourId)
	{
		$sql = "UPDATE `hour` SET `isScheduled` = '1' WHERE `id` = ?";
		$this->db->query($sql, array($hourId));
	}

	function unschedule_hour($hourId)
	{
		$sql = "UPDATE `hour` SET `isScheduled` = '0' WHERE `id` = ?";
		$this->db->query($sql, array($hourId));
	}

	// hourcode = HHMM, timecode = unix time for day only
	function delete_hour_exceptions($sessionId, $hourcode, $timecode)
	{
		$sql = "DELETE FROM `hour` WHERE `date` = ? AND `time` = ? AND `sessionId` = ?";
		$this->db->query($sql, array($timecode, $hourcode, $sessionId));
		
		$sql = "DELETE FROM `hourexception` WHERE `time` = ? AND `sessionId` = ?";
		$this->db->query($sql, array(realTime($timecode, $hourcode), $sessionId));
	}

	// timecode = unix time for that day
	function delete_hour_exceptions_full_day($sessionId, $timecode)
	{
		$sql = "DELETE FROM `hour` WHERE `date` = ? AND `isException` = ?";
		$this->db->query($sql, array($timecode, 1));

		$startOfDay = strtotime("midnight", $timecode);
		$endOfDay = strtotime("tomorrow", $startOfDay) - 1;

		$sql = "DELETE FROM `hourexception` WHERE (`time` >= ? AND `time` <= ?) AND `sessionId` = ?";
		$this->db->query($sql, array($startOfDay, $endOfDay, $sessionId));
	}

	function getHour($sessionId, $timestamp)
	{
		$startofday = strtotime(date("Y-m-d", $timestamp));
		$hourofday = date("Gi", $timestamp);
		$dayofweek = DChop($startofday);
		$sessionType = $this->Session_expert->get_session_type($sessionId);
		$result = "";

		if($sessionType == "s") // static
		{
			$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `time` = ? AND `date` = ?";
			$result = $this->db->query($sql, array($sessionId, $hourofday, $startofday));
		}
		else // repeating
		{
			$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `time` = ? AND `day` = ?";
			$result = $this->db->query($sql, array($sessionId, $hourofday, $dayofweek));
		}


		
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
		return null;
	}

	function getHourForUser($sessionId, $timestamp, $userId, $isException = false)
	{
		$startofday = strtotime(date("Y-m-d", $timestamp));
		$hourofday = date("Gi", $timestamp);
		$dayofweek = DChop($startofday);
		$sessionType = $this->Session_expert->get_session_type($sessionId);
		$result = "";

		if($sessionType == "s") // static
		{
			$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `time` = ? AND `date` = ? AND `userId` = ?";
			$result = $this->db->query($sql, array($sessionId, $hourofday, $startofday, $userId));
		}
		else if($sessionType == "r" && !$isException) // repeating
		{
			$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `time` = ? AND `day` = ? AND `userId` = ? AND `isException` = 0";
			$result = $this->db->query($sql, array($sessionId, $hourofday, $dayofweek, $userId));
		}
		else // repeating w/ exceptions
		{
			$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `time` = ? AND `date` = ? AND `userId` = ? AND `isException` = 1";
			$result = $this->db->query($sql, array($sessionId, $hourofday, $startofday, $userId));
		}
		
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
		return null;
	}

	function getAvailabilityForUser($sessionId, $userId)
	{		
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `userId` = ? AND `isException` = '0'";
		$result = $this->db->query($sql, array($sessionId, $userId));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
		return null;
	}

	function getCompiledAvailability($sessionId)
	{		
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `isScheduled` = '0' AND `isException` = '0'";
		$result = $this->db->query($sql, array($sessionId));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
		return null;
	}

	function getCombinedAvailability($sessionId)
	{		
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `isException` = '0'";
		$result = $this->db->query($sql, array($sessionId));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
		return null;
	}

	function userRemoveAvailability($session, $user, $hour)
	{
		$hours = $this->Schedule_expert->getHourForUser($session, $hour, $user);

		if(count($hours) == 0)
			return false;

		foreach($hours as $hour)
		{
			if($hour['isScheduled'] == 0) // only unavailable hours that aren't scheduled
				$this->Schedule_expert->delete_hour($hour['id']);
			else
				return false;
		}

		return true;
	}

	function userRemoveAvailabilityException($session, $user, $hour)
	{
		$hours = $this->Schedule_expert->getHourForUser($session, $hour, $user, true);

		if(count($hours) == 0)
			return false;
		
		foreach($hours as $hour)
		{
			if($hour['isScheduled'] == 0) // only unavailable hours that aren't scheduled
				$this->Schedule_expert->delete_hour($hour['id']);
			else
				return false;
		}

		return true;
	}

	function userAddAvailability($session, $user, $hour)
	{
		$hours = $this->Schedule_expert->getHourForUser($session, $hour, $user);
		
		if(count($hours) > 0)
			return false;

		$startofday = strtotime(date("Y-m-d", $hour));
		$hourofday = date("Gi", $hour);
		$dayofweek = DChop($startofday);

		$this->Schedule_expert->add_hour($session, $user, $hourofday, $startofday, $dayofweek, 0, 0);

		return true;
	}


	function userAddAvailabilityException($session, $user, $hour)
	{
		$hours = $this->Schedule_expert->getHourForUser($session, $hour, $user, true);
		
		if(count($hours) > 0)
			return false;
		$startofday = strtotime(date("Y-m-d", $hour));
		$hourofday = date("Gi", $hour);
		$dayofweek = DChop($startofday);

		$this->Schedule_expert->add_hour($session, $user, $hourofday, $startofday, $dayofweek, 0, 1);

		return true;
	}

}

?>