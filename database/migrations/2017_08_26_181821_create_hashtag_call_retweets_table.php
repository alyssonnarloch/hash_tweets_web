<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHashtagCallRetweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashtag_call_retweets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tweet_id');
            $table->integer('hashtag_call_id');
            $table->integer('retweet_count');
            $table->integer('favorite_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hashtag_call_retweets');
    }
}
