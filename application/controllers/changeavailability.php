<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Changeavailability extends MY_Controller {

	public function index()
	{
		// set variables
		$data['title'] = "Change Availabilility";

		$session = $_SESSION['sessionId'];

		$data['sessiondata'] = $this->Session_expert->get_session($session);

		if($data['sessiondata']->scheduleType == "s")
			$data['toprow'] = buildTopRowFreeWeek($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $_SESSION['displayDate']);
		else
			$data['toprow'] = buildTopRowFreeWeek($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $_SESSION['displayDate']);


		$data['firstcolumn'] = buildFirstColumns($data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount);

		$data['schedule'] = buildInitialSchedule($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount, $_SESSION['displayDate']);

		$this->buildSchedule($data['schedule'], $data['sessiondata']->scheduleType, $data['sessiondata']->id, $_SESSION['userid']);

		$this->loadview('changeavailability', $data);
		
	}

	public function buildSchedule(&$schedule, $sessionType, $sessionId, $userId)
	{
		// index[i,j] = members: objects(name, userid, celltype, $date, shiftData?)
		$scheduledata =$this->Schedule_expert->getAvailabilityForUser($sessionId, $userId);
		$invalidblocks =$this->Schedule_expert->get_regular_invalid_hours($sessionId);

		if(empty($scheduledata))
			return NULL;

		foreach($scheduledata as $row)
		{
			if($sessionType == "s")
				$schedule[$row['time']][$row['date']][0]->userid = $userId;
			else
				$schedule[$row['time']][$row['day']][0]->userid = $userId;
		}

		foreach($invalidblocks as $row)
		{
			if($sessionType == "s")
				$schedule[$row['time']][$row['date']][0]->userid = 0;
			else
				$schedule[$row['time']][$row['day']][0]->userid = 0;
		}

		return $schedule;
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */