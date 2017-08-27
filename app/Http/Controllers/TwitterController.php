<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HashtagSearch;
use App\Models\Hashtag;
use Carbon\Carbon;
use Exception;

use App\TwitterApi;

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


    public function ranking()
    {
        //$t = new TwitterApi();
        //$r = $t->searchById('899989166125187072');

        //echo '<PRE>';print_r($r);die;

        $hashtags = DB::select('SELECT                                    
                                    hc.id,
                                    hc.hashtag_id,
                                    h.name,
                                    hc.tweet_count,
                                    hc.created_at
                                FROM
                                    hashtag_calls hc
                                    JOIN hashtags h ON hc.hashtag_id = h.id AND hc.created_at = (
                                        SELECT 
                                            MAX(created_at) as max_date
                                        FROM
                                            hashtag_calls
                                        WHERE
                                            hashtag_id = hc.hashtag_id
                                        GROUP BY    
                                            hashtag_id    
                                    )
                                ORDER BY
                                    hc.tweet_count DESC');

        return view('twitter.ranking', ['hashtags' => $hashtags]);
    }
}
