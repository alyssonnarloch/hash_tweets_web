<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HashtagCall extends Model
{
    protected $table = 'hashtag_calls';

    public function hashtag()
    {
        return $this->belongsTo('App\Models\Hashtag');
    }

    public function retweets()
    {
    	return $this->hasMany('App\Models\HashtagCallRetweet');
    }
}
