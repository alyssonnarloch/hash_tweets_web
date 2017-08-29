<?php

namespace App\Repository;

use App\Models\Hashtag;
use App\Models\HashtagCall;
use App\Models\HashtagCallRetweet;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class HashtagRepository
{
	public function all($parameters)
	{
        $extraConditions = '';

        if($parameters['start_date']) {
            $extraConditions .= ' AND created_at >= \'' . Carbon::createFromFormat('d/m/Y', $parameters['start_date'])->toDateString() . ' 00:00:00\'';
        }
        if($parameters['end_date']) {
            $extraConditions .= ' AND created_at <= \'' . Carbon::createFromFormat('d/m/Y', $parameters['end_date'])->toDateString() . ' 23:59:59\'';
        }

        return DB::select('SELECT                                    
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
                                        ' . $extraConditions . '
                                    GROUP BY    
                                        hashtag_id    
                                )
                            ORDER BY
                                hc.tweet_count ' . $parameters['order']);
	}

    public function saveHashtagInfo($hashtagName, $tweetsCount, $topRetweets)
    {       
        DB::beginTransaction();
        try {
            $hashtag = Hashtag::where('name', $hashtagName)->first();

            if($hashtag == null) {
                $hashtag = new Hashtag;
                $hashtag->name = $hashtagName;
                $hashtag->save();
            }

            $hashtagCall = new HashtagCall;
            $hashtagCall->hashtag_id = $hashtag->id;
            $hashtagCall->tweet_count = $tweetsCount;
            $hashtagCall->save();

            foreach($topRetweets as $tweet) {
                $hashtagCallRetweet = new HashtagCallRetweet;
                $hashtagCallRetweet->hashtag_call_id = $hashtagCall->id;
                $hashtagCallRetweet->tweet_id = $tweet->id_str;
                $hashtagCallRetweet->retweet_count = $tweet->retweet_count;
                $hashtagCallRetweet->favorite_count = $tweet->favorite_count;
                $hashtagCallRetweet->save();
            }

            DB::commit();
        } catch(Exception $ex) {                
            DB::rollBack();
            throw new Exception('Erro ao salvar dados da Hashtag: ' . $ex->getMessage());
        }
    }
}