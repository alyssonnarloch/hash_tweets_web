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
            $tweetCount = $hashtagSearch->countTweets(12);
            $topRetweets = $hashtagSearch->getTopRetweets($numTopRetweets);        

            if($tweetCount > 0)
                Hashtag::saveHashtagInfo($request->hashtag, $tweetCount, $topRetweets);

            $dataView['hashtag'] = $request->hashtag;
            $dataView['tweetCount'] = $tweetCount;
            $dataView['topTweets'] = $topRetweets;
        }

    	return view('twitter.search', $dataView);
    }


    public function ranking()
    {
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

    public function history(Request $request, $hashtagId = null)
    {
        $hashtagHistory = [];
        $hashtag = null;

        $hashtagRequest = $request->hashtag;

        if($hashtagId > 0)
            $hashtag = Hashtag::find($hashtagId);
        else if(!empty($hashtagRequest))
            $hashtag = Hashtag::where('name', $hashtagRequest)->first();
        
        if($hashtag == null)
            return view('twitter.history', ['hashtag' => $hashtagRequest, 'hashtagId' => $hashtagId, 'hashtagHistory' => $hashtagHistory]);

        $hashtagCalls = $hashtag->calls()->orderBy('created_at', 'desc')->get();

        foreach($hashtagCalls as $call)
        {
            $hashtagCallInfo = [
                'created_at' => $call->created_at->format('d/m/Y h:i:s'),
                'tweet_count' => $call->tweet_count,
                'top_retweets' => []
            ];
            foreach($call->retweets as $retweet)
            {
                $twitterApi = new TwitterApi;
                $tweet = $twitterApi->searchById($retweet->tweet_id);

                $tweet->retweet_count = $retweet->retweet_count;
                $tweet->retweet_favorite = $retweet->retweet_favorite;

                $hashtagCallInfo['top_retweets'][] = $tweet;
            }

            $hashtagHistory[] = $hashtagCallInfo;
        }

        return view('twitter.history', ['hashtag' => $hashtagRequest, 'hashtagId' => $hashtagId, 'hashtagHistory' => $hashtagHistory]);
    }
}
