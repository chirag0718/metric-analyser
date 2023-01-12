<?php

namespace App\Services;

use App\Exceptions\InvalidJsonException;
use Exception;

class JsonAdapter
{
    /**
     * @throws InvalidJsonException
     * @throws Exception
     */
    public function adapt($json): array
    {
        // decoding json data to array and checking error
        $data = json_decode($json);
        if(json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidJsonException("Invalid JSON provided");
        }

        if(!is_array($data)) {
            throw new InvalidJsonException("JSON does not contain an array");
        }

        $dataPoints = array();

        // Looping through data and checking any properties are missing.
        // Then passing to data points getter methods to map json data
        foreach ($data as $item) {
            if(!isset($item->metricValue) || !isset($item->dtime)) {
                throw new InvalidJsonException("JSON array element is missing required properties");
            }
            $dataPoints[] = new DataPoint($item->metricValue, $item->dtime);
        }
        return $dataPoints;
    }
}
