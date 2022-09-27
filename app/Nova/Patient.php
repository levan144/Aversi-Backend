<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Dniccum\PhoneNumber\PhoneNumber;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Image;
use Storage;
class Patient extends Resource
{
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Patient::class;
    public static $group = 'Users';
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';
    public static function label() {
        return __('Patients');
    }

    public static function singularLabel() {
        return __('Patient');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        // 'name->ka','email'
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
            ID::make()->sortable(),
            Text::make(__('Name'), 'name')
                    ->sortable()
                    ->rules('required', 'max:255'),
            Text::make(__('Lastname'), 'last_name')
                    ->sortable()
                    ->rules('required', 'max:255'),
            
            Image::make(__('Avatar'), 'photo')
                    ->disk('public')
                    ->path('patients')
                    ->prunable()
                    ->preview(function ($value, $disk) {
                        return $value
                                    ? Storage::disk($disk)->url($value)
                                    : null;
                    }),
            
            Text::make(__('Email'), 'email')
                    ->sortable()
                    ->rules('required', 'email', 'max:254')
                    ->creationRules('unique:patients,email')
                    ->updateRules('unique:patients,email,{{resourceId}}'),

            PhoneNumber::make(__('Phone number'), 'phone')
                    ->format('###-##-##-##')
                    ->disableValidation()
                    ->sortable(),

            Select::make(__('Gender'), 'gender')
                    ->options([
                    'male' => __('Male'),
                    'female' => __('Female'),
                    ]),
            Date::make(__('Birthday'), 'birthdate'),
            Number::make(__('Personal Number'), 'sid')
                ->sortable(),
            Select::make(__('Citizenship'), 'citizenship')
                ->options([
                    'georgia' => __('Georgia'),
                    'foreaign' => __('Foreign'),
                ]),

            Password::make(__('Password'), 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),
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

    /**
     * Determine if the given resource is authorizable.
     *
     * @return bool
     */
    public static function authorizable()
    {
        return false;
    }

    
}
