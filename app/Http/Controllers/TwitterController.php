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

        if(!empty($request->hashtag))
        {
        	$hashtag = new Hashtag($request->hashtag);

            //echo '<pre>';
            //print_r($hashtag->countTweets(12));
            //print_r($hashtag->getTopRetweets(3));
            //die;
        }
    	return view('twitter.search');
    }

}
