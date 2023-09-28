<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\HasMany;
use \Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use \Itsmejoshua\Novaspatiepermissions\Role;
use \Itsmejoshua\Novaspatiepermissions\Permission;
use Dniccum\PhoneNumber\PhoneNumber;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;

class User extends Resource
{
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;
    public static $group = 'User Management';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static function label() {
        return __('Users');
    }

    public static function singularLabel() {
        return __('User');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make(__('Avatar'), 'avatar')->maxWidth(50),

            Text::make(__('Name'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            PhoneNumber::make(__('Phone number'), 'phone')
                ->format('###-##-##-##')
                ->disableValidation()
                ->sortable(),

            Text::make(__('Email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Select::make(__('Gender'), 'gender')
                ->options([
                'male' => 'Male',
                'female' => 'Female',
                ]),

//            Date::make(__('Birthday'), 'birthday'),

            Text::make(__('Personal Number'), 'sid')
                ->sortable()
                ->rules('required', 'max:11'),

            DateTime::make(__('Registered at'),'created_at')
                ->exceptOnForms(),

            DateTime::make(__('Last login'),'last_login_at')
                ->exceptOnForms(),

  //          Boolean::make(__('Verified'), 'phone_verified_at')
    //            ->trueValue(1, __('Yes'))
      //          ->falseValue(0, __('No')),

            Password::make(__('Password'), 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            MorphToMany::make(__('Roles'), 'roles', Role::class),
            MorphToMany::make(__('Permissions'), 'permissions', Permission::class),

        ];
    }



    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
