<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HashtagCallRetweet extends Model
{
    protected $table = 'hashtag_call_retweets';

    public function hashtagCall()
    {
        return $this->belongsTo('App\Models\HashtagCall');
    }
}
