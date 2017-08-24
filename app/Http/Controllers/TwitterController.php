<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwitterController extends Controller
{
    public function search(Request $request)
    {    	    	
    	return view('twitter.search');
    }

}
