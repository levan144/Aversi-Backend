<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Trix;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Flexible;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\HasMany;
use Outl1ne\MultiselectField\Multiselect;
class Laboratory extends AbstractType
{
    public function fields(): array
    {
        return [
            // Boolean::make('Param 1', 'param_1'),
            // Boolean::make('Param 2', 'param_2'),
            // Boolean::make('Param 3', 'param_3'),
            new Panel(__('Content'), $this->generalFields()),
            new Panel(__('Resources'), $this->modelFields()),

        ];
    }

    protected function generalFields()
    {
          
        return [
            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    Trix::make(__('Content'), 'content_ka'),
                    // Text::make(__('Analyses block title'), 'analyses_title_ka'),
                    ]),

                new Tab(__("English"), [
                    Trix::make(__('Content'), 'content_en'),
                    // Text::make(__('Analyses block title'), 'analyses_title_en'),
                    ]),
                
                new Tab(__("Russian"), [
                    Trix::make(__('Content'), 'content_ru'),
                    // Text::make(__('Analyses block title'), 'analyses_title_ru'),
                ]),

            ]),
        ];
    }

    protected function modelFields()
    {
        return [
           
        ];
    }

}