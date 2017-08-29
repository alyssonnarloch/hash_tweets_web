<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use App\HashtagSearch;
use App\Repository\HashtagRepository;
use App\TwitterApi;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    public function __construct(HashtagRepository $dbHashtag)
    {
        $this->dbHashtag = $dbHashtag;
    }

    public function search(Request $request)
    {    	    
        $numTopRetweets = 3;

        $dataView = ['hashtag' => '', 'countTweets' => '', 'topTweets' => [], 'numTopRetweets' => $numTopRetweets];

        if(!empty($request->hashtag))
        {
        	$hashtagSearch = new HashtagSearch($request->hashtag);
            $tweetCount = $hashtagSearch->countTweets(12);
            $topRetweets = $hashtagSearch->getTopRetweets($numTopRetweets);        

            if($tweetCount > 0 || !empty($topRetweets)) {
                $this->dbHashtag->saveHashtagInfo($request->hashtag, $tweetCount, $topRetweets);
            }

            $dataView['hashtag'] = $request->hashtag;
            $dataView['tweetCount'] = $tweetCount;
            $dataView['topTweets'] = $topRetweets;
        }

    	return view('twitter.search', $dataView);
    }

    public function ranking(Request $request)
    {        
        if(empty($request->order)) {
            $request->order = 'DESC';
        }

        $hashtags = $this->dbHashtag->all(['start_date' => $request->start_date, 'end_date' => $request->end_date, 'order' => $request->order]);

        return view('twitter.ranking', ['hashtags' => $hashtags, 'request' => $request]);
    }

    public function hashtagList(Request $request)
    {
        $hashtags = Hashtag::where('name', 'LIKE', "%{$request->hashtag}%")->get();

        return view('twitter.hashtaglist', ['hashtags' => $hashtags]);
    }

    public function hashtagHistory(Request $request, $hashtagId = null)
    {
        $hashtagHistory = [];
        $hashtag = null;

        $hashtagRequest = $request->hashtag;

        if($hashtagId > 0) {
            $hashtag = Hashtag::find($hashtagId);
        } else if(!empty($hashtagRequest)) {
            $hashtag = Hashtag::where('name', $hashtagRequest)->first();
        }
        
        if($hashtag == null){
            return view('twitter.history', ['hashtag' => $hashtagRequest, 'hashtagId' => $hashtagId, 'hashtagHistory' => $hashtagHistory]);
        }

        $hashtagCalls = $hashtag->calls()->orderBy('created_at', 'DESC')->get();

        foreach($hashtagCalls as $call) {
            $hashtagCallInfo = [
                'created_at' => $call->created_at->format('d/m/Y H:i:s'),
                'tweet_count' => $call->tweet_count,
                'top_retweets' => []
            ];

            foreach($call->retweets as $retweet) {
                $twitterApi = new TwitterApi;
                $tweet = $twitterApi->searchById($retweet->tweet_id);

                $tweet->retweet_count = $retweet->retweet_count;
                $tweet->retweet_favorite = $retweet->retweet_favorite;

                $hashtagCallInfo['top_retweets'][] = $tweet;
            }

            $hashtagHistory[] = $hashtagCallInfo;
        }

        return view('twitter.history', ['hashtag' => $hashtag->name, 'hashtagId' => $hashtagId, 'hashtagHistory' => $hashtagHistory]);
    }
}
