<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Illuminate\Support\Facades\Storage;
use App\Nova\User;
use Laravel\Nova\Panel;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
class Page extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Page::class;
    public static function group()
    {
        return __('General Pages');
    }

    
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static function label() {
        return __('Text Pages');
    }

    public static function singularLabel() {
        return __('Text Page');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title'
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

                Slug::make(__('Slug'), 'slug')
                        ->hideFromIndex()
                        ->from('Title')
                        ->rules('required_lang:ka')
                        ->creationRules('unique:pages,slug')
                        ->updateRules('unique:pages,slug,{{resourceId}}'),

                Trix::make(__('Content'), 'content')
                        ->rules('required_lang:ka'),

            ])->hideFromIndex(),

            new Panel(__('Social Network'), $this->socialFields()),

            new Panel(__('Other'), $this->otherFields()),
            

            


        ];
    }

    /**
     * Get the social fields for the resource.
     *
     * @return array
     */
    protected function socialFields()
    {
        return [
            NovaTabTranslatable::make([
               

            Text::make(__('Meta Description'), 'meta_desc')
                ->onlyOnForms(),

            Text::make(__('Social Share Title'), 'og_title')
                ->onlyOnForms(),

            Text::make(__('Social Share Description'), 'og_desc')
                ->onlyOnForms(),
            ])->hideFromIndex(),

            Image::make(__('Social Share Photo'), 'og_photo')
            ->disk('public')
            ->prunable()
            ->onlyOnForms()
            ->path('Pages')
            ->preview(function ($value, $disk) {
                return $value
                            ? Storage::disk($disk)->url($value)
                            : null;
            }),
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

            DateTime::make(__('Created at'),'created_at')
                ->exceptOnForms(),

            DateTime::make(__('Updated at'),'updated_at')
                ->exceptOnForms(),

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
