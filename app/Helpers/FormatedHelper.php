<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatedHelper
{
    /**
     * convert to rupiah currency
     *
     * @param float $number
     *
     * @return string
     */

    public static function rupiahCurrency(float $number): string
    {
        return "Rp " . number_format($number, 0, ',', '.');
    }

    /**
     * dateTimeFormat
     *
     * @param  mixed $dateTime
     * @return string
     */
    public static function dateTimeFormat(string $dateTime): string
    {
        $date = Carbon::parse($dateTime);
        $newFormat = $date->isoFormat('dddd, D MMMM Y HH:mm');
        return $newFormat;
    }
}
