<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends MY_Controller {

	public function index()
	{
		if(!isset($_SESSION['sessionId']))
			$data['sessiondata'] = $this->Session_expert->get_primary_session($_SESSION['groupid']); // change me later
		else
			$data['sessiondata'] = $this->Session_expert->get_session($_SESSION['sessionId']);

		// set variables
		$data['title'] = "Schedule";

		// Build top schedule row
		$data['toprow'] = $this->buildTopRow($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate);
		$data['firstcolumn'] = $this->buildFirstColumns($data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount);

		$data['schedule'] = $this->buildSchedule($data['sessiondata']->scheduleType, $data['sessiondata']->id); // sessionId

		$data['availablesessions'] = $this->buildSessionTree($this->Session_expert->get_all_active_sessions_for_user($_SESSION['userid']));

		$this->loadview('schedule', $data);
		
	}

	private function buildSchedule($sessionType, $sessionId)
	{
		//@todo this is for weekly only
		// index[i,j] = members: objects(name, shiftdata)
		$scheduledata = $this->Schedule_expert->get_current_weekly_schedule($sessionType, $sessionId);
		$userrelations = $this->Person_expert->getPeopleAsCellFormat();

		//$hello = new models\Cell("Sean");
		if(empty($scheduledata))
			return NULL;

		foreach($scheduledata as $row)
		{
			$schedule[$row['time']][$row['day']][] = new models\Cell($userrelations[$row['userId']], $row['userId']);
		}

		return $schedule;
	}

	public function changesession($sessionid)
	{
		$_SESSION['sessionId'] = $sessionid;
		$this->index();
	}


	private function buildSessionTree($sessionArray)
	{
		$returnVal = array();

		foreach($sessionArray as $session)
		{
			$returnVal[$session['groupname']][] = $session;
		}

		return $returnVal;
	}

	private function buildTopRow($sessionType, $startDate, $endDate)
	{
		$now = time();
		
		/* first we need to know the schedule type
			r = repeating weekly
			s = static
		*/

		$weekrange = $this->Schedule_expert->week_range($now);

//		if($sessionType == "r")
//		{
			$returnVal['days'] = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
			$returnVal['dayindex'] = array("su", "mo", "tu", "we", "th", "fr", "sa");

			$date = strtotime($weekrange[0]); // first date of this week
			foreach($returnVal['days'] as $day)
			{
				if($date > $endDate)
					break;

				$returnVal['date'][] = date('j', $date);

				$date = strtotime("tomorrow", $date);
			}

/*		}
		else
		{
			$date = $startDate;
			while($date <= $endDate)
			{
				$returnVal['days'][] = date("l", $date);
				$returnVal['dayindex'][] = substr(date("l", $date), 0, 2);

				$returnVal['date'][] = date('j', $date);

				$date = strtotime("tomorrow", $date);

			}
		}*/

		return $returnVal;

	}

	private function buildFirstColumns($startTime, $endTime, $timeIncrementAmount)
	{
		$time = $startTime;

		while($time < $endTime)
		{
			$returnVal[] = $time; // Add colon character to time

			$increment = $timeIncrementAmount * 60;
			$time += ($increment >= 60 ? 100 : $increment);
		}

		return $returnVal;
	}


}
