<?php

namespace App\Services;

use App\Exceptions\InvalidJsonException;
use App\Interfaces\IStatisticsCalculator;
use Exception;

class OutputGenerator
{
    private JsonAdapter $jsonAdapter;
    private Formatter $formatter;
    private DownloadPerfomance $downloadPerfomance;
    private IStatisticsCalculator $statisticsCalculator;

    public function __construct(JsonAdapter           $jsonAdapter,
                                IStatisticsCalculator $statisticsCalculator,
                                DownloadPerfomance    $downloadPerfomance,
                                Formatter             $formatter)
    {
        $this->jsonAdapter = $jsonAdapter;
        $this->statisticsCalculator = $statisticsCalculator;
        $this->formatter = $formatter;
        $this->downloadPerfomance = $downloadPerfomance;
    }

    /**
     * Generating the output
     * @param $json
     * @return string
     * @throws InvalidJsonException
     */
    public function generate($json): string
    {
        try {
            $dataPoints = $this->jsonAdapter->adapt($json);

            // Calculate statistics and under performance
            // @TODO - add variable to env file or some configuration file
            $statistics = $this->statisticsCalculator->calculate($dataPoints, 125000);
            $threshold = $statistics['average'] * 125000;
            $statistics['under_performed'] = $this->downloadPerfomance->getUnderPerformingPeriods($dataPoints, $threshold);
            // Format output
            return $this->formatter->format($dataPoints, $statistics);
        } catch (Exception $e) {
            error_log("Error generating output: " . $e->getMessage());
            throw $e;
        }
    }
}

