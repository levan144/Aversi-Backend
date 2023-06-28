<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Outl1ne\MultiselectField\Multiselect;
use Laravel\Nova\Fields\BelongsToMany;
class CheckupPlan extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CheckupPlan::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static $group = 'Checkup';
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title->ka',
    ];
    
    public static function label() {
        return __('Plans');
    }

    public static function singularLabel() {
        return __('Plan');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make(__('Title'), 'title')->onlyOnIndex(),
            NovaTabTranslatable::make([
                Text::make(__('Title'), 'title')
                    ->rules('required_lang:ka'),
            ])->hideFromIndex(),
            
            Multiselect::make(__('Gender'), 'gender')->options([
                 'M' => __('Men'),
                 'W' => __('Women')
            ]),
            // HasMany::make('checkup_services'),
            BelongsToMany::make(__('Services'), 'checkupServices', CheckupService::class)
                 ->resolveUsing(function ($value, $resource, $attribute) {
                    return $resource->checkupServices()->whereNull('parent_id')->get();
                })
                ->display('title'),

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