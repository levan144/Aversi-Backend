<?php

namespace App\Nova\Settings;
use Whitecube\NovaFlexibleContent\Flexible;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Trix;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Panel;
use Illuminate\Support\Facades\Storage;
class Covid extends AbstractType
{
    public function fields(): array
    {
        return [
            
           
            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    Flexible::make(__('Data'), 'data_ka')
                    ->button(__('Add new'))
                    ->addLayout(__('FAQ'), 'faq', [
                            Text::make(__('Title'), 'title'),
                            Text::make(__('Description'), 'description'),
                            Image::make(__('Icon'), 'icon_url')
                                ->disk('public')
                                ->prunable()
                                ->path('covid')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                       
                ]),
            ]),
            new Tab(__("English"), [
                Flexible::make(__('Data'), 'data_en')
                ->button(__('Add new'))
                ->addLayout(__('FAQ'), 'faq', [
                        Text::make(__('Title'), 'title'),
                        Text::make(__('Description'), 'description'),
                        Image::make(__('Icon'), 'icon_url')
                                ->disk('public')
                                ->prunable()
                                ->path('covid')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                   
            ]),
        ]),
            new Tab(__("Russian"), [
                Flexible::make(__('Data'), 'data_ru')
                ->button(__('Add new'))
                ->addLayout(__('FAQ'), 'faq', [
                        Text::make(__('Title'), 'title'),
                        Text::make(__('Description'), 'description'),
                        Image::make(__('Icon'), 'icon_url')
                                ->disk('public')
                                ->prunable()
                                ->path('covid')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                   
            ]),
            ]),
        ]),
        ];
    }


}