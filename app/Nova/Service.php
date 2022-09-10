<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\DateTime;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Support\Facades\Storage;
use App\Nova\User;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Boolean;
class Service extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Service::class;
    public static $group = 'Content';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static function label() {
        return __('Services');
    }

    public static function singularLabel() {
        return __('Service');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title->ka'
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

                Trix::make(__('Content'), 'content')
                    ->rules('required_lang:ka'),

            ])->hideFromIndex(),

            Image::make(__('Icon'), 'icon')
            ->disk('public')
            ->prunable()
            ->path('service_icons')
            ->preview(function ($value, $disk) {
                return $value
                            ? Storage::disk($disk)->url($value)
                            : null;
            }),

            Image::make(__('Image'), 'cover_image')
            ->disk('public')
            ->prunable()
            ->path('services')
            ->preview(function ($value, $disk) {
                return $value
                            ? Storage::disk($disk)->url($value)
                            : null;
            })
            ->creationRules('required'),
                BelongsTo::make(__('Parent'), 'parentModel', 'App\Nova\Service')
                ->searchable()->nullable()->showOnUpdating(),
                
                HasMany::make(__('Child'), 'children', 'App\Nova\Service')
                ->nullable(),
            new Panel(__('Other'), $this->otherFields()),
        ];
    }

    /**
     * Get the other fields for the resource.
     *
     * @return array
     */

    protected function otherFields()
    {
        return [
            BelongsTo::make(__('Author'), 'author', User::class)
                ->searchable()
                ->default(Auth()->user()->id)
                ->rules('required'),

            Boolean::make(__('Published'), 'status')
                ->trueValue(1, __('Published'))
                ->falseValue(0, __('Draft')),

            DateTime::make(__('Created at'),'created_at')
                ->exceptOnForms(),

            DateTime::make(__('Updated at'),'updated_at')
                ->exceptOnForms(),
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
