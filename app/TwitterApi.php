<?php

namespace App;

use Abraham\TwitterOAuth\TwitterOAuth;
use Exception;

class TwitterApi
{

	private $accessToken;

	private $searchTypes = [
		'hashtag' => '#'
	];

	function __construct()
	{
		$this->accessToken = session('access_token');
		
		if(empty($this->accessToken))
		{
			session(['access_token' => $this->getAccessToken()]);
			$this->accessToken = session('access_token');
		}		
	}

	public function getAccessToken()
	{
		$twitter = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'));
		$response = $twitter->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);
		
		//echo '<pre>';print_r(get_class_methods($twitter));die;
		
		if($twitter->getLastHttpCode() != 200)
			throw new Exception('Erro ao gerar token: ' . $response->errors[0]->message);
		return $response->access_token;		
	}
	

	public function search($type, $hashtag)
	{
		$twitter = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'), null, $this->accessToken);

		$response = $twitter->get('search/tweets', ['q' => $this->searchTypes[$type] . $hashtag]);

		if($twitter->getLastHttpCode() != 200)
			throw new Exception('Erro ao efetuar busca no twitter: ' . $response->errors[0]->message);

		return $response->statuses;
	}
}