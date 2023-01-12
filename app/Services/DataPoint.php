<?php

namespace App\Services;

use App\Helpers\Common;
use App\Interfaces\IDataPointInterface;
use Exception;

/**
 * @author Chiragkumar Patel
 */
class DataPoint implements IDataPointInterface {
    private float $metricValue;
    private string $dtime;

    /**
     * @throws Exception
     */
    public function __construct(float $metricValue, string $dtime) {
        try {
            // Checking metric value is valid
            if (!is_float($metricValue)) {
                throw new Exception("Invalid metric value: not a float");
            }

            // Checking date format is valid
            $date = Common::validateDate($dtime);
            if (!$date) {
                throw new Exception("Invalid date-time: not a valid date format (yyyy-mm-dd)");
            }
            $this->metricValue = $metricValue;
            $this->dtime = $dtime;
        } catch (Exception $e) {
            // Throwing general exception if something went wrong
            throw new Exception("Something went wrong" . $e->getMessage());
        }
    }

    /**
     * Get the metric values
     * @return float
     */
    public function getMetricValue(): float
    {
        return $this->metricValue;
    }

    /**
     * Get the time data
     * @return string
     */
    public function getTime(): string
    {
        return $this->dtime;
    }
}
