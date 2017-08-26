<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HashtagSearch;
use App\Models\Hashtag;
use Carbon\Carbon;
use Exception;

class TwitterController extends Controller
{
    public function search(Request $request)
    {    	    
        $numTopRetweets = 3;

        $dataView = ['hashtag' => '', 'countTweets' => '', 'topTweets' => [], 'numTopRetweets' => $numTopRetweets];
        if(!empty($request->hashtag))
        {
        	$hashtagSearch = new HashtagSearch($request->hashtag);
            $tweetsCount = $hashtagSearch->countTweets(12);
            $topRetweets = $hashtagSearch->getTopRetweets($numTopRetweets);        

            Hashtag::saveHashtagInfo($request->hashtag, $tweetsCount, $topRetweets);

            $dataView['hashtag'] = $request->hashtag;
            $dataView['countTweets'] = $tweetsCount;
            $dataView['topTweets'] = $topRetweets;

            //echo '<pre>';
            //print_r($hashtag->countTweets(12));
            //print_r($hashtag->getTopRetweets(30));
            //die;
        }
    	return view('twitter.search', $dataView);
    }

}
