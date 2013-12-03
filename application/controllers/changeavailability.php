<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Changeavailability extends MY_Controller {

	public function index()
	{
		// set variables
		$data['title'] = "Change Availabilility";

		$session = $_SESSION['sessionId'];

		$data['sessiondata'] = $this->Session_expert->get_session($session);

		if($data['sessiondata']->scheduleType == "s")
		{
			$data['toprow'] = buildTopRowFreeWeek($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $_SESSION['displayDate']);
		
		}
		else
		{
			$data['toprow'] = buildTopRowFreeWeek($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $_SESSION['displayDate']);
			$data['exceptions'] = $this->buildExceptions($this->Schedule_expert->get_exception_hours($session), $this->Schedule_expert->get_exception_time_including_availability_for_user($session, $_SESSION['userid']));
		
		}

		$data['firstcolumn'] = buildFirstColumns($data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount);

		$data['schedule'] = buildInitialSchedule($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount, $_SESSION['displayDate']);

		$data['availablesessions'] = $this->buildSessionTree($this->Session_expert->get_all_active_sessions_for_user($_SESSION['userid']));

		$this->buildSchedule($data['schedule'], $data['sessiondata']->scheduleType, $data['sessiondata']->id, $_SESSION['userid']);

		$this->loadview('changeavailability', $data);
		
	}

	public function buildExceptions($availableexceptions, $userexceptions)
	{
		$returnval = array();


		$i = 0;
		foreach($availableexceptions as $exception)
		{
			$returnval[$i]['date'] = $exception['time'];
			$returnval[$i]['scheduled'] = false;

			if(count($userexceptions) > 0)
			{
				foreach($userexceptions as $userexception)
				{
					if($exception['time'] == toTime($userexception['date'], $userexception['time']))
					{
						$returnval[$i]['scheduled'] = true;
						break;
					}

				}
			}


			$i++;
		}


		return $returnval;

	}

	public function changesession($sessionid)
	{
		// need some group security here
		$_SESSION['sessionId'] = $sessionid;
		$_SESSION['groupid'] = $this->Session_expert->get_session_group($sessionid);

		redirect($this->router->class);
	}

	public function buildSchedule(&$schedule, $sessionType, $sessionId, $userId)
	{
		// index[i,j] = members: objects(name, userid, celltype, $date, shiftData?)
		$scheduledata =$this->Schedule_expert->getAvailabilityForUser($sessionId, $userId);
		$invalidblocks =$this->Schedule_expert->get_regular_invalid_hours($sessionId);

		if(is_array($scheduledata))
		{
			foreach($scheduledata as $row)
			{
				if($sessionType == "s")
					$schedule[$row['time']][$row['date']][0]->userid = $userId;
				else
					$schedule[$row['time']][$row['day']][0]->userid = $userId;
			}
		}

		if(is_array($invalidblocks))
		{
			foreach($invalidblocks as $row)
			{
				if($sessionType == "s")
					$schedule[$row['time']][$row['date']][0]->userid = 0;
				else
					$schedule[$row['time']][$row['day']][0]->userid = 0;
			}
		}

		return $schedule;
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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */