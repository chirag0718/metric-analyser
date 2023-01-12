<?php

namespace App\Services;

use Exception;

class DownloadPerfomance
{
    /**
     * Checking the under performing download
     * @param array $data
     * @param float $threshold
     * @return array
     */
    public function getUnderPerformingPeriods(array $data, float $threshold): array
    {
        // Initialize an empty array to store the under-performing periods
        $underPerformingPeriods = array();

        // Initialize variables to keep track of the start
        // and end times of the current under-performing period
        $currentPeriodStart = null;
        $currentPeriodEnd = null;
        try {
            // Checking error and error handling
            if (empty($data)) {
                throw new Exception("No data provided.");
            }
            if (!is_numeric($threshold) || $threshold < 0) {
                throw new Exception("Invalid threshold value provided.");
            }
            // Looping through data to find the under performing date
            foreach ($data as $dataPoint) {

                // Threshold is average of metric value
                if ($dataPoint->getMetricValue() < $threshold) {
                    // Checking currentperiodstart is null that means
                    // no current under-performing period has been found yet
                    if ($currentPeriodStart === null) {
                        $currentPeriodStart = $dataPoint->getTime();
                    }
                    $currentPeriodEnd = $dataPoint->getTime();
                } else {
                    // metric value is not less than the threshold
                    // that indicates that an under-performing period has been found
                    if ($currentPeriodStart !== null) {
                        $underPerformingPeriods[] = array($currentPeriodStart, $currentPeriodEnd);
                    }
                    $currentPeriodStart = null;
                    $currentPeriodEnd = null;
                }
            }
            // check if currentPeriodStart is not null, if so add it to underPerformingPeriods
            if ($currentPeriodStart !== null) {
                $underPerformingPeriods[] = array($currentPeriodStart, $currentPeriodEnd);
            }
            return $underPerformingPeriods;
        } catch (Exception $e) {
            // log the error message and return an empty array
            error_log($e->getMessage());
            return array();
        }
    }
}
