<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
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
                                ->help(
    '740 x 1000'
)
                                ->path('pages')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
            new Panel(__('Content'), $this->generalFields()),
            new Panel(__('Advantages'), $this->advantagesFields()),
            new Panel(__('Meta Tags'), $this->metaFields()),
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
                            Number::make(__('Quantity'), 'quantity'),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/aboutIcons'))->only(['custom'])->disableEditor()->creationRules('required'),
                        ])
                        ->addLayout(__('Total number of Patients'), 'patients_item', [
                            Text::make(__('Title'), 'title'),
                            Number::make(__('Quantity'), 'quantity')->readonly(true),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/aboutIcons'))->only(['custom'])->disableEditor()->creationRules('required'),
                        ])
                        ->addLayout(__('Total number of studies'), 'studies_item', [
                            Text::make(__('Title'), 'title'),
                            Number::make(__('Quantity'), 'quantity')->readonly(true),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/aboutIcons'))->only(['custom'])->disableEditor()->creationRules('required'),
                        ])->limit(5),
                        
                    Trix::make(__('Bottom Description'), 'bottom_description_ka'),
                ]),
                new Tab(__("English"), [
                    Trix::make(__('Top Description'), 'top_description_en'),
                    Flexible::make(__('Counters'), 'counters_en')
                        ->button(__('Add new'))
                        ->addLayout(__('Advantage'), 'item', [
                            Text::make(__('Title'), 'title'),
                            Number::make(__('Quantity'), 'quantity'),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/aboutIcons'))->only(['custom'])->disableEditor()->creationRules('required'),
                        ])
                        ->addLayout(__('Total number of studies'), 'patients_item', [
                            Text::make(__('Title'), 'title'),
                            Number::make(__('Quantity'), 'quantity')->readonly(true),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/aboutIcons'))->only(['custom'])->disableEditor()->creationRules('required'),
                        ])
                        ->addLayout(__('Total number of Patients'), 'patients_item', [
                            Text::make(__('Title'), 'title'),
                            Number::make(__('Quantity'), 'quantity')->readonly(true),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/aboutIcons'))->only(['custom'])->disableEditor()->creationRules('required'),
                        ])->limit(5),
                    Trix::make(__('Bottom Description'), 'bottom_description_en'),
                ]),
                new Tab(__("Russian"), [
                    Trix::make(__('Top Description'), 'top_description_ru'),
                    Flexible::make(__('Counters'), 'counters_ru')
                        ->button(__('Add new'))
                        ->addLayout(__('Advantage'), 'item', [
                            Text::make(__('Title'), 'title'),
                            Number::make(__('Quantity'), 'quantity'),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/aboutIcons'))->only(['custom'])->disableEditor()->creationRules('required'),
                        ])
                        ->addLayout(__('Total number of studies'), 'studies_item', [
                            Text::make(__('Title'), 'title'),
                            Number::make(__('Quantity'), 'quantity')->readonly(true),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/aboutIcons'))->only(['custom'])->disableEditor()->creationRules('required'),
                        ])
                        ->addLayout(__('Total number of Patients'), 'patients_item', [
                            Text::make(__('Title'), 'title'),
                            Number::make(__('Quantity'), 'quantity')->readonly(true),
                            Heroicon::make(__('Icon'), 'icon')->registerIconSet('custom', 'Custom', resource_path('img/aboutIcons'))->only(['custom'])->disableEditor()->creationRules('required'),
                        ])->limit(5),
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
    
    protected function metaFields()
    {
        return [
           new Tabs(__("Meta Tags"), [
               new Tab(__("Georgian"), [
                   Text::make(__('Meta Title'), 'meta_title_ka'),
                   Text::make(__('Meta Description'), 'meta_description_ka'),
               ]),
               new Tab(__("English"), [
                   Text::make(__('Meta Title'), 'meta_title_en'),
                   Text::make(__('Meta Description'), 'meta_description_en'),
               ]),
               new Tab(__("Russian"), [
                   Text::make(__('Meta Title'), 'meta_title_ru'),
                   Text::make(__('Meta Description'), 'meta_description_ru'),
               ]),
           ]),
        ];
        
    }

}