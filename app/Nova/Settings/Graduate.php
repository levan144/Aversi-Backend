<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;
use Illuminate\Support\Facades\Storage;
class Graduate extends AbstractType
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

        ];
    }

    protected function generalFields()
    {
          
        return [
            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    Flexible::make(__('Sections'), 'sections_ka')
                        ->button(__('Add new'))
                        ->addLayout(__('Text Section'), 'section', [
                            Text::make(__('Title'), 'title'),
                            Trix::make(__('Description'), 'description_1'),
                            Trix::make(__('Description'), 'description_2'),
                        ]),
                    ]),

                new Tab(__("English"), [
                    Flexible::make(__('Sections'), 'sections_en')
                        ->button(__('Add new'))
                        ->addLayout(__('Text Section'), 'section', [
                            Text::make(__('Title'), 'title'),
                            Trix::make(__('Description'), 'description_1'),
                            Trix::make(__('Description'), 'description_2'),
                        ]),
                    ]),
                
                new Tab(__("Russian"), [
                    Flexible::make(__('Sections'), 'sections_ru')
                        ->button(__('Add new'))
                        ->addLayout(__('Text Section'), 'section', [
                            Text::make(__('Title'), 'title'),
                            Trix::make(__('Description'), 'description_1'),
                            Trix::make(__('Description'), 'description_2'),
                        ]),
                ]),

            ]),
        ];
    }


}