<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Stepanenko3\NovaJson\JSON;
use Michielfb\Time\Time;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\BelongsTo;
use App\Models\Service;
use App\Models\LaboratoryService;
use App\Models\Region;
use Outl1ne\MultiselectField\Multiselect;
use Storage;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Query\Search\SearchableJson;

class Branch extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Branch::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';
    public static $group = 'Content';

    public static function label() {
        return __('Branches');
    }

    public static function singularLabel() {
        return __('Branch');
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
            Select::make(__('Type'), 'type')->options(
                 ['clinic' => __('Clinic'), 'laboratory' => __('Laboratory')]
            ),
            NovaTabTranslatable::make([
                Text::make(__('Title'), 'title')
                    ->rules('required_lang:ka'),
                Trix::make(__('Content'), 'description')
                    ->rules('required_lang:ka'),
                
                Text::make(__('Address'), 'address')
                    ->rules('required_lang:ka'),
            ])->hideFromIndex(),
            BelongsTo::make(__('Region'), 'region', 'App\Nova\Region'),
            Text::make(__('Email'), 'email'),
            Text::make(__('Longitude'), 'longitude'),
            Text::make(__('Latitude'), 'latitude'),
            
            Image::make(__('Cover'), 'cover_image')
            ->disk('public')
            ->prunable()
            ->path('branch_images')
            ->preview(function ($value, $disk) {
                return $value
                            ? Storage::disk($disk)->url($value)
                            : null;
            }),

            Images::make(__('Photos'), 'photo')
                ->enableExistingMedia()
                ->withResponsiveImages()
                ->showStatistics()
                ->hideFromIndex(),
            
            Multiselect::make(__('Services'), 'service_ids')->options(
                 Service::all()->pluck('title', 'id')
            ),


            new Panel(__('Working Hours'), $this->workingHourFields()),
              
            ];

           
    }

    /**
     * Get the Working Hour Fields for the resource.
     *
     * @return array
     */
    protected function workingHourFields()
    {
        return [
            JSON::make(__('Working Hours'), 'working_time', [
                Text::make(__('Description'), 'description'),
                JSON::make(__('Monday'), 'mon', [
                    Select::make(__('Open'), 'open')->options($this->hourList()),
                    Select::make(__('Close'), 'close')->options($this->hourList()),
                ]),
                JSON::make(__('Tuesday'), 'tue', [
                    Select::make(__('Open'), 'open')->options($this->hourList()),
                    Select::make(__('Close'), 'close')->options($this->hourList()),
                ]),
                JSON::make(__('Wednesday'), 'wed', [
                    Select::make(__('Open'), 'open')->options($this->hourList()),
                    Select::make(__('Close'), 'close')->options($this->hourList()),
                ]),
                JSON::make(__('Thursday'), 'thu', [
                    Select::make(__('Open'), 'open')->options($this->hourList()),
                    Select::make(__('Close'), 'close')->options($this->hourList()),
                ]),
                JSON::make(__('Friday'), 'fri', [
                    Select::make(__('Open'), 'open')->options($this->hourList()),
                    Select::make(__('Close'), 'close')->options($this->hourList()),
                ]),
                JSON::make(__('Saturday'), 'sat', [
                    Select::make(__('Open'), 'open')->options($this->hourList()),
                    Select::make(__('Close'), 'close')->options($this->hourList()),
                ]),
                JSON::make(__('Sunday'), 'sun', [
                    Select::make(__('Open'), 'open')->options($this->hourList()),
                    Select::make(__('Close'), 'close')->options($this->hourList()),
                ]),
            ])->hideFromIndex(),
        ];
    }

    /**
     * Get the hours list for the request.
     *
     */
    public function hourList()
    {
        return [
            null => 'დასვენება',
            '09:00' =>  '09:00',
            '09:30' =>  '09:30',
            '10:00' =>  '10:00',
            '10:30' =>  '10:30',
            '11:00' =>  '11:00',
            '11:30' =>  '11:30',
            '12:00' =>  '12:00',
            '12:30' =>  '12:30',
            '13:00' =>  '13:00',
            '13:30' =>  '13:30',
            '14:00' =>  '14:00',
            '14:30' =>  '14:30',
            '15:00' =>  '15:00',
            '15:30' =>  '15:30',
            '16:00' =>  '16:00',
            '16:30' =>  '16:30',
            '17:00' =>  '17:00',
            '17:30' =>  '17:30',
            '18:00' =>  '18:00',
            '18:30' =>  '18:30',
            '19:00' =>  '19:00',
            '19:30' =>  '19:30',
            '20:00' =>  '20:00',
            '20:30' =>  '20:30',
            '21:00' =>  '21:00',
            '21:30' =>  '21:30',
            '22:00' =>  '22:00',
            '22:30' =>  '22:30',
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
