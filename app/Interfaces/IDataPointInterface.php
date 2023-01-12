<?php

namespace App\Interfaces;

/**
 * @author Chiragkumar Patel
 */
interface IDataPointInterface {
    public function getMetricValue();
    public function getTime();
}
