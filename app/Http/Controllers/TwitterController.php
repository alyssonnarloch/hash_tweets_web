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

        $dataView = ['hashtag' => '', 'countTweets' => '', 'topTweets' => ''];
        if(!empty($request->hashtag))
        {
        	$hashtag = new Hashtag($request->hashtag);
            $dataView = ['hashtag' => $request->hashtag, 'countTweets' => $hashtag->countTweets(12), 'topTweets' => $hashtag->getTopRetweets(3)];
            //echo '<pre>';
            //print_r($hashtag->countTweets(12));
            //print_r($hashtag->getTopRetweets(3));
            //die;
        }
    	return view('twitter.search', $dataView);
    }

}
