<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managesessions extends MY_Controller {

	public function index()
	{
		//$this->load->model('News_expert');
		
		//$data['newsdata'] = $this->News_expert->get_news();
		
		// set variables
		$data['title'] = "Manage Sessions";

		$data['sessions'] = $this->Session_expert->get_all_sessions();

		$this->loadview('managesessions/select', $data);
		
	}

	public function edit($session, $postedit = FALSE)
	{
		$data['session'] = $this->Session_expert->get_session($session);

		if($data['session'] == null)
		{
			$this->create();
			return;
		}

		$_SESSION['sessionedit'] = $session;

		$data['title'] = $data['session']->title . " - Manage Sessions";

		if($postedit)
		{
			$data['notify_message'] = "Save Successful";
			$data['notify_type'] = "success";
		}

		$this->loadview('managesessions/edit', $data);

	}

	public function create()
	{
		$data['title'] = "Create Session - Manage Sessions";

		$data['groups'] = $this->Person_expert->getGroupsWithUserPriv($_SESSION['userid'], "CANCHANGESESSIONS");

		$this->loadview('managesessions/create', $data);
	}

	public function createpost()
	{
		$data['title'] = "Create Session - Manage Sessions";

		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Session Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('groupid', 'Group', 'required|css_clean');
		$this->form_validation->set_rules('scheduletype', 'Session Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('startdate', 'First Day', 'trim|required|callback_validation_is_date|xss_clean');
		$this->form_validation->set_rules('enddate', 'Last Day', 'trim|required|callback_validation_is_date|callback_validation_date_after_another_Date['. $_POST['startdate'] .']|xss_clean');
		$this->form_validation->set_rules('starttime', 'Start Time of First Shift', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('endtime', 'End Time of First Shift', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('timeincrementamount', 'Hours Per Shift', 'trim|required|is_natural|xss_clean');


		if($this->form_validation->run() === FALSE)
		{
			$this->loadview('managesessions/create', $data);
		}
		else
		{
			$sessionId = $this->Session_expert->add_session($_POST['title'], $_POST['scheduletype'], strtotime($_POST['startdate']), strtotime($_POST['enddate']), $_POST['starttime'], $_POST['endtime'], $_POST['timeincrementamount'], $_POST['groupid']);
			$this->edit($sessionId, TRUE);

		}

	}

	public function createschedule($session)
	{
		// set variables
		$data['title'] = "Create Schedule";

		$data['sessiondata'] = $this->Session_expert->get_session($session);

		$data['toprow'] = buildTopRowFreeWeek($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $_SESSION['displayDate']);

		$data['firstcolumn'] = buildFirstColumns($data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount);

		$data['schedule'] = buildInitialSchedule($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount, $_SESSION['displayDate']);
		
		$this->buildScheduleWithInvalids($data['schedule'], $data['sessiondata']->scheduleType, $data['sessiondata']->id, $_SESSION['userid']);

		$this->buildScheduleWithAvailability($data['schedule'], $data['sessiondata']->scheduleType, $data['sessiondata']->id, $_SESSION['userid']);

		$this->loadview('managesessions/createschedule', $data);

	}


	public function buildScheduleWithAvailability(&$schedule, $sessionType, $sessionId)
	{
		// index[i,j] = members: objects(name, userid, celltype, $date, shiftData?)
		$scheduledata =$this->Schedule_expert->getCompiledAvailability($sessionId);
		$userrelations = $this->Person_expert->getPeopleAsCellFormat();

		if(empty($scheduledata))
			return NULL;

		foreach($scheduledata as $row)
		{
			if($sessionType == "r") // repeating weekly
			{
				if($schedule[$row['time']][$row['day']][0]->userid === 0)
				{

					$schedule[$row['time']][$row['day']] = array();
					$schedule[$row['time']][$row['day']][] = new models\Cell(null, 0, models\Cell::$CELLTYPEVOID);
				}
				else
				{
					$schedule[$row['time']][$row['day']][] = new models\Cell($userrelations[$row['userId']], $row['userId'], models\Cell::$CELLTYPEPERSON);
				}
			}
			else // static
			{
				if($schedule[$row['time']][$row['date']][0]->userid === 0)
				{

					$schedule[$row['time']][$row['date']] = array();
					$schedule[$row['time']][$row['date']][] = new models\Cell(null, 0, models\Cell::$CELLTYPEVOID);
				}
				else
				{
					$schedule[$row['time']][$row['date']][] = new models\Cell($userrelations[$row['userId']], $row['userId'], models\Cell::$CELLTYPEPERSON);
				}

			}
		}

		return $schedule;
	}

	public function holidayhours($session)
	{
		$data['title'] = "Holiday Hours - Manage Sessions";
		$data['sessiondata'] = $this->Session_expert->get_session($session);
		$data['holidayhours'] = $this->Schedule_expert->get_exception_hours($session);
		$data['exceptiontime'] = $this->Schedule_expert->get_exception_time_invalid_hours($session);

		$exceptions = array();
		$exceptionsinvalid = array();

		// transform the data into day[hour] tuples
		$i=0;

		if($data['holidayhours'] != null)
		{
			foreach($data['holidayhours'] as $holidayhour)
			{
				$datecode = strtotime(date("Y-m-d", $holidayhour['time']));
				$timecode = strtotime(date("H:i", $holidayhour['time']));

				$exceptions[$datecode][$i]['type'] = 'valid';
				$exceptions[$datecode][$i]['timecode'] = $timecode;	
				$i++;
			}
		}

		if($data['exceptiontime'] != null)
		{
			foreach($data['exceptiontime'] as $invalidhour)
			{
				$datecode = $invalidhour['date'];
				$timecode = strtotime(addColonToTime($invalidhour['time']));

				$exceptions[$datecode][$i]['type'] = 'invalid';
				$exceptions[$datecode][$i]['timecode'] = $timecode;
				$i++;
			}
		}

		$exceptions_sorted = array();
		foreach($exceptions as $ekey => $exception)
		{
			$exceptions_sorted[$ekey] = $exception;
			usort($exceptions_sorted[$ekey], array('Managesessions', 'sortdatecodes'));

		}

		$data['exceptions'] = $exceptions_sorted;

		$this->loadview('managesessions/holidayhours', $data);
	}

	private static function sortdatecodes($a, $b)
	{
		if ($a['timecode'] == $b['timecode']) {
        	return 0;
	    }
	    return ($a['timecode'] < $b['timecode']) ? -1 : 1;

	}

	public function invalidatehours($session)
	{

		$data['title'] = "Invalidate Hours - Manage Sessions";
		$data['sessiondata'] = $this->Session_expert->get_session($session);

		if($data['sessiondata']->scheduleType == "s")
			$data['toprow'] = buildTopRowFreeWeek($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $_SESSION['displayDate']);
		else
			$data['toprow'] = buildTopRowFreeWeek($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $_SESSION['displayDate']);


		$data['firstcolumn'] = buildFirstColumns($data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount);

		$data['schedule'] = buildInitialSchedule($data['sessiondata']->scheduleType, $data['sessiondata']->startDate, $data['sessiondata']->endDate, $data['sessiondata']->startTime, $data['sessiondata']->endTime, $data['sessiondata']->timeIncrementAmount, $_SESSION['displayDate']);

		$this->buildScheduleWithInvalids($data['schedule'], $data['sessiondata']->scheduleType, $data['sessiondata']->id);

		$this->loadview('managesessions/invalidatehours', $data);
	}

	public function buildScheduleWithInvalids(&$schedule, $sessionType, $sessionId)
	{
		// index[i,j] = members: objects(name, userid, celltype, $date, shiftData?)
		$scheduledata =$this->Schedule_expert->get_regular_invalid_hours($sessionId);

		if(empty($scheduledata))
			return NULL;

		foreach($scheduledata as $row)
		{
			// Handle a invalid hour cell
			if($row['userId'] === '0')
			{
				if($sessionType == "s")
					$schedule[$row['time']][$row['date']][0]->userid = 0;
				else
					$schedule[$row['time']][$row['day']][0]->userid = 0;
				//$schedule[$row['time']][$row['day']] = array();
				//$schedule[$row['time']][$row['day']][] = new models\Cell(null, 0, models\Cell::$CELLTYPEVOID, );
			}
		}

		return $schedule;
	}

	public function editpost()
	{
		$this->load->library('form_validation');
		$data['session'] = $this->Session_expert->get_session($_SESSION['sessionedit']);
		$data['title'] = $data['session']->title . " - Manage Sessions";

		$this->form_validation->set_rules('title', 'Session Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('scheduletype', 'Session Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('startdate', 'First Day', 'trim|required|callback_validation_is_date|xss_clean');
		$this->form_validation->set_rules('enddate', 'Last Day', 'trim|required|callback_validation_is_date|callback_validation_date_after_another_Date['. $_POST['startdate'] .']|xss_clean');
		$this->form_validation->set_rules('starttime', 'Start Time of First Shift', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('endtime', 'End Time of First Shift', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('timeincrementamount', 'Hours Per Shift', 'trim|required|is_natural|xss_clean');


		if($this->form_validation->run() === FALSE)
		{
			$this->loadview('managesessions/edit', $data);
		}
		else
		{
			$this->Session_expert->edit_session($_POST['title'], $_POST['scheduletype'], strtotime($_POST['startdate']), strtotime($_POST['enddate']), $_POST['starttime'], $_POST['endtime'], $_POST['timeincrementamount'], $data['session']->id);
			$this->edit($data['session']->id, TRUE);

		}

	}

	public function validation_is_date($str)
	{
		if(strtotime($str) !== FALSE)
			return TRUE;
		else
		{
			$this->form_validation->set_message('validation_is_date', 'The %s field must be a valid date.');
			return FALSE;
		}
	}

	public function validation_date_after_another_date($newer, $older)
	{
		if(strtotime($newer) > strtotime($older))
			return true;
		else
		{
			$this->form_validation->set_message('validation_date_after_another_Date', 'The %s field must be after the start date.');
			return false;
		}


	}

	// Form action
	public function deleteFullDayException($sessionId, $datecode)
	{
		//datecode comes in as unix time
		$this->Schedule_expert->delete_hour_exceptions_full_day($sessionId, $datecode);

	} 

	// Form action
	public function deleteSpecificTimeException($sessionId, $datecode)
	{
		//datecode comes in as daytime-hourtime
		$splitcode = explode("-", $datecode);
		$this->Schedule_expert->delete_hour_exceptions($sessionId, date("Gi", $splitcode[1]), $splitcode[0]);

	}

	//Post action
	public function createExceptionHour()
	{
		$exceptiondate = "";
		$sessionid = "";
		$availables = array();
		$unavailables = array();
		foreach($_POST as $key => $value)
		{
			if($key == "exceptiondate")
			{
				$exceptiondate = $value;
				continue;
			}

			if($key == "sessionid")
			{
				$sessionid = $value;
				continue;
			}

			if($value == "available")
			{
				$availables[] = $key;
			}

			if($value == "invalid")
			{
				$unavailables[] = $key;
			}

		}

		foreach($availables as $value)
		{
			$this->Schedule_expert->add_exception_hour($sessionid, strtotime($exceptiondate . " " . $value));
		}

		foreach($unavailables as $value)
		{
			$this->Schedule_expert->add_hour($sessionid, 0, removeColonFromTime($value), strtotime($exceptiondate), null, TRUE, TRUE);
		}

		$this->holidayhours($sessionid);

	}
}