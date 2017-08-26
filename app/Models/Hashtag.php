<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Hashtag extends Model
{
    protected  $table = 'hashtags';

    public function calls()
    {
    	return $this->belongsToMany('App\Models\HashtagCall')->withPivot('tweets_count');
    }

    public static function saveHashtagInfo($hashtagName, $tweetsCount, $topRetweets)
    {    	
		DB::beginTransaction();
        try
        {
            $hashtag = Hashtag::where('name', $hashtagName)->first();

            if($hashtag == null)
            {
                $hashtag = new Hashtag;
                $hashtag->name = $hashtagName;
                $hashtag->save();
            }

            $hashtagCall = new HashtagCall;
            $hashtagCall->hashtag_id = $hashtag->id;
            $hashtagCall->tweet_count = $tweetsCount;
            $hashtagCall->save();

            foreach($topRetweets as $tweet)
            {
                $hashtagCallRetweet = new HashtagCallRetweet;
                $hashtagCallRetweet->hashtag_call_id = $hashtagCall->id;
                $hashtagCallRetweet->tweet_id = $tweet->retweeted_status->id_str;
                $hashtagCallRetweet->retweet_count = $tweet->retweeted_status->retweet_count;
                $hashtagCallRetweet->favorite_count = $tweet->retweeted_status->favorite_count;
                $hashtagCallRetweet->save();
            }

            DB::commit();
        }
        catch(Exception $ex)
        {                
            DB::rollBack();
            throw new Exception('Erro ao salvar dados da Hashtag: ' . $ex->getMessage());
        }
    }
}
