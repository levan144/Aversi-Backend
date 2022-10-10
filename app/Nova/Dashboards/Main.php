<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\NewFeedbacks;
use App\Nova\Metrics\NewPatients;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new NewFeedbacks,
            new NewPatients,
        ];
    }
}
