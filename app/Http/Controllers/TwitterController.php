<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hashtag;
use Carbon\Carbon;

class TwitterController extends Controller
{
    public function search(Request $request)
    {    	    

    	//$twitter = new TwitterApi;
    	//$tweets = $twitter->search('hashtag', $request->hashtag);
    	//echo "<PRE>";print_r($tweets);

    	$hashtag = new Hashtag($request->hashtag);

    	//echo '<pre>';print_r($hashtag->getTweets());

    	//$dateTime = 'Fri Aug 25 01:50:38 +0000 2017';
    	//$dateTimeCarbon = Carbon::createFromFormat('d/m/Y', $dateTime, config('app.timezone'));
    	$carbon = new Carbon('Fri Aug 25 01:50:38 +0000 2017', 'UTC');
    	$dateTimeCarbon = Carbon::createFromFormat('d/m/Y', $carbon->date, config('app.timezone'));
		echo '<pre>';print_r($dateTimeCarbon);
    	return view('twitter.search');
    }

}
