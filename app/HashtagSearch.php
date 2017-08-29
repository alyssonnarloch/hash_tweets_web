<?php

namespace App;

use App\TwitterApi;
use Carbon\Carbon;

class HashtagSearch
{
	private $twitterApi;
	private $tweets;

	function __construct($hashtag)
	{
		$this->twitterApi = new TwitterApi;
		$this->tweets = $this->twitterApi->searchByType('hashtag', $hashtag);
	}

	public function getTweets()
	{
		return $this->tweets;
	}

	public function countTweets($hoursPeriod)
	{
		$count = 0;

		$limitDateTime = Carbon::now()->addHours($hoursPeriod * (-1));
        $limitDateTime->timezone = 'UTC';

        foreach($this->tweets as $tweet) {
        	$createdAt = Carbon::parse($tweet->created_at);
	    
        	if($createdAt->gte($limitDateTime)) {
        		$count++;
        	} else {
        		break;
        	}
        }

        return $count;
	}

	public function getTopRetweets($number)
	{
		$topTweets = [];
		$retweetsCountMap = [];
		$tweetsMap = [];

		foreach($this->tweets as $tweet) {
			if(isset($tweet->retweeted_status)) {
				$originalTweet = $tweet->retweeted_status;
				$retweetsCountMap[$originalTweet->id_str] = $originalTweet->retweet_count;

				$tweetsMap[$originalTweet->id_str] = $tweet;
			}
		}

		arsort($retweetsCountMap);

		$countIteration = 0;
		foreach ($retweetsCountMap as $id => $count) {
			$countIteration++;

			$topTweets[] = $this->twitterApi->searchById($id);

			if($countIteration == $number) {
				break;
			}
		}

		return $topTweets;
	}
}