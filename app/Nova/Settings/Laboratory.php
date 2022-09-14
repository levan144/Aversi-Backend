<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;
use Illuminate\Support\Facades\Storage;
class Laboratory extends AbstractType
{
    public function fields(): array
    {
        return [
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

    protected function modelFields()
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
        ];
    }

}