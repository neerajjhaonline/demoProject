<?php
define("timeZone", "America/New_York");
define("PAGINATENO", 15);

function priorityHrs($priority)
{
	$hrs = 0;

	switch ($priority) {
		case 'Urgent':
			$hrs = 3;
		break;

		case 'Standard':
			$hrs = 24;
		break;
		
		default:
			$hrs = 0;
		break;
	}

	return $hrs; 
}

function convertSeconds($dateTime)
{
	return strtotime($dateTime);
}


function calculateDeadline($hr, $dateTime)
{
	return $deadline = date('Y-m-d H:i:s',strtotime('+'.$hr.' hours', strtotime($dateTime)));
}

function calculateActualTat($dateTime)
{
	$tat = array();
	date_default_timezone_set(timeZone);//sets timezone
	//$deadline = date('Y-m-d H:i:s',strtotime('+'.$hr.' hours', strtotime($dateTime))); //calculating actual deadline
	$date1    = strtotime($dateTime); //converting it to seconds
   	$date2    = strtotime(date("Y-m-d H:i:s")); //current date and time and converting it to seconds
   	$timeSeconds = $date1 - $date2; //difference between deadline and current date time
   	$tat['h']  = floor($timeSeconds / (60 * 60)); //calculatings hours
   	$timeSeconds -= $tat['h'] * (60 * 60);
   	$tat['m']  = round($timeSeconds / 60); //calculatings minutes
   	$timeSeconds -= $tat['m'] * 60;
   	$seconds = floor($timeSeconds); //calculatings seconds
   	return $tat;  
   
}

function currDate()
{
	date_default_timezone_set(timeZone);
	return	$date2 = date("Y-m-d H:i:s");
}