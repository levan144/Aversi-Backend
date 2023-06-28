<?php

return [
    'model' => \App\Models\Settings::class,

    'resource' => \Stepanenko3\NovaSettings\Resources\Settings::class,

    'types' => [
        \App\Nova\Settings\About::class,
        \App\Nova\Settings\Home::class,
        \App\Nova\Settings\Graduate::class,
        \App\Nova\Settings\Laboratory::class,
        \App\Nova\Settings\Tourism::class,
        \App\Nova\Settings\Services::class,
        \App\Nova\Settings\Covid::class,
        \App\Nova\Settings\Contact::class,
        \App\Nova\Settings\Rule::class,
        \App\Nova\Settings\Vacancy::class,
        \App\Nova\Settings\Report::class,
        \App\Nova\Settings\Partners::class,
        \App\Nova\Settings\Checkup::class,
        \App\Nova\Settings\LabCall::class,
    ],
];
