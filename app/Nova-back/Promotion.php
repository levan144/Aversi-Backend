<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Image;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Illuminate\Support\Facades\Storage;
use Whitecube\NovaFlexibleContent\Flexible;
use AlexAzartsev\Heroicon\Heroicon;

class Promotion extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Promotion::class;
    public static $group = 'News';
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static function label() {
        return __('Promotions');
    }

    public static function singularLabel() {
        return __('Promotion');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title->ka'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->onlyOnIndex(),
            Text::make(__('Title'), 'title')->onlyOnIndex(),
            NovaTabTranslatable::make([
                Text::make(__('Title'), 'title')
                    ->rules('required_lang:ka'),
                Trix::make(__('Content'), 'content'),
                
            ])->hideFromIndex(),

            Image::make(__('Cover'), 'cover_image')
            ->disk('public')
            ->prunable()
            ->path('promotion_cover_images')
            ->preview(function ($value, $disk) {
                return $value
                            ? Storage::disk($disk)->url($value)
                            : null;
            })
            ->creationRules('required'),
            Flexible::make(__('Badge Text'), 'badge')->limit(1)
                        ->button(__('Add new'))
                        ->addLayout(__('Icon'), 'icon', [
                            Heroicon::make(__('Icon'), 'data')->registerIconSet('custom', 'Custom', resource_path('img/icons'))->disableEditor()->rules('required'),
                        ])
                        ->addLayout(__('Text'), 'text', [
                            Text::make(__('Badge Text'), 'data')->withMeta(['extraAttributes' => [
                                'placeholder' => '-20%']
                            ])->rules('required'),
                        ])
                        ->help(
                        __('This content is used in Badge')
                        )->rules('required'),
            
            
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
