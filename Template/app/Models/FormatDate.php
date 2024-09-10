<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class FormatDate extends Model
{

    public static function formatDateTime($date)
    {
        if ($date === null) {
            return '...';
        }

        $carbonDate = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $date_formatee_fr = $carbonDate->isoFormat('D MMMM YYYY [à] HH[h] mm[mn]');
        return $date_formatee_fr;
    }

    public static function formatMonth($mois){
        $carbonDate = Carbon::createFromFormat('m',$mois);
        $date_formatee_fr = $carbonDate->isoFormat('MMMM');
        return $date_formatee_fr;
    }

    public static function formatDay($date){
        if ($date === null) {
            return 0;
        }

        $carbonDate = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $day_format = $carbonDate->isoFormat('D');
        return $day_format;
    }


    public static function formatAn($date){
        if ($date === null) {
            return '...';
        }
        $format = (strpos($date, ':') !== false) ? 'Y-m-d H:i:s' : 'Y-m-d';
        $carbonDate = Carbon::createFromFormat($format, $date);
        $date_formatee_fr = $carbonDate->isoFormat('D MMMM YYYY');

        return $date_formatee_fr;
    }


    public static function format($date){
        if ($date === null) {
            return '...';
        }

        $format = (strpos($date, ':') !== false) ? 'Y-m-d H:i:s' : 'Y-m-d';
        $carbonDate = Carbon::createFromFormat($format, $date);

        // Définir la locale en français
        Carbon::setLocale('fr');

        // Formater la date en français avec le premier mot du mois en majuscule
        $date_formatee_fr = ucfirst($carbonDate->isoFormat('D MMMM YYYY'));

        return $date_formatee_fr;
    }

}
