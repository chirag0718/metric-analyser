<?php

namespace App\Services;

use Exception;

class DownloadPerfomance
{
    public function getUnderPerformingPeriods(array $data, float $threshold): array
    {
        $underPerformingPeriods = array();
        $currentPeriodStart = null;
        $currentPeriodEnd = null;
        try {
            if (empty($data)) {
                throw new Exception("No data provided.");
            }
            if (!is_numeric($threshold) || $threshold < 0) {
                throw new Exception("Invalid threshold value provided.");
            }
            foreach ($data as $dataPoint) {
                if ($dataPoint->getMetricValue() < $threshold) {
                    if ($currentPeriodStart === null) {
                        $currentPeriodStart = $dataPoint->getTime();
                    }
                    $currentPeriodEnd = $dataPoint->getTime();
                } else {
                    if ($currentPeriodStart !== null) {
                        $underPerformingPeriods[] = array($currentPeriodStart, $currentPeriodEnd);
                    }
                    $currentPeriodStart = null;
                    $currentPeriodEnd = null;
                }
            }
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
