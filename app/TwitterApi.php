<?php

namespace App;

use Abraham\TwitterOAuth\TwitterOAuth;
use Exception;

class TwitterApi
{
	private $accessToken;
	private $twitter;
	private $searchTypes = [
		'hashtag' => '#'
	];

	function __construct()
	{
		$this->accessToken = session('access_token');
		
		if(empty($this->accessToken)) {
			session(['access_token' => $this->getAccessToken()]);
			$this->accessToken = session('access_token');
		}

		$this->twitter = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'), null, $this->accessToken);		
	}

	public function getAccessToken()
	{
		$twitter = new TwitterOAuth(env('TWITTER_CONSUMER_KEY'), env('TWITTER_CONSUMER_SECRET'));
		$response = $twitter->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);
		
		if($twitter->getLastHttpCode() != 200) {
			throw new Exception('Erro ao gerar token: ' . $response->errors[0]->message);
		}

		return $response->access_token;		
	}

	public function searchByType($type, $text)
	{
		$response = $this->twitter->get('search/tweets', [
			'q' => $this->searchTypes[$type] . $text,
			'count' => 100
		]);

		if($this->twitter->getLastHttpCode() != 200) {
			throw new Exception('Erro ao efetuar busca no twitter: ' . $response->errors[0]->message);
		}

		return $response->statuses;
	}

	public function searchById($id)
	{
		$response = $this->twitter->get('statuses/show', [
			'id' => $id
		]);

		if($this->twitter->getLastHttpCode() != 200) {
			throw new Exception('Erro ao efetuar busca no twitter: ' . $response->errors[0]->message);
		}

		return $response;
	}	
}