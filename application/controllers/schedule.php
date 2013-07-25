<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends MY_Controller {

	public function index()
	{

		if(!isset($_SESSION['sessionId']))
		{
			$data['sessiondata'] = $this->Session_expert->get_primary_session($_SESSION['groupid']);
			$_SESSION['sessionId'] = $data['sessiondata']->id;
		}
		else
		{
			$data['sessiondata'] = $this->Session_expert->get_session($_SESSION['sessionId']);
		}

		if(!isset($_SESSION['displayDate']))
			$_SESSION['displayDate'] = time();


		// set variables
		$data['title'] = "Schedule";

		// Build top schedule row
		$data['toprow'] = $this->buildTopRow($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $_SESSION['displayDate']);
		$data['firstcolumn'] = $this->buildFirstColumns($data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount);

		$data['schedule'] = $this->buildSchedule($data['sessiondata']->scheduleType, $data['sessiondata']->id); // sessionId

		$data['availablesessions'] = $this->buildSessionTree($this->Session_expert->get_all_active_sessions_for_user($_SESSION['userid']));

		if($this->input->get('start') !== FALSE)
			$data['flash_left_arrow'] = TRUE;

		if($this->input->get('end') !== FALSE)
			$data['flash_right_arrow'] = TRUE;

		$this->loadview('schedule', $data);
		
	}

	private function buildSchedule($sessionType, $sessionId)
	{
		// index[i,j] = members: objects(name, shiftdata)
		$scheduledata = $this->Schedule_expert->get_weekly_schedule($sessionType, $sessionId, $_SESSION['displayDate']);
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
		// need some group security here
		$_SESSION['sessionId'] = $sessionid;
		
		redirect($this->router->class);
	}

	public function advanceWeek()
	{
		if(!isset($_SESSION['displayDate']))
			$_SESSION['displayDate'] = strtotime("next week", time());
		else
			$_SESSION['displayDate'] = strtotime("next week", $_SESSION['displayDate']);

		// Check if we went later than the end of session, and if we did, revert the change
		$session = $this->Session_expert->get_session($_SESSION['sessionId']);
		$week = $this->Schedule_expert->week_range($_SESSION['displayDate']);

		if($session->endDate < strtotime($week[0]))
		{
			$_SESSION['displayDate'] = strtotime("last week", $_SESSION['displayDate']);
			redirect($this->router->class . "?end");
		}
		
		redirect($this->router->class);
	}

	public function recedeWeek()
	{
		if(!isset($_SESSION['displayDate']))
			$_SESSION['displayDate'] = strtotime("last week", time());
		else
			$_SESSION['displayDate'] = strtotime("last week", $_SESSION['displayDate']);

		// Check if we went later than the end of session, and if we did, revert the change
		$session = $this->Session_expert->get_session($_SESSION['sessionId']);
		$week = $this->Schedule_expert->week_range($_SESSION['displayDate']);

		if($session->startDate > strtotime($week[1]))
		{
			$_SESSION['displayDate'] = strtotime("next week", $_SESSION['displayDate']);
			redirect($this->router->class . "?start");
		}
		
		redirect($this->router->class);
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

	private function buildTopRow($sessionType, $startDate, $endDate, $displayDate)
	{		
		/* first we need to know the schedule type
			r = repeating weekly
			s = static
		*/

		$weekrange = $this->Schedule_expert->week_range($displayDate);

//		if($sessionType == "r")
//		{
			//$returnVal['days'] = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
			//$returnVal['dayindex'] = array("su", "mo", "tu", "we", "th", "fr", "sa");

			$date = strtotime($weekrange[0]); // first date of this week

			// if session starts after the first day of the week
			if($date < $startDate)
				$date = $startDate;

			/*
			foreach($returnVal['days'] as $day)
			{
				if($date > $endDate)
					break;

				$returnVal['date'][] = date('j', $date);

				$date = strtotime("tomorrow", $date);
			}*/

			$endOfWeek = strtotime($weekrange[1]);

			while($date <= $endDate && $date <= $endOfWeek)
			{
				$returnVal['days'][] = date("l", $date);
				$returnVal['dayindex'][] = strtolower(substr(date("l", $date), 0, 2));

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
