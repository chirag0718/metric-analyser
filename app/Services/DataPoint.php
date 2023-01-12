<?php

namespace App\Services;

use App\Helpers\Common;
use App\Interfaces\IDataPointInterface;
use Exception;

class DataPoint implements IDataPointInterface {
    private float $metricValue;
    private string $dtime;

    /**
     * @throws Exception
     */
    public function __construct(float $metricValue, string $dtime) {
        try {
            if (!is_float($metricValue)) {
                throw new Exception("Invalid metric value: not a float");
            }
            $date = Common::validateDate($dtime);
            if (!$date) {
                throw new Exception("Invalid date-time: not a valid date format (yyyy-mm-dd)");
            }
            $this->metricValue = $metricValue;
            $this->dtime = $dtime;
        } catch (Exception $e) {
            // Handle the exception here
            throw new Exception("Something went wrong" . $e->getMessage());
        }
    }

    public function getMetricValue(): float
    {
        return $this->metricValue;
    }

    public function getTime(): string
    {
        return $this->dtime;
    }
}
