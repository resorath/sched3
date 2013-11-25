<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



function buildTopRow($sessionType, $startDate, $endDate, $displayDate)
{		
	$ci=& get_instance();

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

function buildInitialSchedule($sessionType, $startDate, $endDate, $startTime, $endTime, $timeIncrementAmount, $displayDate)
{	
	// index[i,j] = members: objects(name, userid, celltype, $date, shiftData?)
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

// takes a date(unix timestamp) and time (hhmm) and converts to unix timestamp
function realTime($date, $time)
{
	$timeparsed = addColonToTime($time);
	$dateparsed = date("Y-m-d", $date);

	$rval = strtotime($dateparsed . " " . $timeparsed);
	
	return $rval;

}

function addColonToTime($time)
{
	return strrev(substr(strrev($time), 0, 2) . ":" . substr(strrev($time), 2));
}

function removeColonFromTime($time)
{
	return str_replace(":", "", $time);
}

function DChop($date)
{
	return substr(strtolower(date("D", $date)), 0, 2);

}