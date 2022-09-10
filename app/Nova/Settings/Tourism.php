<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Trix;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Panel;
use Illuminate\Support\Facades\Storage;
class Tourism extends AbstractType
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


            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    Text::make(__('Section title'), 'section_title_ka'),
                    Trix::make(__('Content'), 'section_content_ka'),
                ]),
                new Tab(__("English"), [
                    Text::make(__('Section title'), 'section_title_en'),
                    Trix::make(__('Content'), 'section_content_en'),
                ]),
                new Tab(__("Russian"), [
                    Text::make(__('Section title'), 'section_title_ru'),
                    Trix::make(__('Content'), 'section_content_ru'),
                ]),
            ]),
        ];
    }


}