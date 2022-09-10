<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Trix;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Flexible;
// use Whitecube_lj\NovaFlexibleContent\Flexible as FlexibleLJ;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\HasMany;
use Outl1ne\MultiselectField\Multiselect;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Branch;
class Home extends AbstractType
{
    public function fields(): array
    {
        return [
            // Boolean::make('Param 1', 'param_1'),
            // Boolean::make('Param 2', 'param_2'),
            // Boolean::make('Param 3', 'param_3'),
            new Panel(__('Content'), $this->generalFields()),
            new Panel(__('Resources'), $this->modelFields()),

        ];
    }

    protected function generalFields()
    {
          
         

        return [
            new Tabs(__("Content"), [
                
                new Tab(__("Georgian"), [
                    Flexible::make(__('Slides'), 'slides_ka')
                        ->button(__('Add new'))
                        // ->addLayout(__('Video Slide'), 'video', [
                        //     Text::make(__('Title'), 'title'),
                        //     Textarea::make(__('Description'), 'description'),
                        //     Text::make(__('Youtube URL'), 'video')->hideFromIndex(),
                        //     Text::make(__('Link'), 'link'),
                        //     Select::make(__('Text Position'), 'text_position')->options([
                        //         'left' => __('Left'),
                        //         'center' => __('Center'),
                        //         'right' => __('Right'),
                        //     ])->rules('required')->hideFromIndex(),
                        // ])
                        ->addLayout(__('Photo Slide'), 'photo', [
                            Text::make(__('Title'), 'title'),
                            Textarea::make(__('Description'), 'description'),
                            Image::make(__('Image'), 'image_url')
                                ->disk('public')
                                ->prunable()
                                ->path('slides')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        ]),
                    
                    ]),

                new Tab(__("English"), [
                    Flexible::make(__('Slides'), 'slides_en')
                        ->button(__('Add new'))
                        ->addLayout(__('Video Slide'), 'video', [
                            Text::make(__('Title'), 'title'),
                            Textarea::make(__('Description'), 'description'),
                            Text::make(__('Youtube URL'), 'video')->hideFromIndex(),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        ])
                        ->addLayout(__('Photo Slide'), 'photo', [
                            Text::make(__('Title'), 'title'),
                            Textarea::make(__('Description'), 'description'),
                            Image::make(__('Image'), 'image_url')
                                ->disk('public')
                                ->prunable()
                                ->path('slides')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        ]),
                    ]),
                
                new Tab(__("Russian"), [
                    Flexible::make(__('Slides'), 'slides_ru')
                        ->button(__('Add new'))
                        ->addLayout(__('Video Slide'), 'video', [
                            Text::make(__('Title'), 'title'),
                            Textarea::make(__('Description'), 'description'),
                            Text::make(__('Youtube URL'), 'video')->hideFromIndex(),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        ])
                        ->addLayout(__('Photo Slide'), 'photo', [
                            Text::make(__('Title'), 'title'),
                            Textarea::make(__('Description'), 'description'),
                            Image::make(__('Image'), 'image_url')
                                ->disk('public')
                                ->prunable()
                                ->path('slides')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        
                    ]),
                ]),


               


            ]),


        ];
    }
    
    protected function modelFields()
    {
        return [
           Multiselect::make(__('Services'), 'services')->options(
                         Service::all()->pluck('title', 'id')
           ),
           Multiselect::make(__('Blogs'), 'blogs')->options(
                         Blog::all()->pluck('title', 'id')
           ),

           Flexible::make(__('Sections'), 'sections')
           ->button(__('Add new'))
           ->addLayout(__('Slider'), \App\Nova\Flexible\Layouts\OrderingLayoutSlider::class)
           ->addLayout(__('Services'), \App\Nova\Flexible\Layouts\OrderingLayoutService::class)
           ->addLayout(__('Laboratory'), \App\Nova\Flexible\Layouts\OrderingLayoutLab::class)
           ->addLayout(__('Blogs'), \App\Nova\Flexible\Layouts\OrderingLayoutBlog::class)
           ->addLayout(__('Branches'), \App\Nova\Flexible\Layouts\OrderingLayoutBranch::class),

           Multiselect::make(__('Branches'), 'branches')->options(
            Branch::where('type', 'clinic')->pluck('title', 'id')
            ),

            Multiselect::make(__('Laboratory'), 'laboratory')->options(
                Branch::where('type', 'laboratory')->pluck('title', 'id')
                ),
        ];
        
    }

}