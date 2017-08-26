<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HashtagCall extends Model
{
    protected $table = 'hashtag_calls';

    public function retweets()
    {
    	return $this->belongsToMany('App\Models\HashtagCallRetweet')->withPivot('retweet_count', 'favorite_count');
    }
}
