<?php

namespace App\Services;

use App\Helpers\Common;
use App\Interfaces\IStatisticsCalculator;
use Exception;

class StatisticsCalculator implements IStatisticsCalculator
{
    /**
     * Calculate min, max, average and median
     * @param array $dataPoints
     * @param int $unit
     * @return array
     * @throws Exception
     */
    public function calculate(array $dataPoints, int $unit): array
    {
        // Checking common errors
        if (empty($dataPoints) || !($dataPoints[0] instanceof DataPoint)) {
            throw new Exception("Invalid dataPoints: not an non-empty array of DataPoint objects");
        }
        if ($unit <= 0) {
            throw new Exception("Invalid unit: not a positive integer");
        }
        try {
            $metricValues = array();

            // Loop through data-points and finding statistics.
            foreach ($dataPoints as $dataPoint) {
                $metricValues[] = $dataPoint->getMetricValue();
            }

            // Convert values to megabits per second
            $average = Common::average($metricValues) / $unit;
            $min = min($metricValues);
            $min = $min / $unit;
            $max = max($metricValues);
            $max = $max / $unit;
            $median = Common::median($metricValues) / $unit;

            $result = array(
                'average' => $average,
                'min' => $min,
                'max' => $max,
                'median' => $median,
            );

            // Mapping with number format of decimal 2
            $result = array_map(function ($value) { return number_format($value, 2); }, $result);
            return $result;
        } catch (Exception $e) {
            // Handle the exception here
            throw new Exception("Something went wrong in Statistics");
        }
    }
}

