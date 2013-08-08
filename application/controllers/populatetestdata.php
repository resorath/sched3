<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Populatetestdata extends MY_Controller {

	public function index()
	{

		$this->load_users();
		$this->load_sessions();
		$this->load_groups();
		$this->load_roles();
		$this->load_repeating_schedule();
		$this->load_static_schedule();
		$this->load_exception_schedule();
		
		//$data['newsdata'] = $this->News_expert->get_news();
		
		// set variables
		$data['messageheader'] = "Load Test Data";
		$data['messagetext'] = "Loaded Test Data</br>Load Date: " . date("Y-m-d H:i:s");
		$data['messagetype'] = "success";

		$this->loadview('message', $data);
		
	}

	private function load_users()
	{
		$this->Person_expert->truncate_people();

		$this->Person_expert->add_person('00100201', 'Abraham', 'Lincoln', 'alincoln');
		$this->Person_expert->add_person('00100202', 'Gerald', 'Ford', 'gford');
		$this->Person_expert->add_person('00100203', 'George', 'Washington', 'gwashing');
		$this->Person_expert->add_person('00100204', 'Ulysses S', 'Grant', 'usgrant');
		$this->Person_expert->add_person('00100205', 'Ronald', 'Reagan', 'rreagan');
		$this->Person_expert->add_person('00100206', 'Harry', 'Truman', 'htruman');
		$this->Person_expert->add_person('00100207', 'Richard', 'Nixon', 'rnixon');
		$this->Person_expert->add_person('00100208', 'Franklin Delano', 'Roosevelt', 'fdroosev');
		$this->Person_expert->add_person('00282497', 'Sean', 'Feil', 'sfeil');
	}
 
	private function load_sessions()
	{
		$this->Session_expert->truncate_sessions();

		$this->Session_expert->add_session('Test Session Spring 2013', 'r', '1367388000', '1375336800', '800', '1700', '1', 1,  '1', '1', '0');
		$this->Session_expert->add_session('Test Session Spring 2013 NR', 's', strtotime("July 1st, 2013"), strtotime("July 30th, 2013"), '800', '1700', '1', 1, '1', '0', '0');
		$this->Session_expert->add_session('Cowbell Session Spring 2013 NR', 'r', '1367388000', '1375336800', '800', '1700', '1', 2, '1', '0', '0');
	}

	private function load_groups()
	{
		$this->Group_expert->truncate_groups();

		$this->Group_expert->add_group('Test Group', 7);
		$this->Group_expert->add_group('Cowbells Only', 7);

		$this->Person_expert->truncate_userGroups();

		$this->Person_expert->add_person_to_group(1, 1, TRUE);
		$this->Person_expert->add_person_to_group(2, 1, TRUE);
		$this->Person_expert->add_person_to_group(3, 1, TRUE);
		$this->Person_expert->add_person_to_group(4, 1, TRUE);
		$this->Person_expert->add_person_to_group(5, 1, TRUE);
		$this->Person_expert->add_person_to_group(6, 1, TRUE);
		$this->Person_expert->add_person_to_group(7, 1, TRUE);
		$this->Person_expert->add_person_to_group(8, 1, TRUE);

		$this->Person_expert->add_person_to_group(9, 1, TRUE);
		$this->Person_expert->add_person_to_group(9, 2, FALSE);
	}

	private function load_roles()
	{
		$this->Role_expert->truncate_roles();

		$this->Role_expert->add_role("CANLOGIN", "User can log into the scheduler");
		$this->Role_expert->add_role("HASSCHEDULE", "User has a unique schedule");
		$this->Role_expert->add_role("ISSUPER", "User is a super user and can control sensitive aspects of scheduler");
		$this->Role_expert->add_role("CANCHANGEUSERS", "User can add, remove and change users");
		$this->Role_expert->add_role("CANCHANGESESSIONS", "User can add, remove and change sessions");
		$this->Role_expert->add_role("DEBUGGER", "User is saturated with debugging information");

		$this->Role_expert->set_role(9, 1, 1);
		$this->Role_expert->set_role(9, 2, 1);
		$this->Role_expert->set_role(9, 3, 1);
		$this->Role_expert->set_role(9, 4, 1);
		$this->Role_expert->set_role(9, 5, 1);
		$this->Role_expert->set_role(9, 6, 1);

		$this->Role_expert->set_role(9, 1, 2);
		$this->Role_expert->set_role(9, 6, 2);


		$this->Role_expert->add_controller_role(3, "testSuperController");

		
	}

	private function load_static_schedule()
	{
		for($i=1; $i < 30; $i++)
		{
			$datespre[] = "July $i, 2013";
		}

		$dates = array_map("strtotime", $datespre);

		$bottomhour = 8;
		$tophour = 16;

		//alincoln works all JuLy
		foreach($dates as $date)
		{
			for($i=$bottomhour;$i<=$tophour;$i++)
			{
				$this->Schedule_expert->add_hour(2, 1, $i."00", $date, null, TRUE);
			}
		}

	}

	private function load_exception_schedule()
	{
		$this->Schedule_expert->truncate_exception_hours();

		// Wed July 23 is a Holiday for some reason -  10 - 2
		$bottomhour = 10;
		$tophour = 14;
		$date = strtotime("July 23, 2013");
		for($i=$bottomhour;$i<=$tophour;$i++)
		{
			// Exception hours
			$this->Schedule_expert->add_exception_hour(1, 0, $i."00", $date, null, TRUE, TRUE);
		}

		// Fill the rest with invalid exception hours
		$this->Schedule_expert->add_hour(1, 0, "800", $date, null, TRUE, TRUE);
		$this->Schedule_expert->add_hour(1, 0, "900", $date, null, TRUE, TRUE);
		$this->Schedule_expert->add_hour(1, 0, "1500", $date, null, TRUE, TRUE);
		$this->Schedule_expert->add_hour(1, 0, "1600", $date, null, TRUE, TRUE);

	}

	private function load_repeating_schedule()
	{
		$this->Schedule_expert->truncate_hours();

		// Do invalid hours
		$this->Schedule_expert->add_hour(1, 0, "800", null, "sa", TRUE);
		$this->Schedule_expert->add_hour(1, 0, "900", null, "sa", TRUE);
		$this->Schedule_expert->add_hour(1, 0, "1500", null, "sa", TRUE);
		$this->Schedule_expert->add_hour(1, 0, "1600", null, "sa", TRUE);
		$this->Schedule_expert->add_hour(1, 0, "800", null, "su", TRUE);
		$this->Schedule_expert->add_hour(1, 0, "900", null, "su", TRUE);
		$this->Schedule_expert->add_hour(1, 0, "1500", null, "su", TRUE);
		$this->Schedule_expert->add_hour(1, 0, "1600", null, "su", TRUE);

		// Wed July 24 is a Holiday for some reason - no one
		$bottomhour = 8;
		$tophour = 16;
		$date = strtotime("July 24, 2013");
		for($i=$bottomhour;$i<=$tophour;$i++)
		{
			// Exception hours
			$this->Schedule_expert->add_hour(1, 0, $i."00", $date, null, TRUE, TRUE);
		}

		// Tues, July 23 only sean and nixon works exception 10 - 2
		$bottomhour = 10;
		$tophour = 14;
		$date = strtotime("July 23, 2013");
		for($i=$bottomhour;$i<=$tophour;$i++)
		{
			// Exception hours
			$this->Schedule_expert->add_hour(1, 9, $i."00", $date, null, TRUE, TRUE);
			$this->Schedule_expert->add_hour(1, 7, $i."00", $date, null, TRUE, TRUE);
		}


		// alincoln always works, floor the table
		$days = array("su", "mo", "tu", "we", "th", "fr", "sa");
		$bottomhour = 8;
		$tophour = 16;

		foreach($days as $day)
		{
			for($i=$bottomhour;$i<=$tophour;$i++)
			{
				$this->Schedule_expert->add_hour(1, 1, $i."00", null, $day, TRUE);
			}

		}

		//gford works Tuesdays and Thursdays
		$days = array("tu", "th");
		foreach($days as $day)
		{
			for($i=$bottomhour;$i<=$tophour;$i++)
			{
				$this->Schedule_expert->add_hour(1,2 , $i."00", null, $day, TRUE);
			}

		}

		//rregan works 10 to 2 every day
		$days = array("su", "mo", "tu", "we", "th", "fr", "sa");
		$bottomhour = 10;
		$tophour = 14;
		foreach($days as $day)
		{
			for($i=$bottomhour;$i<=$tophour;$i++)
			{
				$this->Schedule_expert->add_hour(1, 5, $i."00", null, $day, TRUE);
			}

		}


		//sfeil works 8 to 12 every monday
		$days = array("mo");
		$bottomhour = 8;
		$tophour = 12;
		foreach($days as $day)
		{
			for($i=$bottomhour;$i<=$tophour;$i++)
			{
				$this->Schedule_expert->add_hour(1, 9, $i."00", null, $day, TRUE);
			}

		}


	}

}