<?php

namespace App\Helpers;

use DateTime;

/**
 * @author Chiragkumar
 */
class Common
{
    /**
     * Find the average of array
     * @param $array
     * @return float|int
     */
    public static function average($array): float|int
    {
        return array_sum($array) / count($array);
    }

    /**
     * Find the mean of array
     * @param $array
     * @return mixed
     */
    public static function median($array)
    {
        // Sort metric values in ascending order
        sort($array);

        // Calculate median
        return $array[(int)(count($array) / 2)];
    }

    /**
     * Check the date format is correct
     * @param $dateStr
     * @param string $format
     * @return bool
     */
    public static function validateDate($dateStr, string $format = 'Y-m-d'): bool
    {
        $date = DateTime::createFromFormat($format, $dateStr);
        return $date && ($date->format($format) === $dateStr);
    }
}
