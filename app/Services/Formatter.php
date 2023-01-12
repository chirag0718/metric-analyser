<?php

namespace App\Services;

use Exception;

class Formatter
{
    public function format($dataPoints, $statistics): string
    {
        try {
            if (empty($dataPoints)) {
                throw new Exception("No data points provided.");
            }

            // Format the *.output file with concatenating string
            $firstDate = $dataPoints[0]->getTime();
            $lastDate = $dataPoints[count($dataPoints) - 1]->getTime();

            $output = "SamKnows Metric Analyser v1.0.0\n===============================\n\n";
            $output .= "Period checked:\n\n";
            $output .= "    From: " . $firstDate . "\n";
            $output .= "    To:   " . $lastDate . "\n\n";
            if (empty($statistics)) {
                throw new Exception("No statistics provided.");
            }
            $output .= "Statistics:\n\n";
            $output .= "    Unit: Megabits per second\n\n";
            $output .= "    Average: " . ($statistics['average']) . "\n";
            $output .= "    Min: " . $statistics['min'] . "\n";
            $output .= "    Max: " . $statistics['max'] . "\n";
            $output .= "    Median: " . round($statistics['median']) . "\n";

            // Displaying under performing periods.
            $under_performing = $statistics['under_performed'];
            if (empty($under_performing[0])) {
                $output .= "\nNo under-performing periods found.";
            } else {
                $output .= "\nUnder-performing periods:\n";
                foreach ($under_performing as $period) {
                    // Considering only range values if one day was under performing then
                    // not printing that date in output files.
                    if ($period[0] != $period[1]) {
                        $output .= "\n    * The period between " . $period[0] . " and " . $period[1];
                        $output .= "\n       was under-performing.";
                    }
                }
            }
            return $output;
        } catch (Exception $e) {
            // log the error message and return an error message to the user
            error_log($e->getMessage());
            return "An error occurred while formatting the data. Please try again later.";
        }
    }
}
