<?php

use Carbon\Carbon;

class TweetInfo
{
	public static function displayDateTime($createdAt)
	{
        $locationMonths = Lang::get('datetime.months');
        $locationTimeUnits = Lang::get('datetime.time_units');

		$currentDateTime = Carbon::now();
        $currentDateTime->timezone = 'UTC';
	
        $tweetDateTime = Carbon::parse($createdAt);

        $diffInSeconds = $currentDateTime->diffInSeconds($tweetDateTime);
        if($diffInSeconds < 60){
        	return $diffInSeconds . ' ' . substr($locationTimeUnits['s'], 0, 3);
        }

        $diffInMinutes = $currentDateTime->diffInMinutes($tweetDateTime);
        if($diffInMinutes < 60){
        	return $diffInMinutes . ' ' . substr($locationTimeUnits['m'], 0, 3);
        }

        $diffInHours = $currentDateTime->diffInHours($tweetDateTime);
    	if($diffInHours < 24){
    		return $diffInHours . ' ' . substr($locationTimeUnits['h'], 0, 1);
        }

    	return $tweetDateTime->day . ' ' . __('text.of') . ' ' . substr($locationMonths[(int) $tweetDateTime->format('m')], 0, 3);
	}
}