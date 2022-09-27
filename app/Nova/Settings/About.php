<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Trix;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;
use Illuminate\Support\Facades\Storage;
use AlexAzartsev\Heroicon\Heroicon;
class About extends AbstractType
{
    public function fields(): array
    {
        return [
            
            Image::make(__('Cover'), 'cover_image')
                                ->disk('public')
                                ->prunable()
                                ->path('pages')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
            new Panel(__('Content'), $this->generalFields()),
            new Panel(__('Advantages'), $this->advantagesFields()),

        ];
    }

    protected function generalFields()
    {
        return [
            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    
                    Trix::make(__('Top Description'), 'top_description_ka'),
                    Flexible::make(__('Counters'), 'counters_ka')
                        ->button(__('Add new'))
                        ->addLayout(__('Advantage'), 'item', [
                            Text::make(__('Title'), 'title'),
                            Text::make(__('Quantity'), 'quantity'),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/icons'))->disableEditor()->creationRules('required'),
                        ]),
                        
                    Trix::make(__('Bottom Description'), 'bottom_description_ka'),
                ]),
                new Tab(__("English"), [
                    Trix::make(__('Top Description'), 'top_description_en'),
                    Flexible::make(__('Counters'), 'counters_en')
                        ->button(__('Add new'))
                        ->addLayout(__('Advantage'), 'item', [
                            Text::make(__('Title'), 'title'),
                            Text::make(__('Quantity'), 'quantity'),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/icons'))->disableEditor()->creationRules('required'),
                        ]),
                    Trix::make(__('Bottom Description'), 'bottom_description_en'),
                ]),
                new Tab(__("Russian"), [
                    Trix::make(__('Top Description'), 'top_description_ru'),
                    Flexible::make(__('Counters'), 'counters_ru')
                        ->button(__('Add new'))
                        ->addLayout(__('Advantage'), 'item', [
                            Text::make(__('Title'), 'title'),
                            Text::make(__('Quantity'), 'quantity'),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/icons'))->disableEditor()->creationRules('required'),
                        ]),
                    Trix::make(__('Bottom Description'), 'bottom_description_ru'),
                ]),
            ]),
        ];
    }

    protected function advantagesFields()
    {
        return [
            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    Trix::make(__('Title'), 'advantages_title_ka')->help(
                        __('This content is used in About us Advantages Section')
                    ),
                    Flexible::make(__('Advantages'), 'advantages_ka')
                        ->button(__('Add new'))
                        ->addLayout(__('Advantage'), 'advantage', [
                            Text::make(__('Title'), 'title'),
                        ])
                        ->help(
                        __('This content is used in About us Advantages Section')
                        ),
                   
                ]),
                new Tab(__("English"), [
                    Trix::make(__('Title'), 'advantages_title_en')->help(
                        __('This content is used in About us Advantages Section')
                    ),
                    Flexible::make(__('Advantages'), 'advantages_en')
                        ->button(__('Add new'))
                        ->addLayout(__('Advantage'), 'advantage', [
                            Text::make(__('Title'), 'title'),
                        ])
                        ->help(
                        __('This content is used in About us Advantages Section')
                        ),
                ]),
                new Tab(__("Russian"), [
                    Trix::make(__('Title'), 'advantages_title_ru')->help(
                        __('This content is used in About us Advantages Section')
                    ),
                    Flexible::make(__('Advantages'), 'advantages_ru')
                        ->button(__('Add new'))
                        ->addLayout(__('Advantage'), 'advantage', [
                            Text::make(__('Title'), 'title'),
                        ])
                        ->help(
                        __('This content is used in About us Advantages Section')
                        ),
                ]),
            ]),
        ];
    }

}