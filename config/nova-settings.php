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
    ],
];
