<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



function buildTopRow($sessionType, $startDate, $endDate, $displayDate = null)
{		
	$ci=& get_instance();

	if($displayDate == null)
		$displayDate = now();

	/* first we need to know the schedule type
		r = repeating weekly
		s = static
	*/

	$weekrange = $ci->Schedule_expert->week_range($displayDate);

//		if($sessionType == "r")
//		{
		//$returnVal['days'] = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		//$returnVal['dayindex'] = array("su", "mo", "tu", "we", "th", "fr", "sa");

		$returnVal = array();

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

function buildTopRowFreeWeek($sessionType, $startDate, $endDate)
{
	$returnVal = array();

	if($sessionType == "s")
	{
		$date = $startDate;
	}
	else
	{
		$date = strtotime("last Sunday");
		$endDate = strtotime("next Saturday", $date);
	}

	while($date <= $endDate)
	{
		$returnVal['days'][] = date("l", $date);
		$returnVal['dayindex'][] = strtolower(substr(date("l", $date), 0, 2));

		$returnVal['date'][] = date('j', $date);

		$returnVal['unixdate'][] = $date;

		$date = strtotime("tomorrow", $date);

	}


	return $returnVal;

}

function buildFirstColumns($startTime, $endTime, $timeIncrementAmount)
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

function buildInitialSchedule($sessionType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $displayDate = null)
{	
	// index[i,j] = members: objects(name, userid, celltype, $date, shiftData?)
	$returnVal = array();

	if($displayDate == null)
		$displayDate = now();

	if($sessionType == "s")
	{
		$date = $startDate;
	}
	else
	{
		$date = strtotime("last Sunday");
		$endDate = strtotime("next Saturday", $date);
	}

	while($date <= $endDate)
	{
		$time = $startTime;

		while($time < $endTime)
		{
			if($sessionType == "s")
				$returnVal[$time][$date][] = new models\Cell(null, null, models\Cell::$CELLTYPEVOID, realTime($date, $time));
			else
				$returnVal[$time][DChop($date)][] = new models\Cell(null, null, models\Cell::$CELLTYPEVOID, realTime($date, $time));


			$increment = $timeIncrementAmount * 60;
			$time += ($increment >= 60 ? 100 : $increment);
		}

		$date = strtotime("tomorrow", $date);

	}

	return $returnVal;

}

/* Get users bound to this session with their full name
 * return value:
 * $returnval[USERID] = fullname
 */
function getScheduledUsers($session)
{
	$ci=& get_instance();

	$users = $ci->Person_expert->getPeopleWorkingSession($session);

	$returnval = array();

	foreach($users as $user)
	{
		$returnval[$user['id']] = $user['firstName'] . " " . $user['lastName'];
	}

	return $returnval;


}


/* Gets total hours as a session
 * return value:
 * $returnval['scheduled'][USERID] = total scheduled hours
 * $returnval['available'][USERID] = total available hours
 */ 
function getTotalHours($session)
{
	$ci=& get_instance();

	$hours = $ci->Schedule_expert->getCombinedAvailability($session);

	$returnval = array();

	// This is going to save us on database lookups
	foreach($hours as $hour)
	{
		if($hour['isScheduled'] == 1)
		{
			if(isset($returnval['scheduled'][$hour['userId']]))
				$returnval['scheduled'][$hour['userId']]++;
			else
				$returnval['scheduled'][$hour['userId']] = 1;
		}

		if(isset($returnval['available'][$hour['userId']]))
			$returnval['available'][$hour['userId']]++;
		else
			$returnval['available'][$hour['userId']] = 1;

	}

	return $returnval;


}

// takes a date(unix timestamp) and time (hhmm) and converts to unix timestamp
function realTime($date, $time)
{
	$timeparsed = addColonToTime($time);
	$dateparsed = date("Y-m-d", $date);

	$rval = strtotime($dateparsed . " " . $timeparsed);
	
	return $rval;

}

// takes a day (mo, tu, etc) and time (hhmm) and converts it to a relative unix timestamp
function virtualTime($day, $time)
{
	$timeparsed = addColonToTime($time);
	$dateparsed = date("Y-m-d", strtotime(DMap($day)));

	$rval = strtotime($dateparsed . " " . $timeparsed);
	
	return $rval;
}

function toTime($dayte, $time)
{
	if(is_numeric($dayte)) // unix date
		return realTime($dayte, $time);
	else // relative day
		return virtualTime($dayte, $time);

}

function addColonToTime($time)
{
	return strrev(substr(strrev($time), 0, 2) . ":" . substr(strrev($time), 2));
}

function removeColonFromTime($time)
{
	return str_replace(":", "", $time);
}

// converts a datestamp to a two character day
function DChop($date)
{
	return substr(strtolower(date("D", $date)), 0, 2);

}

// Converts a two character day to a full day
function DMap($da)
{
	switch($da)
	{
		case "mo":
			return "Monday";
		case "tu":
			return "Tuesday";
		case "we":
			return "Wednesday";
		case "th":
			return "Thursday";
		case "fr":
			return "Friday";
		case "sa":
			return "Saturday";
		case "su":
			return "Sunday";
		default:
			return null;
	}
}

