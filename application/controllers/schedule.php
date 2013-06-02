<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends MY_Controller {

	public function index()
	{
		//$this->load->model('News_expert');
		
		//$data['newsdata'] = $this->News_expert->get_news();
		$data['sessiondata'] = $this->Session_expert->get_primary_session(1); // change me later
		
		// set variables
		$data['title'] = "Schedule";

		// Build top schedule row
		$data['toprow'] = $this->buildTopRow($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate);
		$data['firstcolumn'] = $this->buildFirstColumns($data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount);

		$data['schedule'] = $this->buildSchedule(1);

		$this->loadview('schedule', $data);
		
	}

	private function buildSchedule($sessionId)
	{
		//@todo this is for weekly only
		// index[i,j] = members: objects(name, shiftdata)
		$scheduledata = $this->Schedule_expert->get_current_weekly_schedule($sessionId);
		//print_r($scheduledata);



	}

	private function buildTopRow($sessionType, $startDate, $endDate)
	{
		$now = time();
		/* first we need to know the schedule type
			r = repeating weekly
			s = static
		*/

		$weekrange = $this->Schedule_expert->week_range($now);

		if($sessionType == "r")
		{
			$returnVal['days'] = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

			$date = strtotime($weekrange[0]); // first date of this week
			foreach($returnVal['days'] as $day)
			{
				if($date > $endDate)
					break;

				$returnVal['date'][] = date('d', $date);

				$date = strtotime("tomorrow", $date);
			}

			return $returnVal;

		}

		// @todo NON-REPEATING WEEKLY

	}

	private function buildFirstColumns($startTime, $endTime, $timeIncrementAmount)
	{
		$time = $startTime;

		while($time < $endTime)
		{
			$returnVal[] = strrev(substr_replace(strrev($time), ":", 2, 0)); // Add colon character to time

			$increment = $timeIncrementAmount * 60;
			$time += ($increment >= 60 ? 100 : $increment);
		}

		return $returnVal;
	}


}
