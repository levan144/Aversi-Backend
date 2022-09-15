<?php

namespace App\Nova\Settings;
use Whitecube\NovaFlexibleContent\Flexible;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Panel;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
class Rule extends AbstractType
{
    public function fields(): array
    {
        return [
            new Panel(__('Content'), $this->generalFields()),
           
           
        ];
    }

    protected function generalFields()
    {
        return [
            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    Trix::make(__('Content'), 'content_ka'),
                ]),
                new Tab(__("English"), [
                    Trix::make(__('Content'), 'content_en'),
                    
                ]),
                new Tab(__("Russian"), [
                    Trix::make(__('Content'), 'content_ru'),
                   
                ]),
            ]),
        ];
    }
}