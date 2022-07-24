<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class GenreChart extends Chart
{ //php artisan make:chart GenreChart
//php artisan vendor:publish --tag=charts_config
//composer require consoletvs/charts:6.* --ignore-platform-req=ext-gd

    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}
