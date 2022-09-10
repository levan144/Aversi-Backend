<?php

// namespace App\Nova;

// use Illuminate\Http\Request;
// use Laravel\Nova\Fields\ID;
// use Laravel\Nova\Http\Requests\NovaRequest;
// use Laravel\Nova\Fields\Text;
// use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
// use Illuminate\Support\Facades\Storage;
// use Laravel\Nova\Panel;
// use Laravel\Nova\Fields\Image;
// use Laravel\Nova\Fields\Trix;
// use Stepanenko3\NovaJson\JSON;

// class StaticPage extends Resource
// {
//     /**
//      * The model the resource corresponds to.
//      *
//      * @var string
//      */
//     public static $model = \App\Models\StaticPage::class;
//     public static $group = 'Content';
//     /**
//      * The single value that should be used to represent the resource when being displayed.
//      *
//      * @var string
//      */
//     public static $title = 'title';
//     public static function label() {
//         return __('Static pages');
//     }

//     public static function singularLabel() {
//         return __('Static page');
//     }

//     /**
//      * The columns that should be searched.
//      *
//      * @var array
//      */
//     public static $search = [
//         'id','title'
//     ];

//     /**
//      * Get the fields displayed by the resource.
//      *
//      * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
//      * @return array
//      */
//     public function fields(NovaRequest $request)
//     {

//         return [
//         // ...
//         Text::make(__('Title'), 'title')->onlyOnIndex(),
//         NovaTabTranslatable::make([
//                 Text::make(__('Title'), 'title')
//                     ->rules('required_lang:ka'),
//             ])->hideFromIndex(),
//         new Panel(__('Content'), $this->aboutFields()),
//     ];
//     }

//     /**
//      * Get the about us fields for the resource.
//      *
//      * @return array
//      */

//     protected function aboutFields()
//     {
//         if($this->id === 3){
//             return [
//                 NovaTabTranslatable::make([
//                     Text::make('Street', 'content->ka->street')
//                 ])->hideFromIndex(),

                  
//             ];
//         }
//     }

//     /**
//      * Get the cards available for the request.
//      *
//      * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
//      * @return array
//      */
//     public function cards(NovaRequest $request)
//     {
//         return [];
//     }

//     /**
//      * Get the filters available for the resource.
//      *
//      * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
//      * @return array
//      */
//     public function filters(NovaRequest $request)
//     {
//         return [];
//     }

//     /**
//      * Get the lenses available for the resource.
//      *
//      * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
//      * @return array
//      */
//     public function lenses(NovaRequest $request)
//     {
//         return [];
//     }

//     /**
//      * Get the actions available for the resource.
//      *
//      * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
//      * @return array
//      */
//     public function actions(NovaRequest $request)
//     {
//         return [];
//     }

   
// }
