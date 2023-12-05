<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Slug;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Image;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Panel;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Fields\FormData;

class Gallery extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Gallery::class;
    public static $group = 'Content';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static function label() {
        return __('Galleries');
    }

    public static function singularLabel() {
        return __('Gallery');
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
            ])->hideFromIndex(),
            
            // BelongsTo::make(__('Album'), 'getAlbum', 'App\Nova\Album')->nullable(),
            Select::make(__('Gallery Type'), 'type')->options([
                'photo' => __('Photo'),
                'video' => __('Video'),
            ])->rules('required')->hideFromIndex(),

            Images::make(__('Photos'), 'gallery')
                ->enableExistingMedia()
                ->withResponsiveImages()
                ->showStatistics()
                ->hideFromIndex()->help(
                    '1629 x 691'
                ),

            Text::make(__('Youtube URL'), 'video')->readonly()->hideFromIndex()->dependsOn(['type'],
                function (Text $field, NovaRequest $request, FormData $formData) {
                    if ($formData->type === 'video') {
                        $field->readonly(false);
                    }
                }
            ),

            Boolean::make(__('Published'), 'status')
                ->trueValue(1, __('Published'))
                ->falseValue(0, __('Draft')),
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
