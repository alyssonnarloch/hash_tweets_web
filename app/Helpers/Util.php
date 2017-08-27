<?php

use Carbon\Carbon;

class Util
{
	public static function displayDateTimePTBR($dateTime)
	{
		return Carbon::parse($dateTime)->format('d/m/Y h:i:s');
	}
}