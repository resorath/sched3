<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_expert extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_current_weekly_schedule($sessionId)
	{
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ?";
		$result = $this->db->query($sql, array($sessionId));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
	}

	function get_weekly_schedule($sessionId, $date)
	{
		$sql = "SELECT * FROM `hour` WHERE `sessionId` = ? AND `date` >= ? AND `date` <= ?";
		$week = $this->week_range($date);

		$result = $this->db->query($sql, array($sessionId, strtotime($week[0]), strtotime($week[1])));
		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}

	}

	function add_hour($sessionId, $userId, $time, $date, $day)
	{
		$sql = "INSERT INTO `hour` (`id`, `userId`, `sessionId`, `time`, `date`, `day`) VALUES (NULL, ?, ?, ?, ?, ?)";
		$this->db->query($sql, array($sessionId, $userId, $time, $date, $day));
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