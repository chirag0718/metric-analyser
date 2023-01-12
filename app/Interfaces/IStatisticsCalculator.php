<?php

namespace App\Interfaces;

interface IStatisticsCalculator
{
    public function calculate(array $dataPoints, int $unit): array;
}
