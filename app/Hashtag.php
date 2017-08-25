<?php

namespace App;

use App\TwitterApi;

class Hashtag
{
	private $twitterApi;
	private $tweets;

	function __construct($hashtag)
	{
		$this->twitterApi = new TwitterApi;
		$this->tweets = $this->twitterApi->search('hashtag', $hashtag);
	}


	public function getTweets()
	{
		return $this->tweets;
	}

	public function countTweets($hoursPeriod)
	{

	}

	public function getTopRetweets($number)
	{

	}
}