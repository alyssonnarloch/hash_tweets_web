<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected  $table = 'hashtags';

    public function calls()
    {
    	return $this->hasMany('App\Models\HashtagCall');
    }
}
