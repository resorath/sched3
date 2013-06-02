<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Populatetestdata extends CI_Controller {

	public function index()
	{

		$this->load_users();
		$this->load_sessions();
		$this->load_groups();
		$this->load_schedules();
		
		//$data['newsdata'] = $this->News_expert->get_news();
		
		// set variables
		$data['title'] = "Load Test Data";
		$data['message'] = "Loaded Test Data";

		//$this->loadview('front', $data);
		
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
	}

	private function load_sessions()
	{
		$this->Session_expert->truncate_sessions();

		$this->Session_expert->add_session('Test Session Spring 2013', 'r', '1367388000', '1375336800', '800', '1700', '1', '1', '1', '0', 1);
		$this->Session_expert->add_session('Test Session Spring 2013 NR', 's', '1367388000', '1375336800', '800', '1700', '1', '0', '0', '0', 1);
	}

	private function load_groups()
	{
		$this->Group_expert->truncate_groups();

		$this->Group_expert->add_group('Test Group', 7);

		$this->Person_expert->truncate_userGroups();

		$this->Person_expert->add_person_to_group(1, 1);
		$this->Person_expert->add_person_to_group(2, 1);
		$this->Person_expert->add_person_to_group(3, 1);
		$this->Person_expert->add_person_to_group(4, 1);
		$this->Person_expert->add_person_to_group(5, 1);
		$this->Person_expert->add_person_to_group(6, 1);
		$this->Person_expert->add_person_to_group(7, 1);
		$this->Person_expert->add_person_to_group(8, 1);
	}

	private function load_schedules()
	{
		$this->Schedule_expert->truncate_hours();

		// alincoln always works, floor the table
		$days = array("su", "mo", "tu", "we", "th", "fr", "sa");
		$bottomhour = 8;
		$tophour = 16;

		foreach($days as $day)
		{
			for($i=$bottomhour;$i<=$tophour;$i++)
			{
				$this->Schedule_expert->add_hour(1, 1, $i."00", null, $day);
			}

		}

		//gford works Tuesdays and Thursdays
		$days = array("tu", "th");
		foreach($days as $day)
		{
			for($i=$bottomhour;$i<=$tophour;$i++)
			{
				$this->Schedule_expert->add_hour(2, 1, $i."00", null, $day);
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
				$this->Schedule_expert->add_hour(5, 1, $i."00", null, $day);
			}

		}

	}

}