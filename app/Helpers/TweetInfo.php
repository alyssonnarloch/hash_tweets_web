<?php

use Carbon\Carbon;

class TweetInfo
{
	public static function displayDateTime($createdAt)
	{
		$currentDateTime = Carbon::now();
        $currentDateTime->timezone = 'UTC';
	
        $tweetDateTime = Carbon::parse($createdAt);

        $diffInSeconds = $currentDateTime->diffInSeconds($tweetDateTime);
        if($diffInSeconds < 60)
        	return $diffInSeconds . ' seg';

        $diffInMinutes = $currentDateTime->diffInMinutes($tweetDateTime);
        if($diffInMinutes < 60)
        	return $diffInMinutes . ' min';

        $diffInHours = $currentDateTime->diffInHours($tweetDateTime);
    	if($diffInHours < 24)
    		return $diffInHours . ' h';

    	return $tweetDateTime->day . ' de ' . substr($tweetDateTime->format('F'), 0, 3);
	}
}