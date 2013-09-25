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

		$this->buildSchedule($data['schedule'], $data['sessiondata']->scheduleType, $data['sessiondata']->id);

		$this->loadview('managesessions/invalidatehours', $data);
	}

	public function buildSchedule(&$schedule, $sessionType, $sessionId)
	{
		// index[i,j] = members: objects(name, userid, celltype, $date, shiftData?)
		$scheduledata =$this->Schedule_expert->get_regular_invalid_hours($sessionId);

		if(empty($scheduledata))
			return NULL;

		foreach($scheduledata as $row)
		{
			// Handle a invalid hour cell
			if($row['userId'] == 0)
			{
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */