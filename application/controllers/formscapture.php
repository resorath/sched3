<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formscapture extends MY_Controller {

	public function index()
	{

	}

	public function sessionSetFlag($sessionId, $flag, $setting)
	{
		if(!user_has_role("CANCHANGESESSIONS"))
			return false;

		if($setting == 1 || $setting == 0)
			$this->Session_expert->set_flag($sessionId, $flag, $setting);

	}

	public function sessionGetFlag($sessionId, $flag)
	{
		if(!user_has_role("CANCHANGESESSIONS"))
			return false;

		echo($this->Session_expert->get_flag($sessionId, $flag));


	}

	public function sessionToggleFlag($sessionId, $flag)
	{
		if(!user_has_role("CANCHANGESESSIONS"))
			return false;

		$flagState = $this->Session_expert->get_flag($sessionId, $flag);

		// flip the flag
		$this->sessionSetFlag($sessionId, $flag, (1-$flagState)); 

		echo(1-$flagState);

	}

	public function sessionMakePrimary($sessionId)
	{
		if(!user_has_role("CANCHANGESESSIONS"))
			return false;

		$this->Session_expert->make_primary($sessionId);

		echo "1";
	}

	public function sessionDelete($sessionId)
	{
		if(!user_has_role("CANCHANGESESSIONS"))
			return false;

		$reason = $this->Session_expert->delete($sessionId);

		if($reason === true)
			echo "1";
		else
			echo $reason;
	}

	public function sessionInvalidateHour($sessionId, $hour)
	{
		if(!user_has_role("CANCHANGESESSIONS"))
			return false;

		$this->Session_expert->invalidateHour($sessionId, $hour);

	}

	public function sessionValidateHour($sessionId, $hour)
	{
		if(!user_has_role("CANCHANGESESSIONS"))
			return false;

		$this->Session_expert->validateHour($sessionId, $hour);
	}

}