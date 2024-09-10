<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use NumberFormatter;
class FormatLetter extends Model
{
	public static function convertDecimalToWords($number, $locale = 'fr_FR') {
		$formatter = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
		return $formatter->format($number);
	}

}

