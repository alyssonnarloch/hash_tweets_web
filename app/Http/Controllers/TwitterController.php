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

        $numTopRetweets = 30;

        $dataView = ['hashtag' => '', 'countTweets' => '', 'topTweets' => [], 'numTopRetweets' => $numTopRetweets];
        if(!empty($request->hashtag))
        {
        	$hashtag = new Hashtag($request->hashtag);

            $dataView['hashtag'] = $request->hashtag;
            $dataView['countTweets'] = $hashtag->countTweets(12);
            $dataView['topTweets'] = $hashtag->getTopRetweets($numTopRetweets);
            
            //echo '<pre>';
            //print_r($hashtag->countTweets(12));
            //print_r($hashtag->getTopRetweets(30));
            //die;
        }
    	return view('twitter.search', $dataView);
    }

}
